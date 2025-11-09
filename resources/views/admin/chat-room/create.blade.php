@extends('admin.layouts.main')

@section('title', 'Buat Room Chat Baru')

@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                <i class="fas fa-plus mr-2"></i>Buat Room Chat Baru
            </h1>
            <p class="text-slate-600 mt-1">Buat room chat baru untuk diskusi dengan warga</p>
        </div>
        <a href="{{ route('admin.chat-room.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Main Form -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">Informasi Room Chat</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.chat-room.store') }}" method="POST" id="chatRoomForm">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Room Chat <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   id="name" name="name" value="{{ old('name') }}"
                                   placeholder="Masukkan nama room chat" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                            <textarea class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Deskripsi singkat tentang room chat ini">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="topic" class="block text-sm font-medium text-slate-700 mb-2">Topik</label>
                                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('topic') border-red-500 @enderror" id="topic" name="topic">
                                    <option value="">Pilih Topik</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic }}" {{ old('topic') == $topic ? 'selected' : '' }}>
                                            {{ ucfirst($topic) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('topic')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror" id="status" name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_private" name="is_private" value="1"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                       {{ old('is_private') ? 'checked' : '' }}>
                                <label for="is_private" class="ml-2 text-sm font-medium text-slate-700">
                                    <i class="fas fa-lock mr-1"></i> Room Private
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-slate-500">
                                Jika dicentang, hanya pengguna yang dipilih yang dapat mengakses room ini.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label for="max_participants" class="block text-sm font-medium text-slate-700 mb-2">Maksimal Peserta</label>
                            <input type="number"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_participants') border-red-500 @enderror"
                                   id="max_participants" name="max_participants" value="{{ old('max_participants') }}"
                                   min="2" max="1000" placeholder="Kosongkan untuk tidak terbatas">
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-slate-500">
                                Batas maksimal peserta yang dapat bergabung dalam room ini.
                            </p>
                        </div>

                        <div class="mb-6" id="allowed-users-group" style="display: none;">
                            <label for="allowed_users" class="block text-sm font-medium text-slate-700 mb-2">Pengguna yang Diizinkan</label>
                            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent select2 @error('allowed_users') border-red-500 @enderror"
                                    id="allowed_users" name="allowed_users[]" multiple>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            {{ in_array($user->id, old('allowed_users', [])) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('allowed_users')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-slate-500">
                                Pilih pengguna yang diizinkan mengakses room private ini.
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                                <i class="fas fa-save mr-2"></i>Buat Room Chat
                            </button>
                            <a href="{{ route('admin.chat-room.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <!-- Help Card -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 mb-6">
                <div class="p-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>Panduan
                    </h3>
                </div>
                <div class="p-6">
                    <h6 class="font-semibold text-slate-800 mb-3">Tips Membuat Room Chat:</h6>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="text-sm text-slate-600">Gunakan nama yang jelas dan mudah dipahami</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="text-sm text-slate-600">Pilih topik yang sesuai untuk memudahkan pencarian</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="text-sm text-slate-600">Atur status sesuai kebutuhan diskusi</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span class="text-sm text-slate-600">Gunakan room private untuk diskusi sensitif</span>
                        </li>
                    </ul>

                    <hr class="my-4 border-slate-200">

                    <h6 class="font-semibold text-slate-800 mb-3">Status Room:</h6>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">Aktif</span>
                            <span class="text-sm text-slate-600">Room dapat digunakan untuk chat</span>
                        </li>
                        <li class="flex items-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">Ditutup</span>
                            <span class="text-sm text-slate-600">Room tidak dapat menerima pesan baru</span>
                        </li>
                        <li class="flex items-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800 mr-2">Diarsipkan</span>
                            <span class="text-sm text-slate-600">Room disimpan untuk referensi</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Topic Examples -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">
                        <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>Contoh Topik
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="space-y-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Pembangunan</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Kesehatan</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Pendidikan</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Ekonomi</span>
                        </div>
                        <div class="space-y-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Sosial</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Keamanan</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Lingkungan</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Umum</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple {
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    min-height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3b82f6;
    border: 1px solid #3b82f6;
    color: white;
    border-radius: 0.375rem;
    padding: 0 0.5rem;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white;
    margin-right: 0.25rem;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #fecaca;
}

.select2-dropdown {
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for allowed users
    $('#allowed_users').select2({
        placeholder: 'Pilih pengguna yang diizinkan...',
        allowClear: true,
        width: '100%'
    });

    // Toggle private room options
    $('#is_private').change(function() {
        if ($(this).is(':checked')) {
            $('#allowed-users-group').show();
        } else {
            $('#allowed-users-group').hide();
            $('#max_participants').val('');
            $('#allowed_users').val(null).trigger('change');
        }
    });

    // Form validation
    $('#chatRoomForm').on('submit', function(e) {
        let isValid = true;
        const name = $('#name').val().trim();
        const description = $('#description').val().trim();

        // Clear previous errors
        $('.text-red-500').remove();
        $('.border-red-300').removeClass('border-red-300');

        // Validate name
        if (!name) {
            $('#name').addClass('border-red-300');
            $('#name').after('<p class="text-red-500 text-sm mt-1">Nama ruang chat wajib diisi.</p>');
            isValid = false;
        }

        // Validate private room settings
        if ($('#is_private').is(':checked')) {
            const maxParticipants = $('#max_participants').val();
            const allowedUsers = $('#allowed_users').val();

            if (maxParticipants && parseInt(maxParticipants) < 2) {
                $('#max_participants').addClass('border-red-300');
                $('#max_participants').after('<p class="text-red-500 text-sm mt-1">Maksimal peserta minimal 2 orang.</p>');
                isValid = false;
            }

            if (!allowedUsers || allowedUsers.length === 0) {
                $('#allowed_users').next('.select2-container').find('.select2-selection').addClass('border-red-300');
                $('#allowed_users').next('.select2-container').after('<p class="text-red-500 text-sm mt-1">Pilih minimal satu pengguna untuk ruang private.</p>');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Auto resize textarea
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    $('#description').on('input', function() {
        autoResize(this);
    });

    // Initialize textarea height
    autoResize(document.getElementById('description'));
});
</script>
@endpush
