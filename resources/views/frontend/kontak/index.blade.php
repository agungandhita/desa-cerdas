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
                        <span class="ml-4 text-sm font-medium text-gray-500">Kontak</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">Hubungi Kami</h1>
            <p class="mt-2 text-gray-600">Sampaikan pertanyaan, saran, atau keluhan Anda kepada kami</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<!-- Contact Form Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="nama@email.com">
                        </div>
                    </div>
                    
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="tel" id="telepon" name="telepon"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="08xxxxxxxxxx">
                    </div>
                    
                    <div>
                        <label for="subjek" class="block text-sm font-medium text-gray-700 mb-2">
                            Subjek <span class="text-red-500">*</span>
                        </label>
                        <select id="subjek" name="subjek" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Pilih subjek pesan</option>
                            <option value="layanan">Pertanyaan Layanan</option>
                            <option value="keluhan">Keluhan</option>
                            <option value="saran">Saran</option>
                            <option value="informasi">Permintaan Informasi</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="pesan" class="block text-sm font-medium text-gray-700 mb-2">
                            Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="pesan" name="pesan" rows="6" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                  placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="privacy" name="privacy" type="checkbox" required
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="privacy" class="text-gray-600">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-800">kebijakan privasi</a> dan penggunaan data pribadi saya untuk keperluan komunikasi.
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Pesan
                    </button>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Office Hours -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Jam Pelayanan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Senin - Jumat</span>
                            <span class="font-semibold text-gray-900">08:00 - 16:00 WIB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Sabtu</span>
                            <span class="font-semibold text-gray-900">08:00 - 12:00 WIB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Minggu</span>
                            <span class="font-semibold text-red-600">Tutup</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>Catatan:</strong> Untuk layanan darurat, silakan hubungi nomor telepon yang tersedia.
                        </p>
                    </div>
                </div>
                
                <!-- Contact Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
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
                                <h4 class="font-semibold text-gray-900">Alamat Kantor Desa</h4>
                                <p class="text-gray-600">Jl. Raya Desa No. 123<br>Kecamatan Contoh, Kabupaten Contoh<br>Provinsi Contoh 12345</p>
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
                                <p class="text-gray-600">(021) 1234-5678</p>
                                <p class="text-sm text-gray-500">Kantor Desa</p>
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
                                <p class="text-gray-600">info@desacerdas.id</p>
                                <p class="text-sm text-gray-500">Email resmi desa</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">WhatsApp</h4>
                                <p class="text-gray-600">+62 812-3456-7890</p>
                                <p class="text-sm text-gray-500">Layanan cepat via WhatsApp</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Emergency Contacts -->
                <div class="bg-red-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Kontak Darurat</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Polsek</span>
                            <span class="font-semibold text-gray-900">110</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pemadam Kebakaran</span>
                            <span class="font-semibold text-gray-900">113</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Ambulans</span>
                            <span class="font-semibold text-gray-900">118</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Kepala Desa</span>
                            <span class="font-semibold text-gray-900">+62 812-1111-2222</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan jawaban untuk pertanyaan yang paling sering ditanyakan</p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg shadow-md">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFAQ(1)">
                        <span class="font-semibold text-gray-900">Bagaimana cara mengurus surat keterangan?</span>
                        <svg id="faq-icon-1" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="faq-content-1" class="hidden px-6 pb-4">
                        <p class="text-gray-600">
                            Anda dapat mengajukan permohonan surat keterangan melalui menu "Layanan Publik" di website ini atau datang langsung ke kantor desa dengan membawa dokumen yang diperlukan seperti KTP, KK, dan dokumen pendukung lainnya sesuai jenis surat yang dibutuhkan.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg shadow-md">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFAQ(2)">
                        <span class="font-semibold text-gray-900">Berapa lama proses pengurusan dokumen?</span>
                        <svg id="faq-icon-2" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="faq-content-2" class="hidden px-6 pb-4">
                        <p class="text-gray-600">
                            Proses pengurusan dokumen umumnya memakan waktu 1-3 hari kerja tergantung jenis dokumen dan kelengkapan berkas. Untuk dokumen yang memerlukan verifikasi khusus, proses dapat memakan waktu hingga 7 hari kerja.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg shadow-md">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFAQ(3)">
                        <span class="font-semibold text-gray-900">Apakah ada biaya untuk pengurusan surat?</span>
                        <svg id="faq-icon-3" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="faq-content-3" class="hidden px-6 pb-4">
                        <p class="text-gray-600">
                            Sebagian besar layanan administrasi desa tidak dikenakan biaya (gratis). Namun, untuk beberapa jenis dokumen tertentu mungkin dikenakan biaya administrasi sesuai dengan peraturan yang berlaku. Informasi detail biaya dapat ditanyakan langsung ke petugas.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg shadow-md">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                            onclick="toggleFAQ(4)">
                        <span class="font-semibold text-gray-900">Bagaimana cara mengakses informasi APBDes?</span>
                        <svg id="faq-icon-4" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="faq-content-4" class="hidden px-6 pb-4">
                        <p class="text-gray-600">
                            Informasi APBDes dapat diakses melalui menu "APBDes" di website ini. Kami menyediakan data yang transparan mengenai anggaran pendapatan dan belanja desa, termasuk rincian per sektor dan perbandingan antar tahun.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-content')
<script>
function toggleFAQ(id) {
    const content = document.getElementById(`faq-content-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>
@endsection