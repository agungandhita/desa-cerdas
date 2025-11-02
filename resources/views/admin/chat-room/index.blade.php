@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Room Chat</h1>
                <p class="text-slate-600 mt-1">Kelola room chat dan diskusi</p>
            </div>
            <a href="{{ route('admin.chat-room.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Buat Room Baru
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Room</p>
                    <p class="text-xl font-bold text-slate-900">{{ $statistics['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-slate-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Room Aktif</p>
                    <p class="text-xl font-bold text-green-600">{{ $statistics['active'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Room Ditutup</p>
                    <p class="text-xl font-bold text-yellow-600">{{ $statistics['closed'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Room Private</p>
                    <p class="text-xl font-bold text-blue-600">{{ $statistics['private'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lock text-blue-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6">
        <form method="GET" action="{{ route('admin.chat-room.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label class="block text-sm font-medium text-slate-700 mb-2">Cari Room</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nama room atau topik..." 
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="min-w-40">
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </div>
            
            <div class="min-w-40">
                <label class="block text-sm font-medium text-slate-700 mb-2">Topik</label>
                <select name="topic" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Topik</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic }}" {{ request('topic') == $topic ? 'selected' : '' }}>
                            {{ ucfirst($topic) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.chat-room.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Chat Rooms List -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800">Daftar Room Chat</h3>
        </div>
        <div class="p-4">
            @if($chatRooms->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($chatRooms as $room)
                        <div class="bg-white border border-slate-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="text-lg font-semibold text-slate-800 truncate">{{ $room->name }}</h4>
                                <div class="relative">
                                    <button class="text-slate-400 hover:text-slate-600 p-1" onclick="toggleDropdown('dropdown-{{ $room->id }}')">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="dropdown-{{ $room->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                                        <a href="{{ route('admin.chat-room.show', $room) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                            <i class="fas fa-eye mr-2"></i>Lihat Chat
                                        </a>
                                        <a href="{{ route('admin.chat-room.edit', $room) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                        <div class="border-t border-slate-200"></div>
                                        <form action="{{ route('admin.chat-room.destroy', $room) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus room chat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                <i class="fas fa-trash mr-2"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $room->status == 'active' ? 'bg-green-100 text-green-800' : 
                                       ($room->status == 'closed' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-800') }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                                @if($room->is_private)
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        <i class="fas fa-lock mr-1"></i>Private
                                    </span>
                                @endif
                                @if($room->topic)
                                    <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-full">
                                        {{ ucfirst($room->topic) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Description -->
                            @if($room->description)
                                <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ Str::limit($room->description, 100) }}</p>
                            @endif

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                                <div>
                                    <div class="text-lg font-semibold text-slate-800">{{ $room->message_count ?? 0 }}</div>
                                    <div class="text-xs text-slate-500">Pesan</div>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-slate-800">{{ $room->participant_count ?? 0 }}</div>
                                    <div class="text-xs text-slate-500">Peserta</div>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-slate-800">{{ $room->last_activity_human ?? 'Baru' }}</div>
                                    <div class="text-xs text-slate-500">Terakhir</div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="border-t border-slate-200 pt-3">
                                <div class="flex justify-between items-center mb-2">
                                    <small class="text-slate-500">
                                        <i class="fas fa-user mr-1"></i>{{ $room->creator->name ?? 'Unknown' }}
                                    </small>
                                    <small class="text-slate-500">
                                        {{ $room->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.chat-room.show', $room) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded-lg text-sm transition-colors duration-200">
                                        <i class="fas fa-comments mr-1"></i>Buka Chat
                                    </a>
                                    <div class="relative">
                                        <button class="bg-slate-100 hover:bg-slate-200 text-slate-700 py-2 px-3 rounded-lg text-sm transition-colors duration-200" onclick="toggleDropdown('status-{{ $room->id }}')">
                                            Status
                                        </button>
                                        <div id="status-{{ $room->id }}" class="hidden absolute right-0 bottom-full mb-2 w-32 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                                            @if($room->status != 'active')
                                                <form action="{{ route('admin.chat-room.updateStatus', $room) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="active">
                                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-green-600 hover:bg-green-50">
                                                        <i class="fas fa-play mr-2"></i>Aktifkan
                                                    </button>
                                                </form>
                                            @endif
                                            @if($room->status != 'closed')
                                                <form action="{{ route('admin.chat-room.updateStatus', $room) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="closed">
                                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-yellow-600 hover:bg-yellow-50">
                                                        <i class="fas fa-pause mr-2"></i>Tutup
                                                    </button>
                                                </form>
                                            @endif
                                            @if($room->status != 'archived')
                                                <form action="{{ route('admin.chat-room.updateStatus', $room) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="archived">
                                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-slate-600 hover:bg-slate-50">
                                                        <i class="fas fa-archive mr-2"></i>Arsipkan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $chatRooms->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-comments text-6xl text-slate-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada room chat</h3>
                    <p class="text-slate-500 mb-4">Buat room chat pertama untuk memulai diskusi dengan warga.</p>
                    <a href="{{ route('admin.chat-room.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>Buat Room Chat
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"], [id^="status-"]');
    
    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== id) {
            d.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('button')) {
        const allDropdowns = document.querySelectorAll('[id^="dropdown-"], [id^="status-"]');
        allDropdowns.forEach(d => d.classList.add('hidden'));
    }
});
</script>
@endpush
