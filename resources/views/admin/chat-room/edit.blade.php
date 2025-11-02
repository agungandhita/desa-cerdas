@extends('admin.layouts.main')

@section('title', 'Edit Room Chat: ' . $chatRoom->name)

@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-edit text-blue-600 mr-3"></i>
                Edit Room Chat
            </h1>
            <p class="text-gray-600 mt-1">Edit informasi dan pengaturan room chat</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.chat-room.show', $chatRoom) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-eye mr-2"></i>
                Lihat Room
            </a>
            <a href="{{ route('admin.chat-room.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Main Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Informasi Room Chat</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.chat-room.update', $chatRoom) }}" method="POST" id="chat-room-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name Field -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Room Chat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror" 
                                   id="name" name="name" value="{{ old('name', $chatRoom->name) }}" 
                                   placeholder="Masukkan nama room chat" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Deskripsi singkat tentang room chat ini">{{ old('description', $chatRoom->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Topic and Status Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                                    Topik
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('topic') border-red-300 @enderror" 
                                        id="topic" name="topic">
                                    <option value="">Pilih Topik</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic }}" {{ old('topic', $chatRoom->topic) == $topic ? 'selected' : '' }}>
                                            {{ ucfirst($topic) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('topic')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror" 
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status', $chatRoom->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="closed" {{ old('status', $chatRoom->status) == 'closed' ? 'selected' : '' }}>Ditutup</option>
                                    <option value="archived" {{ old('status', $chatRoom->status) == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Private Room Checkbox -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" 
                                           type="checkbox" id="is_private" name="is_private" 
                                           value="1" {{ old('is_private', $chatRoom->is_private) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_private" class="font-medium text-gray-700 flex items-center">
                                        <i class="fas fa-lock text-yellow-500 mr-2"></i>
                                        Room Private
                                    </label>
                                    <p class="text-gray-500">Jika dicentang, hanya pengguna yang dipilih yang dapat mengakses room ini.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Max Participants Field -->
                        <div class="mb-6">
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">
                                Maksimal Peserta
                            </label>
                            <input type="number" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_participants') border-red-300 @enderror" 
                                   id="max_participants" name="max_participants" 
                                   value="{{ old('max_participants', $chatRoom->max_participants) }}" 
                                   min="2" max="1000" placeholder="Kosongkan untuk tidak terbatas">
                            @error('max_participants')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Batas maksimal peserta yang dapat bergabung dalam room ini.</p>
                        </div>

                        <!-- Allowed Users Field -->
                        <div class="mb-6" id="private-options" 
                             style="{{ $chatRoom->is_private ? '' : 'display: none;' }}">
                            <label for="allowed_users" class="block text-sm font-medium text-gray-700 mb-2">
                                Pengguna yang Diizinkan
                            </label>
                            <select class="w-full @error('allowed_users') border-red-300 @enderror" 
                                    id="allowed_users" name="allowed_users[]" multiple>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                            {{ in_array($user->id, old('allowed_users', $chatRoom->allowed_users ?? [])) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('allowed_users')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Pilih pengguna yang diizinkan mengakses room private ini.</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Update Room Chat
                            </button>
                            <a href="{{ route('admin.chat-room.show', $chatRoom) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Room
                            </a>
                            <a href="{{ route('admin.chat-room.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <!-- Room Statistics -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                        Statistik Room
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg border-r border-gray-200">
                            <div class="text-2xl font-bold text-blue-600">{{ $chatRoom->message_count }}</div>
                            <div class="text-sm text-gray-600">Total Pesan</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $chatRoom->participant_count }}</div>
                            <div class="text-sm text-gray-600">Peserta</div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="text-center">
                            <p class="font-medium text-gray-700">Dibuat:</p>
                            <p class="text-gray-600">{{ $chatRoom->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-700">Aktivitas Terakhir:</p>
                            <p class="text-gray-600">{{ $chatRoom->last_activity_human }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cog text-yellow-600 mr-2"></i>
                        Pengaturan Saat Ini
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Status:</span>
                            <div>{!! $chatRoom->status_badge !!}</div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Tipe:</span>
                            <div>
                                @if($chatRoom->is_private)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-lock mr-1"></i> Private
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-globe mr-1"></i> Public
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($chatRoom->topic)
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Topik:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($chatRoom->topic) }}
                            </span>
                        </div>
                        @endif
                        @if($chatRoom->max_participants)
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Batas Peserta:</span>
                            <span class="text-gray-600">{{ $chatRoom->max_participants }} orang</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Pembuat:</span>
                            <span class="text-gray-600">{{ $chatRoom->creator->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-lg shadow-sm border border-red-200">
                <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                    <h3 class="text-lg font-semibold text-red-800 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Zona Berbahaya
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Tindakan berikut tidak dapat dibatalkan.</p>
                    <button type="button" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors" 
                            onclick="confirmDelete()">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Room Chat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="deleteModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus Room Chat</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 mb-4">
                    Apakah Anda yakin ingin menghapus room chat <strong>"{{ $chatRoom->name }}"</strong>?
                </p>
                <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800">
                                <strong>Peringatan:</strong> Semua pesan dalam room ini ({{ $chatRoom->message_count }} pesan) 
                                akan ikut terhapus dan tidak dapat dikembalikan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 gap-3">
                <button type="button" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors" 
                        onclick="closeDeleteModal()">
                    Batal
                </button>
                <form action="{{ route('admin.chat-room.destroy', $chatRoom) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        Ya, Hapus Room
                    </button>
                </form>
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
        const privateOptions = $('#private-options');
        if (this.checked) {
            privateOptions.removeClass('hidden').show();
        } else {
            privateOptions.addClass('hidden').hide();
            $('#max_participants').val('');
            $('#allowed_users').val(null).trigger('change');
        }
    });

    // Form validation
    $('#chat-room-form').on('submit', function(e) {
        let isValid = true;
        const name = $('#name').val().trim();

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

function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endpush