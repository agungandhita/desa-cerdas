@extends('frontend.layouts.main')

@section('title', $forum->judul)

@section('container')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('forum.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Forum Diskusi</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ Str::limit($forum->judul, 50) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Discussion Post -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                @if($forum->kategori)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                        {{ ucfirst($forum->kategori) }}
                                    </span>
                                @endif
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $forum->judul }}</h1>
                                <div class="flex items-center text-sm text-gray-600 space-x-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-2">
                                            {{ strtoupper(substr($forum->user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-medium">{{ $forum->user->name }}</span>
                                    </div>
                                    <span>{{ $forum->created_at->format('d M Y, H:i') }}</span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $forum->views }} views
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        {{ $forum->jumlah_komentar }} komentar
                                    </span>
                                </div>
                            </div>
                            @auth
                                @if(auth()->id() === $forum->user_id)
                                    <div class="flex space-x-2">
                                        <a href="{{ route('forum.edit', $forum) }}"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('forum.destroy', $forum) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskusi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($forum->isi)) !!}
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Komentar ({{ $forum->jumlah_komentar }})
                        </h2>
                    </div>

                    <!-- Comment Form -->
                    @auth
                        <div class="p-6 border-b border-gray-200 bg-gray-50">
                            <form action="{{ route('forum.comment.store', $forum) }}" method="POST">
                                @csrf
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <textarea name="isi"
                                                  rows="3"
                                                  placeholder="Tulis komentar Anda..."
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('isi') border-red-500 @enderror"
                                                  required>{{ old('isi') }}</textarea>
                                        @error('isi')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <div class="mt-3 flex justify-between items-center">
                                            <p class="text-sm text-gray-500">Gunakan bahasa yang sopan dan konstruktif</p>
                                            <button type="submit"
                                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300">
                                                Kirim Komentar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="p-6 border-b border-gray-200 bg-gray-50">
                            <div class="text-center">
                                <p class="text-gray-600 mb-4">Silakan login untuk memberikan komentar</p>
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Login
                                </a>
                            </div>
                        </div>
                    @endauth

                    <!-- Comments List -->
                    <div class="divide-y divide-gray-200">
                        @forelse($forum->komentars as $komentar)
                            <div class="p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($komentar->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <h4 class="font-medium text-gray-900">{{ $komentar->user->name }}</h4>
                                            <span class="text-sm text-gray-500">{{ $komentar->created_at->format('d M Y, H:i') }}</span>
                                            @if($komentar->created_at != $komentar->updated_at)
                                                <span class="text-xs text-gray-400">(diedit)</span>
                                            @endif
                                        </div>
                                        <div class="text-gray-700">
                                            {!! nl2br(e($komentar->isi)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-gray-500 mb-4">Belum ada komentar untuk diskusi ini</p>
                                @auth
                                    <p class="text-sm text-gray-400">Jadilah yang pertama memberikan komentar!</p>
                                @else
                                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login untuk memberikan komentar</a>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Author Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tentang Penulis</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                            {{ strtoupper(substr($forum->user->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $forum->user->name }}</p>
                            <p class="text-sm text-gray-600">Bergabung {{ $forum->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600">
                        <p>Total diskusi: {{ $forum->user->forums->count() }}</p>
                    </div>
                </div>

                <!-- Related Discussions -->
                @if($relatedForums->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Diskusi Terkait</h3>
                        <div class="space-y-4">
                            @foreach($relatedForums as $related)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <a href="{{ route('forum.show', $related) }}" class="block hover:bg-gray-50 -ml-4 pl-4 py-2 rounded-r">
                                        <h4 class="font-medium text-gray-900 text-sm mb-1 line-clamp-2">{{ $related->judul }}</h4>
                                        <div class="flex items-center text-xs text-gray-500 space-x-2">
                                            <span>{{ $related->user->name }}</span>
                                            <span>•</span>
                                            <span>{{ $related->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('forum.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Semua Diskusi
                        </a>
                        @auth
                            <a href="{{ route('forum.create') }}" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Diskusi Baru
                            </a>
                            <a href="{{ route('forum.my-discussions') }}" class="flex items-center text-purple-600 hover:text-purple-800 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Diskusi Saya
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login untuk Diskusi
                            </a>
                        @endauth
                        @if($forum->kategori)
                            <a href="{{ route('forum.category', $forum->kategori) }}" class="flex items-center text-orange-600 hover:text-orange-800 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Kategori {{ ucfirst($forum->kategori) }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize comment textarea
    const commentTextarea = document.querySelector('textarea[name="isi"]');
    if (commentTextarea) {
        commentTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }

    // Smooth scroll to comments when coming from notification
    if (window.location.hash === '#comments') {
        document.querySelector('.bg-white.rounded-lg.shadow-md:last-of-type').scrollIntoView({
            behavior: 'smooth'
        });
    }
});
</script>
@endsection
