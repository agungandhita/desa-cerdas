@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Forum Diskusi</h1>
                <p class="text-slate-600 mt-1">Kelola forum diskusi dan komunikasi warga</p>
            </div>
            <a href="{{ route('admin.forum.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Buat Forum Baru
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Forum</p>
                    <p class="text-xl font-bold text-slate-900">{{ $statistics['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-slate-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Aktif</p>
                    <p class="text-xl font-bold text-green-600">{{ $statistics['active'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Tertutup</p>
                    <p class="text-xl font-bold text-red-600">{{ $statistics['closed'] }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Pending</p>
                    <p class="text-xl font-bold text-yellow-600">{{ $statistics['pending'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Di-pin</p>
                    <p class="text-xl font-bold text-purple-600">{{ $statistics['pinned'] }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-thumbtack text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label class="block text-sm font-medium text-slate-700 mb-1">Cari Forum</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan judul atau isi..." 
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="min-w-40">
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Tertutup</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <div class="min-w-40">
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ ucfirst($kategori) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.forum.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Forum List -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800">Daftar Forum</h3>
        </div>
        
        @if($forums->count() > 0)
            <div class="divide-y divide-slate-200">
                @foreach($forums as $forum)
                    <div class="p-4 hover:bg-slate-50 transition-colors duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    @if($forum->is_pinned)
                                        <i class="fas fa-thumbtack text-purple-600"></i>
                                    @endif
                                    <h4 class="text-lg font-semibold text-slate-800 hover:text-blue-600">
                                        <a href="{{ route('admin.forum.show', $forum) }}">{{ $forum->judul }}</a>
                                    </h4>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($forum->status == 'active') bg-green-100 text-green-800
                                        @elseif($forum->status == 'closed') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($forum->status) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-800 rounded-full">
                                        {{ ucfirst($forum->kategori) }}
                                    </span>
                                </div>
                                
                                <p class="text-slate-600 mb-3 line-clamp-2">{{ $forum->excerpt }}</p>
                                
                                <div class="flex items-center gap-4 text-sm text-slate-500">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $forum->user->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $forum->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ $forum->views }} views</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-comments"></i>
                                        <span>{{ $forum->jumlah_komentar }} komentar</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 ml-4">
                                <a href="{{ route('admin.forum.show', $forum) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.forum.edit', $forum) }}" 
                                   class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-50 transition-colors duration-200"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.forum.togglePin', $forum) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-purple-600 hover:text-purple-800 p-2 rounded-lg hover:bg-purple-50 transition-colors duration-200"
                                            title="{{ $forum->is_pinned ? 'Unpin' : 'Pin' }}">
                                        <i class="fas fa-thumbtack {{ $forum->is_pinned ? 'text-purple-600' : 'text-slate-400' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.forum.destroy', $forum) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                            title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus forum ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="p-4 border-t border-slate-200">
                {{ $forums->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <i class="fas fa-comments text-4xl text-slate-400 mb-4"></i>
                <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada forum</h3>
                <p class="text-slate-500 mb-4">Mulai diskusi dengan membuat forum baru</p>
                <a href="{{ route('admin.forum.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Buat Forum Baru
                </a>
            </div>
        @endif
    </div>
</div>
@endsection