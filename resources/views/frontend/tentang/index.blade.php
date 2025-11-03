@extends('frontend.layouts.main')

@section('breadcrumb')
<div class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <div>
                        <a href="{{ route('beranda') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <span class="sr-only">Beranda</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">Tentang Desa</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">Tentang Desa</h1>
            <p class="mt-2 text-gray-600">Mengenal lebih dekat profil dan sejarah desa kami</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<!-- Village Profile Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Profil Desa</h2>
                <div class="prose prose-lg text-gray-600">
                    <p class="mb-4">
                        Desa Cerdas adalah sebuah desa yang terletak di wilayah yang strategis dengan potensi alam dan sumber daya manusia yang melimpah. Kami berkomitmen untuk menjadi desa yang modern, transparan, dan melayani masyarakat dengan sebaik-baiknya.
                    </p>
                    <p class="mb-4">
                        Dengan memanfaatkan teknologi informasi, kami berupaya memberikan pelayanan publik yang efisien dan mudah diakses oleh seluruh warga. Sistem informasi desa ini merupakan wujud nyata dari komitmen kami dalam mewujudkan good governance di tingkat desa.
                    </p>
                </div>
                
                <!-- Village Statistics -->
                <div class="mt-8 grid grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $lokasiDesa->jumlah_penduduk ?? '2,500' }}</div>
                        <div class="text-sm text-gray-600">Jumlah Penduduk</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $lokasiDesa->luas_wilayah ?? '15.5' }} km²</div>
                        <div class="text-sm text-gray-600">Luas Wilayah</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">8</div>
                        <div class="text-sm text-gray-600">Dusun</div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">24</div>
                        <div class="text-sm text-gray-600">RT/RW</div>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                @if($lokasiDesa && $lokasiDesa->gambar)
                <img src="{{ Storage::url($lokasiDesa->gambar) }}" alt="Foto Desa" 
                     class="w-full h-96 object-cover rounded-lg shadow-lg">
                @else
                <div class="w-full h-96 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg flex items-center justify-center">
                    <div class="text-center text-white">
                        <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819"></path>
                        </svg>
                        <h3 class="text-xl font-semibold">Desa Cerdas</h3>
                        <p class="text-blue-100">Desa Modern & Digital</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Visi & Misi</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Komitmen kami dalam membangun desa yang maju dan sejahtera</p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Vision -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Visi</h3>
                </div>
                <p class="text-gray-600 text-lg leading-relaxed">
                    "Mewujudkan Desa Cerdas sebagai desa yang maju, mandiri, dan sejahtera dengan memanfaatkan teknologi informasi untuk memberikan pelayanan terbaik kepada masyarakat."
                </p>
            </div>
            
            <!-- Mission -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Misi</h3>
                </div>
                <ul class="text-gray-600 space-y-3">
                    <li class="flex items-start">
                        <span class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        Meningkatkan kualitas pelayanan publik melalui digitalisasi
                    </li>
                    <li class="flex items-start">
                        <span class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        Mewujudkan transparansi dan akuntabilitas pemerintahan desa
                    </li>
                    <li class="flex items-start">
                        <span class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        Memberdayakan masyarakat melalui teknologi informasi
                    </li>
                    <li class="flex items-start">
                        <span class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        Mengembangkan potensi ekonomi lokal dan UMKM
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Village Officials Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Perangkat Desa</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Tim yang berdedikasi untuk melayani masyarakat</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Kepala Desa -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden text-center">
                <div class="p-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Budi Santoso, S.Sos</h3>
                    <p class="text-blue-600 font-medium mb-2">Kepala Desa</p>
                    <p class="text-sm text-gray-600">Memimpin dan mengkoordinasikan seluruh kegiatan pemerintahan desa</p>
                </div>
            </div>
            
            <!-- Sekretaris Desa -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden text-center">
                <div class="p-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Siti Aminah, S.AP</h3>
                    <p class="text-green-600 font-medium mb-2">Sekretaris Desa</p>
                    <p class="text-sm text-gray-600">Mengelola administrasi dan dokumentasi pemerintahan desa</p>
                </div>
            </div>
            
            <!-- Bendahara -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden text-center">
                <div class="p-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Ahmad Wijaya, S.E</h3>
                    <p class="text-purple-600 font-medium mb-2">Bendahara Desa</p>
                    <p class="text-sm text-gray-600">Mengelola keuangan dan anggaran desa</p>
                </div>
            </div>
            
            <!-- Kaur Pemerintahan -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden text-center">
                <div class="p-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Rina Sari, S.Sos</h3>
                    <p class="text-orange-600 font-medium mb-2">Kaur Pemerintahan</p>
                    <p class="text-sm text-gray-600">Menangani urusan pemerintahan dan kependudukan</p>
                </div>
            </div>
            
            <!-- Kaur Pembangunan -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden text-center">
                <div class="p-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Joko Susilo, S.T</h3>
                    <p class="text-red-600 font-medium mb-2">Kaur Pembangunan</p>
                    <p class="text-sm text-gray-600">Mengelola program pembangunan dan infrastruktur</p>
                </div>
            </div>
            
            <!-- Kaur Kesejahteraan -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden text-center">
                <div class="p-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Maya Indira, S.Sos</h3>
                    <p class="text-pink-600 font-medium mb-2">Kaur Kesejahteraan</p>
                    <p class="text-sm text-gray-600">Menangani program kesejahteraan masyarakat</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location & Contact Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi & Kontak</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Informasi lokasi dan cara menghubungi kami</p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Kontak</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Alamat</h4>
                            <p class="text-gray-600">{{ $lokasiDesa->alamat ?? 'Jl. Raya Desa No. 123, Kecamatan Contoh, Kabupaten Contoh, Provinsi Contoh 12345' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Telepon</h4>
                            <p class="text-gray-600">{{ $lokasiDesa->telepon ?? '(021) 1234-5678' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Email</h4>
                            <p class="text-gray-600">{{ $lokasiDesa->email ?? 'info@desacerdas.id' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Jam Pelayanan</h4>
                            <p class="text-gray-600">Senin - Jumat: 08:00 - 16:00 WIB<br>Sabtu: 08:00 - 12:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Map Placeholder -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Peta Lokasi</h3>
                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-sm">Peta Lokasi Desa</p>
                        <p class="text-xs text-gray-400 mt-1">Integrasi dengan Google Maps akan ditambahkan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection