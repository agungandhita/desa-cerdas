<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\KomentarForum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ForumController extends Controller
{
    /**
     * Display a listing of forum discussions
     */
    public function index(Request $request)
    {
        $query = Forum::with(['user', 'komentars']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by category if implemented
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Sorting
        $sortBy = $request->get('sort', 'terbaru');
        switch ($sortBy) {
            case 'populer':
                $query->withCount('komentars')
                      ->orderBy('komentars_count', 'desc')
                      ->orderBy('created_at', 'desc');
                break;
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $forums = $query->paginate(10);

        // Get popular discussions for sidebar
        $popularForums = Forum::withCount('komentars')
            ->orderBy('komentars_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent discussions for sidebar
        $recentForums = Forum::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.forum.index', compact('forums', 'popularForums', 'recentForums', 'sortBy'));
    }

    /**
     * Show the form for creating a new discussion
     */
    public function create()
    {
        if (!Auth::check()) {
            Alert::warning('Login Required', 'Silakan login terlebih dahulu untuk membuat diskusi baru.');
            return redirect()->route('login');
        }

        return view('frontend.forum.create');
    }

    /**
     * Store a newly created discussion
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            Alert::error('Error', 'Anda harus login terlebih dahulu.');
            return redirect()->route('login');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'nullable|string|max:100'
        ]);

        $forum = Forum::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori
        ]);

        Alert::success('Berhasil', 'Diskusi berhasil dibuat.');
        return redirect()->route('forum.show', $forum->id);
    }

    /**
     * Display the specified discussion
     */
    public function show($id)
    {
        $forum = Forum::with(['user', 'komentars.user'])
            ->findOrFail($id);

        // Get comments with pagination
        $komentars = KomentarForum::where('forum_id', $id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        // Get related discussions
        $relatedForums = Forum::where('id', '!=', $id)
            ->where(function($query) use ($forum) {
                if ($forum->kategori) {
                    $query->where('kategori', $forum->kategori);
                }
            })
            ->with('user')
            ->withCount('komentars')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.forum.show', compact('forum', 'komentars', 'relatedForums'));
    }

    /**
     * Store a comment on a discussion
     */
    public function storeComment(Request $request, $forumId)
    {
        if (!Auth::check()) {
            Alert::error('Error', 'Anda harus login terlebih dahulu.');
            return redirect()->route('login');
        }

        $request->validate([
            'isi' => 'required|string'
        ]);

        $forum = Forum::findOrFail($forumId);

        KomentarForum::create([
            'forum_id' => $forumId,
            'user_id' => Auth::id(),
            'isi' => $request->isi
        ]);

        Alert::success('Berhasil', 'Komentar berhasil ditambahkan.');
        return redirect()->route('forum.show', $forumId);
    }

    /**
     * Show the form for editing the specified discussion
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            Alert::warning('Login Required', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }

        $forum = Forum::findOrFail($id);

        // Check if user is the owner
        if ($forum->user_id !== Auth::id()) {
            Alert::error('Error', 'Anda tidak memiliki izin untuk mengedit diskusi ini.');
            return redirect()->route('forum.show', $id);
        }

        return view('frontend.forum.edit', compact('forum'));
    }

    /**
     * Update the specified discussion
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            Alert::error('Error', 'Anda harus login terlebih dahulu.');
            return redirect()->route('login');
        }

        $forum = Forum::findOrFail($id);

        // Check if user is the owner
        if ($forum->user_id !== Auth::id()) {
            Alert::error('Error', 'Anda tidak memiliki izin untuk mengedit diskusi ini.');
            return redirect()->route('forum.show', $id);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'nullable|string|max:100'
        ]);

        $forum->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori
        ]);

        Alert::success('Berhasil', 'Diskusi berhasil diperbarui.');
        return redirect()->route('forum.show', $id);
    }

    /**
     * Remove the specified discussion
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            Alert::error('Error', 'Anda harus login terlebih dahulu.');
            return redirect()->route('login');
        }

        $forum = Forum::findOrFail($id);

        // Check if user is the owner
        if ($forum->user_id !== Auth::id()) {
            Alert::error('Error', 'Anda tidak memiliki izin untuk menghapus diskusi ini.');
            return redirect()->route('forum.show', $id);
        }

        // Delete all comments first
        KomentarForum::where('forum_id', $id)->delete();
        
        // Delete the forum
        $forum->delete();

        Alert::success('Berhasil', 'Diskusi berhasil dihapus.');
        return redirect()->route('forum.index');
    }

    /**
     * Display discussions by category
     */
    public function category($kategori)
    {
        $forums = Forum::where('kategori', $kategori)
            ->with(['user', 'komentars'])
            ->withCount('komentars')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.forum.category', compact('forums', 'kategori'));
    }

    /**
     * Display user's discussions
     */
    public function myDiscussions()
    {
        if (!Auth::check()) {
            Alert::warning('Login Required', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }

        $forums = Forum::where('user_id', Auth::id())
            ->withCount('komentars')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.forum.my-discussions', compact('forums'));
    }
}