<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ChatRoomController extends Controller
{
    /**
     * Display a listing of chat rooms.
     */
    public function index(Request $request)
    {
        $query = ChatRoom::with(['creator', 'latestMessage.user']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan topic
        if ($request->has('topic') && $request->topic != '') {
            $query->where('topic', $request->topic);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('topic', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'last_activity');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'last_activity') {
            $query->orderByRaw('last_activity IS NULL, last_activity ' . $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $chatRooms = $query->paginate(12)->appends($request->query());

        // Statistics
        $statistics = [
            'total' => ChatRoom::count(),
            'active' => ChatRoom::where('status', 'active')->count(),
            'closed' => ChatRoom::where('status', 'closed')->count(),
            'archived' => ChatRoom::where('status', 'archived')->count(),
            'private' => ChatRoom::where('is_private', true)->count(),
        ];

        // Topics untuk filter
        $topics = ChatRoom::select('topic')->distinct()->whereNotNull('topic')->pluck('topic');

        return view('admin.chat-room.index', compact('chatRooms', 'statistics', 'topics'));
    }

    /**
     * Show the form for creating a new chat room.
     */
    public function create()
    {
        $topics = ['pembangunan', 'kesehatan', 'pendidikan', 'ekonomi', 'sosial', 'keamanan', 'lingkungan', 'umum'];
        $users = User::select('id', 'name', 'email')->get(); // Untuk private room

        return view('admin.chat-room.create', compact('topics', 'users'));
    }

    /**
     * Store a newly created chat room.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topic' => 'nullable|string|max:100',
            'status' => 'required|in:active,closed,archived',
            'is_private' => 'boolean',
            'max_participants' => 'nullable|integer|min:2|max:1000',
            'allowed_users' => 'nullable|array',
            'allowed_users.*' => 'exists:users,id',
        ]);

        $chatRoom = ChatRoom::create([
            'created_by' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'topic' => $request->topic,
            'status' => $request->status,
            'is_private' => $request->has('is_private'),
            'max_participants' => $request->max_participants,
            'allowed_users' => $request->allowed_users,
            'last_activity' => now(),
        ]);

        // Create system message
        ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => 'Room chat "' . $chatRoom->name . '" telah dibuat.',
            'message_type' => 'system'
        ]);

        Alert::success('Berhasil', 'Room chat berhasil dibuat!');
        return redirect()->route('admin.chat-room.index');
    }

    /**
     * Display the specified chat room with messages.
     */
    public function show(ChatRoom $chatRoom)
    {
        // Check if user can access this room
        if (!$chatRoom->canUserJoin(Auth::id())) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses ke room chat ini.');
            return redirect()->route('admin.chat-room.index');
        }

        $chatRoom->load(['creator']);

        // Update last activity
        $chatRoom->updateLastActivity();

        // Get messages with pagination (load more functionality)
        $messages = $chatRoom->messages()
            ->with(['user', 'replyTo.user'])
            ->orderBy('created_at', 'asc')
            ->paginate(50);

        // Mark messages as read
        foreach ($messages as $message) {
            $message->markAsRead(Auth::id());
        }

        // Get participants
        $participants = User::whereIn('id',
            $chatRoom->messages()->distinct('user_id')->pluck('user_id')
        )->get();

        return view('admin.chat-room.show', compact('chatRoom', 'messages', 'participants'));
    }

    /**
     * Show the form for editing the specified chat room.
     */
    public function edit(ChatRoom $chatRoom)
    {
        $topics = ['pembangunan', 'kesehatan', 'pendidikan', 'ekonomi', 'sosial', 'keamanan', 'lingkungan', 'umum'];
        $users = User::select('id', 'name', 'email')->get();

        return view('admin.chat-room.edit', compact('chatRoom', 'topics', 'users'));
    }

    /**
     * Update the specified chat room.
     */
    public function update(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topic' => 'nullable|string|max:100',
            'status' => 'required|in:active,closed,archived',
            'is_private' => 'boolean',
            'max_participants' => 'nullable|integer|min:2|max:1000',
            'allowed_users' => 'nullable|array',
            'allowed_users.*' => 'exists:users,id',
        ]);

        $chatRoom->update([
            'name' => $request->name,
            'description' => $request->description,
            'topic' => $request->topic,
            'status' => $request->status,
            'is_private' => $request->has('is_private'),
            'max_participants' => $request->max_participants,
            'allowed_users' => $request->allowed_users,
        ]);

        // Create system message for update
        ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => 'Pengaturan room chat telah diperbarui.',
            'message_type' => 'system'
        ]);

        Alert::success('Berhasil', 'Room chat berhasil diperbarui!');
        return redirect()->route('admin.chat-room.show', $chatRoom);
    }

    /**
     * Remove the specified chat room.
     */
    public function destroy(ChatRoom $chatRoom)
    {
        $chatRoom->delete();
        Alert::success('Berhasil', 'Room chat berhasil dihapus!');
        return redirect()->route('admin.chat-room.index');
    }

    /**
     * Update status chat room
     */
    public function updateStatus(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'status' => 'required|in:active,closed,archived'
        ]);

        $chatRoom->update(['status' => $request->status]);

        // Create system message
        $statusText = [
            'active' => 'diaktifkan',
            'closed' => 'ditutup',
            'archived' => 'diarsipkan'
        ];

        ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => 'Room chat telah ' . $statusText[$request->status] . '.',
            'message_type' => 'system'
        ]);

        Alert::success('Berhasil', 'Status room chat berhasil diperbarui!');
        return back();
    }

    /**
     * Send message to chat room
     */
    public function sendMessage(Request $request, ChatRoom $chatRoom)
    {
        // Check if user can access this room
        if (!$chatRoom->canUserJoin(Auth::id())) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        // Check if room is active
        if ($chatRoom->status !== 'active') {
            return response()->json(['error' => 'Room chat tidak aktif'], 400);
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:10240', // 10MB max
            'reply_to' => 'nullable|exists:chat_messages,id'
        ]);

        // At least message or file must be provided
        if (!$request->message && !$request->hasFile('file')) {
            return response()->json(['error' => 'Pesan atau file harus diisi'], 400);
        }

        $messageData = [
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => 'text',
            'reply_to' => $request->reply_to
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('chat-files', $fileName, 'public');
            
            $messageData['file_path'] = $filePath;
            $messageData['file_name'] = $file->getClientOriginalName();
            $messageData['file_size'] = $file->getSize();
            
            // Determine message type based on file
            $mimeType = $file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $messageData['message_type'] = 'image';
            } else {
                $messageData['message_type'] = 'file';
            }
        }

        $message = ChatMessage::create($messageData);

        // Update room last activity
        $chatRoom->updateLastActivity();

        // Load relationships for response
        $message->load(['user', 'replyTo.user']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'html' => view('admin.chat-room.partials.message', compact('message'))->render()
            ]);
        }

        return back();
    }

    /**
     * Upload file to chat room
     */
    public function uploadFile(Request $request, ChatRoom $chatRoom)
    {
        // Check if user can access this room
        if (!$chatRoom->canUserJoin(Auth::id())) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('chat-files', $fileName, 'public');

        $messageType = 'file';
        if ($file->getClientMimeType() && str_starts_with($file->getClientMimeType(), 'image/')) {
            $messageType = 'image';
        }

        $message = ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => 'File: ' . $file->getClientOriginalName(),
            'message_type' => $messageType,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName()
        ]);

        // Update room last activity
        $chatRoom->updateLastActivity();

        $message->load(['user']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'html' => view('admin.chat-room.partials.message', compact('message'))->render()
            ]);
        }

        return back();
    }

    /**
     * Get latest messages (for polling)
     */
    public function getMessages(Request $request, ChatRoom $chatRoom)
    {
        $lastMessageId = $request->get('last_message_id', 0);

        $messages = $chatRoom->messages()
            ->with(['user', 'replyTo.user'])
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        $html = '';
        foreach ($messages as $message) {
            $html .= view('admin.chat-room.partials.message', compact('message'))->render();
        }

        return response()->json([
            'messages' => $messages,
            'html' => $html,
            'last_message_id' => $messages->last()?->id ?? $lastMessageId
        ]);
    }

    /**
     * Update message
     */
    public function updateMessage(Request $request, ChatMessage $message)
    {
        // Only allow editing by message owner
        if ($message->user_id !== Auth::id()) {
            return response()->json(['error' => 'Tidak diizinkan'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message->update([
            'message' => $request->message,
            'is_edited' => true
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        Alert::success('Berhasil', 'Pesan berhasil diupdate!');
        return back();
    }

    /**
     * Delete message
     */
    public function deleteMessage(ChatMessage $message)
    {
        // Only allow deletion by message owner or admin
        $user = Auth::user();
        $isAdmin = method_exists($user, 'hasRole') && $user->hasRole('admin');
        
        if ($message->user_id !== Auth::id() && !$isAdmin) {
            return response()->json(['error' => 'Tidak diizinkan'], 403);
        }

        $message->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        Alert::success('Berhasil', 'Pesan berhasil dihapus!');
        return back();
    }
}
