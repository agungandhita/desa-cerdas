@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Pengguna</h1>
                <p class="text-slate-600 mt-1">Informasi akun dan peran</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-medium text-slate-500">Nama</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Email</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Nomor HP</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $user->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">NIK</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $user->nik ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Tanggal Lahir</p>
                    <p class="text-lg font-semibold text-slate-900">{{ optional($user->tanggal_lahir)->format('d M Y') ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-medium text-slate-500">Alamat</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $user->alamat ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Dibuat</p>
                    <p class="text-lg font-semibold text-slate-900">{{ optional($user->created_at)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Terakhir Diperbarui</p>
                    <p class="text-lg font-semibold text-slate-900">{{ optional($user->updated_at)->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Peran</h2>
            <div class="flex flex-wrap gap-2">
                @forelse($user->roles as $role)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ ucfirst($role->name) }}</span>
                @empty
                    <p class="text-slate-500">Tidak ada peran untuk pengguna ini</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection