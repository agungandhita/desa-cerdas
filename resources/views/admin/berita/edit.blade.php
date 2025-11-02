@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.berita.index') }}" class="text-slate-600 hover:text-slate-900">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Berita</h1>
                <p class="text-slate-600 mt-1">Perbarui informasi berita</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-slate-700 mb-2">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('judul') border-red-500 @enderror"
                            placeholder="Masukkan judul berita">
                        @error('judul')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Isi Berita -->
                    <div>
                        <label for="isi" class="block text-sm font-medium text-slate-700 mb-2">
                            Isi Berita <span class="text-red-500">*</span>
                        </label>
                        <textarea id="isi" name="isi" required
                            class="froala-editor @error('isi') border-red-500 @enderror"
                            placeholder="Tulis isi berita di sini...">{{ old('isi', $berita->isi) }}</textarea>
                        @error('isi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Cover Image -->
                    <div class="bg-slate-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Cover Image</label>
                        <div class="space-y-3">
                            <!-- Current Image -->
                            @if($berita->cover)
                            <div id="current_image">
                                <img src="{{ Storage::url($berita->cover) }}" alt="Current Cover" class="w-full h-48 object-cover rounded-lg">
                                <button type="button" id="change_image" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit mr-1"></i>
                                    Ganti Gambar
                                </button>
                            </div>
                            @endif

                            <!-- File Input -->
                            <div id="file_input_container" class="{{ $berita->cover ? 'hidden' : '' }}">
                                <input type="file" id="cover" name="cover" accept="image/*"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cover') border-red-500 @enderror">
                                @error('cover')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <!-- Image Preview -->
                                <div id="image_preview" class="hidden mt-3">
                                    <img id="preview_img" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                                    <button type="button" id="remove_image" class="mt-2 text-sm text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-slate-50 p-4 rounded-lg">
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div class="bg-slate-50 p-4 rounded-lg">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $berita->is_featured) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm font-medium text-slate-700">Set as Featured</span>
                        </label>
                        <p class="text-xs text-slate-500 mt-1">Berita featured akan ditampilkan di halaman utama</p>
                    </div>

                    <!-- Published At -->
                    <div class="bg-slate-50 p-4 rounded-lg" id="published_at_container" style="display: {{ old('status', $berita->status) == 'published' ? 'block' : 'none' }};">
                        <label for="published_at" class="block text-sm font-medium text-slate-700 mb-2">
                            Tanggal Publish
                        </label>
                        <input type="datetime-local" id="published_at" name="published_at" 
                            value="{{ old('published_at', $berita->published_at ? $berita->published_at->format('Y-m-d\TH:i') : '') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-500 mt-1">Kosongkan untuk menggunakan waktu sekarang</p>
                    </div>

                    <!-- Meta Information -->
                    <div class="bg-slate-50 p-4 rounded-lg">
                        <h4 class="text-sm font-medium text-slate-700 mb-2">Informasi</h4>
                        <div class="space-y-2 text-sm text-slate-600">
                            <div class="flex justify-between">
                                <span>Penulis:</span>
                                <span>{{ $berita->author->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Dibuat:</span>
                                <span>{{ $berita->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Views:</span>
                                <span>{{ number_format($berita->views) }}</span>
                            </div>
                            @if($berita->slug)
                            <div class="flex justify-between">
                                <span>Slug:</span>
                                <span class="text-xs">{{ $berita->slug }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.berita.show', $berita) }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<!-- Froala Editor CSS -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_style.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<!-- Froala Editor JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Froala Editor
    new FroalaEditor('#isi', {
        // Editor configuration
        height: 400,
        placeholderText: 'Tulis isi berita di sini...',
        
        // Toolbar buttons
        toolbarButtons: {
            'moreText': {
                'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
            },
            'moreParagraph': {
                'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
            },
            'moreRich': {
                'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
            },
            'moreMisc': {
                'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help']
            }
        },
        
        // Image upload
        imageUploadURL: '{{ route('admin.berita.upload-image') }}',
        imageUploadParams: {
            _token: '{{ csrf_token() }}'
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024, // 5MB
        imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
        
        // File upload
        fileUploadURL: '{{ route('admin.berita.upload-file') }}',
        fileUploadParams: {
            _token: '{{ csrf_token() }}'
        },
        fileUploadMethod: 'POST',
        fileMaxSize: 10 * 1024 * 1024, // 10MB
        
        // Language
        language: 'id',
        
        // Events
        events: {
            'image.error': function (error, response) {
                console.error('Image upload error:', error, response);
            },
            'file.error': function (error, response) {
                console.error('File upload error:', error, response);
            }
        }
    });

    const statusSelect = document.getElementById('status');
    const publishedAtContainer = document.getElementById('published_at_container');
    const publishedAtInput = document.getElementById('published_at');
    const coverInput = document.getElementById('cover');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    const removeImageBtn = document.getElementById('remove_image');
    const changeImageBtn = document.getElementById('change_image');
    const currentImage = document.getElementById('current_image');
    const fileInputContainer = document.getElementById('file_input_container');

    // Handle status change
    statusSelect.addEventListener('change', function() {
        if (this.value === 'published') {
            publishedAtContainer.style.display = 'block';
            // Set current datetime if empty
            if (!publishedAtInput.value) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                publishedAtInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        } else {
            publishedAtContainer.style.display = 'none';
        }
    });

    // Handle change image button
    if (changeImageBtn) {
        changeImageBtn.addEventListener('click', function() {
            currentImage.classList.add('hidden');
            fileInputContainer.classList.remove('hidden');
        });
    }

    // Handle image preview
    if (coverInput) {
        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Handle remove image
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function() {
            coverInput.value = '';
            imagePreview.classList.add('hidden');
            previewImg.src = '';
            if (currentImage) {
                currentImage.classList.remove('hidden');
                fileInputContainer.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush
@endsection