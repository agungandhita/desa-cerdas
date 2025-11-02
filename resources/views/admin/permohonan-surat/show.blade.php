@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.permohonan-surat.index') }}" class="text-slate-600 hover:text-slate-900">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Detail Permohonan Surat #{{ $permohonanSurat->id }}</h1>
                    <p class="text-slate-600 mt-1">Informasi lengkap permohonan surat</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.permohonan-surat.edit', $permohonanSurat) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                @if($permohonanSurat->file_pdf)
                <a href="{{ route('admin.permohonan-surat.download', $permohonanSurat) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-download"></i>
                    Download PDF
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Informasi Permohonan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">ID Permohonan</label>
                            <p class="text-lg font-semibold text-slate-900">#{{ $permohonanSurat->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            @if($permohonanSurat->status == 'pending')
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>Pending
                                </span>
                            @elseif($permohonanSurat->status == 'diproses')
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-cog mr-2"></i>Diproses
                                </span>
                            @elseif($permohonanSurat->status == 'selesai')
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-2"></i>Selesai
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-2"></i>Ditolak
                                </span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Surat</label>
                            <p class="text-slate-900">{{ $permohonanSurat->jenis_surat }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Pengajuan</label>
                            <p class="text-slate-900">{{ $permohonanSurat->tanggal_pengajuan->format('d F Y, H:i') }}</p>
                        </div>
                        @if($permohonanSurat->tanggal_selesai)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai</label>
                            <p class="text-slate-900">{{ $permohonanSurat->tanggal_selesai->format('d F Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pemohon Info -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Informasi Pemohon</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <p class="text-slate-900">{{ $permohonanSurat->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <p class="text-slate-900">{{ $permohonanSurat->user->email }}</p>
                        </div>
                        @if($permohonanSurat->user->nik)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">NIK</label>
                            <p class="text-slate-900">{{ $permohonanSurat->user->nik }}</p>
                        </div>
                        @endif
                        @if($permohonanSurat->user->no_hp)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">No. HP</label>
                            <p class="text-slate-900">{{ $permohonanSurat->user->no_hp }}</p>
                        </div>
                        @endif
                        @if($permohonanSurat->user->alamat)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                            <p class="text-slate-900">{{ $permohonanSurat->user->alamat }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Keperluan -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Keperluan</h3>
                </div>
                <div class="p-6">
                    <p class="text-slate-900 leading-relaxed">{{ $permohonanSurat->keperluan }}</p>
                </div>
            </div>

            @if($permohonanSurat->catatan)
            <!-- Catatan -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Catatan Admin</h3>
                </div>
                <div class="p-6">
                    <p class="text-slate-900 leading-relaxed">{{ $permohonanSurat->catatan }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Status Update -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Update Status</h3>
                </div>
                <form action="{{ route('admin.permohonan-surat.update-status', $permohonanSurat) }}" method="POST" class="p-6">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="pending" {{ $permohonanSurat->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diproses" {{ $permohonanSurat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $permohonanSurat->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $permohonanSurat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                            <textarea name="catatan" id="catatan" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tambahkan catatan...">{{ $permohonanSurat->catatan }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            <!-- File Info -->
            @if($permohonanSurat->file_pdf)
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">File Surat</h3>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <i class="fas fa-file-pdf text-4xl text-red-500 mb-4"></i>
                        <p class="text-sm font-medium text-slate-900 mb-2">File PDF Tersedia</p>
                        <a href="{{ route('admin.permohonan-surat.download', $permohonanSurat) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-download"></i>
                            Download File
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">File Surat</h3>
                </div>
                <div class="p-6">
                    <div class="text-center text-slate-500">
                        <i class="fas fa-file-alt text-4xl mb-4"></i>
                        <p class="text-sm">Belum ada file yang diupload</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-plus text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Permohonan Dibuat</p>
                                <p class="text-xs text-slate-500">{{ $permohonanSurat->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($permohonanSurat->status == 'diproses')
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-cog text-yellow-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Sedang Diproses</p>
                                <p class="text-xs text-slate-500">{{ $permohonanSurat->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($permohonanSurat->status == 'selesai' && $permohonanSurat->tanggal_selesai)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Selesai</p>
                                <p class="text-xs text-slate-500">{{ $permohonanSurat->tanggal_selesai->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($permohonanSurat->status == 'ditolak')
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-times text-red-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Ditolak</p>
                                <p class="text-xs text-slate-500">{{ $permohonanSurat->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection