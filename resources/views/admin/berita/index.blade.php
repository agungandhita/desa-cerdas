@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Berita Desa</h1>
                <p class="text-slate-600 mt-1">Kelola berita dan informasi desa</p>
            </div>
            <a href="{{ route('admin.berita.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Berita
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Berita</p>
                    <p class="text-xl font-bold text-slate-900">{{ $statistics['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-slate-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Published</p>
                    <p class="text-xl font-bold text-green-600">{{ $statistics['published'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Draft</p>
                    <p class="text-xl font-bold text-yellow-600">{{ $statistics['draft'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Featured</p>
                    <p class="text-xl font-bold text-purple-600">{{ $statistics['featured'] }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6">
        <form method="GET" action="{{ route('admin.berita.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Featured</label>
                <select name="is_featured" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                    <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Non-Featured</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Dari</label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.berita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Search -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6">
        <form method="GET" action="{{ route('admin.berita.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul, isi, atau penulis..." class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-search"></i>
                Cari
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Berita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($berita as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($item->cover)
                                <img src="{{ Storage::url($item->cover) }}" alt="Cover" class="w-12 h-12 rounded-lg object-cover mr-3">
                                @else
                                <div class="w-12 h-12 bg-slate-200 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-image text-slate-400"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-slate-900">{{ Str::limit($item->judul, 50) }}</div>
                                    <div class="text-sm text-slate-500">{{ $item->excerpt }}</div>
                                    @if($item->is_featured)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                                        <i class="fas fa-star mr-1"></i>
                                        Featured
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $item->author->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->status == 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Published
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Draft
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            {{ number_format($item->views) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            {{ $item->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.berita.show', $item) }}" class="text-blue-600 hover:text-blue-900" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.berita.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Toggle Featured -->
                                <form action="{{ route('admin.berita.toggleFeatured', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-purple-600 hover:text-purple-900" title="{{ $item->is_featured ? 'Remove from Featured' : 'Set as Featured' }}">
                                        <i class="fas fa-star{{ $item->is_featured ? '' : '-o' }}"></i>
                                    </button>
                                </form>

                                <!-- Toggle Status -->
                                <form action="{{ route('admin.berita.updateStatus', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $item->status == 'published' ? 'draft' : 'published' }}">
                                    <button type="submit" class="text-green-600 hover:text-green-900" title="{{ $item->status == 'published' ? 'Set as Draft' : 'Publish' }}">
                                        <i class="fas fa-{{ $item->status == 'published' ? 'eye-slash' : 'check' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-slate-500">
                                <i class="fas fa-newspaper text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Belum ada berita</p>
                                <p class="text-sm">Mulai dengan menambahkan berita pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($berita->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $berita->links() }}
        </div>
        @endif
    </div>
</div>
@endsection