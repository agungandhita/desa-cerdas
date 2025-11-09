@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.produk-umkm.index') }}" class="text-slate-600 hover:text-slate-800">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Detail Produk UMKM</h1>
                    <p class="text-slate-600 mt-1">{{ $produk->nama }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Status Badge -->
                @if($produk->status == 'active')
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Aktif</span>
                @elseif($produk->status == 'pending')
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Pending</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Tidak Aktif</span>
                @endif

                @if($produk->is_featured)
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        <i class="fas fa-star mr-1"></i>Unggulan
                    </span>
                @endif

                <!-- Action Buttons -->
                <a href="{{ route('admin.produk-umkm.edit', $produk) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Images -->
            @if($produk->foto && count($produk->foto) > 0)
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Foto Produk</h3>
                
                <!-- Main Image -->
                <div class="mb-4">
                    <img id="main-image" src="{{ asset('storage/' . $produk->fotoUtama) }}" alt="{{ $produk->nama }}" class="w-full h-64 object-cover rounded-lg border border-slate-200">
                </div>
                
                <!-- Thumbnail Images -->
                @if(count($produk->foto) > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($produk->foto as $index => $foto)
                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $index + 1 }}" 
                         class="w-full h-16 object-cover rounded cursor-pointer border-2 {{ $index === 0 ? 'border-blue-500' : 'border-slate-200' }} hover:border-blue-400 transition-colors"
                         onclick="changeMainImage('{{ asset('storage/' . $foto) }}', this)">
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            <!-- Product Description -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Deskripsi Produk</h3>
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($produk->deskripsi)) !!}
                </div>
            </div>

            <!-- Owner Information -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Pemilik</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-slate-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-slate-500"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-slate-800">{{ $produk->user->name }}</h4>
                        <p class="text-slate-600">{{ $produk->user->email }}</p>
                        @if($produk->kontak)
                        <p class="text-slate-600">
                            <i class="fas fa-phone mr-1"></i>{{ $produk->kontak }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Info Card -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Produk</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-slate-600">Harga</label>
                        <p class="text-2xl font-bold text-green-600">{{ $produk->hargaFormat }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-slate-600">Kategori</label>
                        <p class="text-slate-800">{{ $produk->kategori }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-slate-600">Stok</label>
                        <p class="text-slate-800">
                            {{ $produk->stok }} unit
                            @if($produk->stok == 0)
                                <span class="text-red-500 text-sm ml-2">(Habis)</span>
                            @elseif($produk->stok <= 5)
                                <span class="text-yellow-500 text-sm ml-2">(Stok Terbatas)</span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-slate-600">Kontak</label>
                        <p class="text-slate-800">{{ $produk->kontak }}</p>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Waktu</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-slate-600">Dibuat</label>
                        <p class="text-slate-800">{{ $produk->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-slate-600">Terakhir Diupdate</label>
                        <p class="text-slate-800">{{ $produk->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                
                <div class="space-y-3">
                    <!-- Toggle Featured -->
                    <form action="{{ route('admin.produk-umkm.toggleFeatured', $produk) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-4 py-2 {{ $produk->is_featured ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }} rounded-lg transition-colors duration-200">
                            <i class="fas fa-star mr-2"></i>
                            {{ $produk->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                        </button>
                    </form>

                    <!-- Change Status -->
                    @if($produk->status == 'pending')
                    <form action="{{ route('admin.produk-umkm.updateStatus', $produk) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="w-full px-4 py-2 bg-green-100 text-green-800 hover:bg-green-200 rounded-lg transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i>Setujui Produk
                        </button>
                    </form>
                    @elseif($produk->status == 'active')
                    <form action="{{ route('admin.produk-umkm.updateStatus', $produk) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="inactive">
                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-800 hover:bg-red-200 rounded-lg transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>Nonaktifkan
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.produk-umkm.updateStatus', $produk) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="w-full px-4 py-2 bg-green-100 text-green-800 hover:bg-green-200 rounded-lg transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i>Aktifkan
                        </button>
                    </form>
                    @endif

                    <!-- Delete -->
                    <form action="{{ route('admin.produk-umkm.destroy', $produk) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function changeMainImage(src, thumbnail) {
    // Update main image
    document.getElementById('main-image').src = src;
    
    // Update thumbnail borders
    document.querySelectorAll('.grid img').forEach(img => {
        img.classList.remove('border-blue-500');
        img.classList.add('border-slate-200');
    });
    
    thumbnail.classList.remove('border-slate-200');
    thumbnail.classList.add('border-blue-500');
}
</script>
@endsection