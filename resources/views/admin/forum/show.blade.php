@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.forum.index') }}" class="text-slate-600 hover:text-slate-800 transition-colors duration-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Detail Forum</h1>
                    <p class="text-slate-600 mt-1">Lihat dan kelola forum diskusi</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.forum.edit', $forum) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form action="{{ route('admin.forum.togglePin', $forum) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="fas fa-thumbtack"></i>
                        {{ $forum->is_pinned ? 'Unpin' : 'Pin' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Forum Content -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 mb-6">
        <div class="p-6">
            <!-- Forum Header -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        @if($forum->is_pinned)
                            <i class="fas fa-thumbtack text-purple-600"></i>
                        @endif
                        <h2 class="text-2xl font-bold text-slate-800">{{ $forum->judul }}</h2>
                    </div>
                    
                    <div class="flex items-center gap-4 text-sm text-slate-500 mb-4">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-user"></i>
                            <span>{{ $forum->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $forum->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-eye"></i>
                            <span>{{ $forum->views }} views</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-comments"></i>
                            <span>{{ $comments->count() }} komentar</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 text-sm font-medium rounded-full
                            @if($forum->status == 'active') bg-green-100 text-green-800
                            @elseif($forum->status == 'closed') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($forum->status) }}
                        </span>
                        <span class="px-3 py-1 text-sm font-medium bg-slate-100 text-slate-800 rounded-full">
                            {{ ucfirst($forum->kategori) }}
                        </span>
                    </div>
                </div>

                <!-- Status Actions -->
                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.forum.updateStatus', $forum) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                                class="px-3 py-1 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="active" {{ $forum->status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ $forum->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="closed" {{ $forum->status == 'closed' ? 'selected' : '' }}>Tertutup</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Forum Content -->
            <div class="prose max-w-none">
                <div class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $forum->isi }}</div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                <i class="fas fa-comments"></i>
                Komentar ({{ $comments->count() }})
            </h3>
        </div>

        @if($forum->status == 'active')
            <!-- Add Comment Form -->
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <form action="{{ route('admin.forum.storeComment', $forum) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="isi" class="block text-sm font-medium text-slate-700 mb-2">
                            Tambah Komentar
                        </label>
                        <textarea id="isi" 
                                  name="isi" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Tulis komentar Anda..."
                                  required></textarea>
                    </div>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Komentar
                    </button>
                </form>
            </div>
        @endif

        <!-- Comments List -->
        <div class="divide-y divide-slate-200">
            @forelse($comments as $comment)
                <div class="p-6">
                    <!-- Main Comment -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-slate-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-semibold text-slate-800">{{ $comment->user->name }}</span>
                                <span class="text-sm text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-slate-700 mb-3 whitespace-pre-wrap">{{ $comment->isi }}</div>
                            
                            <div class="flex items-center gap-4">
                                <button onclick="toggleReplyForm({{ $comment->id }})" 
                                        class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                    <i class="fas fa-reply"></i>
                                    Balas
                                </button>
                                <form action="{{ route('admin.forum.deleteComment', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-sm text-red-600 hover:text-red-800 flex items-center gap-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>

                            <!-- Reply Form -->
                            @if($forum->status == 'active')
                                <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 p-4 bg-slate-50 rounded-lg">
                                    <form action="{{ route('admin.forum.storeComment', $forum) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="mb-3">
                                            <textarea name="isi" 
                                                      rows="2"
                                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                      placeholder="Tulis balasan..."
                                                      required></textarea>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" 
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 text-sm rounded-lg transition-colors duration-200">
                                                Kirim
                                            </button>
                                            <button type="button" 
                                                    onclick="toggleReplyForm({{ $comment->id }})"
                                                    class="bg-slate-500 hover:bg-slate-600 text-white px-3 py-1 text-sm rounded-lg transition-colors duration-200">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <!-- Replies -->
                            @if($comment->replies->count() > 0)
                                <div class="mt-4 space-y-4">
                                    @foreach($comment->replies as $reply)
                                        <div class="flex items-start gap-4 pl-6 border-l-2 border-slate-200">
                                            <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-slate-600 text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="font-semibold text-slate-800">{{ $reply->user->name }}</span>
                                                    <span class="text-sm text-slate-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="text-slate-700 mb-2 whitespace-pre-wrap">{{ $reply->isi }}</div>
                                                <form action="{{ route('admin.forum.deleteComment', $reply) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-sm text-red-600 hover:text-red-800 flex items-center gap-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus balasan ini?')">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <i class="fas fa-comments text-4xl text-slate-400 mb-4"></i>
                    <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada komentar</h3>
                    <p class="text-slate-500">Jadilah yang pertama berkomentar di forum ini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('reply-form-' + commentId);
        form.classList.toggle('hidden');
        
        if (!form.classList.contains('hidden')) {
            form.querySelector('textarea').focus();
        }
    }
</script>
@endpush
@endsection