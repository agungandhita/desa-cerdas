@extends('frontend.layouts.main')

@section('container')
    <!-- Hero Section -->
    <section class="relative h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] xl:h-[500px] flex items-center justify-center text-center text-white" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2232&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 p-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-tight mb-2">
                Tentang Desa Cerdas
            </h1>
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl font-light max-w-3xl mx-auto">
                Mengenal lebih dekat profil, sejarah, dan visi-misi desa kami.
            </p>
        </div>
    </section>


    <!-- Village Profile Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Profil Desa Cerdas</h2>
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
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $lokasiDesa->jumlah_penduduk ?? '2,500+' }}</div>
                            <div class="text-sm text-gray-600 mt-1">Jumlah Penduduk</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $lokasiDesa->luas_wilayah ?? '15.5' }} km²</div>
                            <div class="text-sm text-gray-600 mt-1">Luas Wilayah</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-purple-600">8</div>
                            <div class="text-sm text-gray-600 mt-1">Dusun</div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-orange-600">24</div>
                            <div class="text-sm text-gray-600 mt-1">RT/RW</div>
                        </div>
                    </div>
                </div>

                <div class="relative order-1 lg:order-2">
                    @if($lokasiDesa && $lokasiDesa->gambar)
                    <img src="{{ Storage::url($lokasiDesa->gambar) }}" alt="Foto Desa"
                         class="w-full h-auto object-cover rounded-lg shadow-lg">
                    @else
                    <img src="https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Foto Desa"
                         class="w-full h-auto object-cover rounded-lg shadow-lg">
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

            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <!-- Vision -->
                <div class="bg-white rounded-lg shadow-md p-8 border-l-4 border-blue-500">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Visi</h3>
                    </div>
                    <blockquote class="text-gray-600 text-lg leading-relaxed italic border-l-4 border-gray-200 pl-4">
                        "Mewujudkan Desa Cerdas sebagai desa yang maju, mandiri, dan sejahtera dengan memanfaatkan teknologi informasi untuk memberikan pelayanan terbaik kepada masyarakat."
                    </blockquote>
                </div>

                <!-- Mission -->
                <div class="bg-white rounded-lg shadow-md p-8 border-l-4 border-green-500">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Misi</h3>
                    </div>
                    <ul class="text-gray-600 space-y-4">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Meningkatkan kualitas pelayanan publik melalui <strong>digitalisasi</strong>.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Mewujudkan <strong>transparansi</strong> dan <strong>akuntabilitas</strong> pemerintahan desa.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Memberdayakan masyarakat melalui <strong>teknologi informasi</strong>.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Mengembangkan <strong>potensi ekonomi lokal</strong> dan UMKM.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Village Officials Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Perangkat Desa</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Tim yang berdedikasi untuk melayani dan memajukan desa.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Official Card -->
                <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden text-center transition-transform transform hover:scale-105">
                    <div class="relative h-40 bg-blue-200">
                        <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=1780&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="w-full h-full object-cover" alt="Foto Kepala Desa">
                    </div>
                    <div class="p-6 relative">
                        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                            <img class="w-24 h-24 rounded-full border-4 border-white shadow-md" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Budi Santoso">
                        </div>
                        <div class="mt-10">
                            <h3 class="text-xl font-semibold text-gray-900 mb-1">Budi Santoso, S.Sos</h3>
                            <p class="text-blue-600 font-medium mb-3">Kepala Desa</p>
                            <p class="text-sm text-gray-600">Memimpin dan mengkoordinasikan seluruh kegiatan pemerintahan desa untuk kemajuan bersama.</p>
                        </div>
                    </div>
                </div>

                <!-- Official Card -->
                <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden text-center transition-transform transform hover:scale-105">
                    <div class="relative h-40 bg-green-200">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="w-full h-full object-cover" alt="Foto Sekretaris Desa">
                    </div>
                    <div class="p-6 relative">
                        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                            <img class="w-24 h-24 rounded-full border-4 border-white shadow-md" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Siti Aminah">
                        </div>
                        <div class="mt-10">
                            <h3 class="text-xl font-semibold text-gray-900 mb-1">Siti Aminah, S.AP</h3>
                            <p class="text-green-600 font-medium mb-3">Sekretaris Desa</p>
                            <p class="text-sm text-gray-600">Mengelola administrasi dan dokumentasi untuk mendukung kelancaran pemerintahan desa.</p>
                        </div>
                    </div>
                </div>

                <!-- Official Card -->
                <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden text-center transition-transform transform hover:scale-105">
                    <div class="relative h-40 bg-purple-200">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="w-full h-full object-cover" alt="Foto Bendahara Desa">
                    </div>
                    <div class="p-6 relative">
                        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                            <img class="w-24 h-24 rounded-full border-4 border-white shadow-md" src="https://randomuser.me/api/portraits/men/34.jpg" alt="Ahmad Wijaya">
                        </div>
                        <div class="mt-10">
                            <h3 class="text-xl font-semibold text-gray-900 mb-1">Ahmad Wijaya, S.E</h3>
                            <p class="text-purple-600 font-medium mb-3">Bendahara Desa</p>
                            <p class="text-sm text-gray-600">Mengelola keuangan dan anggaran desa secara transparan dan akuntabel.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Desa</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan kami di peta</p>
            </div>
            <div class="aspect-w-16 aspect-h-9 rounded-lg shadow-lg overflow-hidden">
                @if($lokasiDesa && $lokasiDesa->latitude && $lokasiDesa->longitude)
                <iframe src="https://maps.google.com/maps?q={{ $lokasiDesa->latitude }},{{ $lokasiDesa->longitude }}&hl=id&z=14&amp;output=embed"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                @else
                <div class="bg-gray-200 flex items-center justify-center">
                    <p class="text-gray-500">Peta lokasi akan ditampilkan di sini.</p>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
