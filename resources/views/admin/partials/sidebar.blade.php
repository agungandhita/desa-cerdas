<aside id="sidebar" class="fixed left-0 top-0 z-30 h-screen w-60 bg-white border-r border-slate-200 shadow-sm transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 border-b border-slate-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-leaf text-white text-sm"></i>
            </div>
            <span class="text-lg font-semibold text-slate-800">Desa Cerdas</span>
        </div>
        <button id="sidebar-close" class="lg:hidden p-1 rounded hover:bg-slate-100">
            <i class="fas fa-times text-slate-600"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-6 px-4">
        <ul class="space-y-2">
            <li>
                <a href="/admin/dashboard" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-blue-700 bg-blue-50 border-r-2 border-blue-500">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.permohonan-surat.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.permohonan-surat.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-file-alt mr-3"></i>
                    Permohonan Surat
                    @if(isset($pendingCount) && $pendingCount > 0)
                    <span class="ml-auto bg-yellow-100 text-yellow-600 text-xs px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.berita.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.berita.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-newspaper mr-3"></i>
                    Berita Desa
                </a>
            </li>
            <li>
                <a href="{{ route('admin.chat-room.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.chat-room.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-comments mr-3"></i>
                    Room Chat
                </a>
            </li>
            <li>
                <a href="{{ route('admin.produk-umkm.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.produk-umkm.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-store mr-3"></i>
                    Produk UMKM
                </a>
            </li>
            <li>
                <a href="{{ route('admin.lokasi-desa.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.lokasi-desa.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-map-marker-alt mr-3"></i>
                    Lokasi Desa
                </a>
            </li>
            <li>
                <a href="{{ route('admin.apbdes.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-slate-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.apbdes.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <i class="fas fa-chart-pie mr-3"></i>
                    APB Desa
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                    <i class="fas fa-users mr-3"></i>
                    Kelola Pengguna
                </a>
            </li>
        </ul>

        <hr class="my-6 border-slate-200">

        <div class="mb-4">
            <h3 class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Pengaturan</h3>
            <ul class="space-y-2">
                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                        <i class="fas fa-cog mr-3"></i>
                        Konfigurasi
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                        <i class="fas fa-user-circle mr-3"></i>
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-200">
        <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-lg">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? 'admin@desacerdas.com' }}</p>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay untuk Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden"></div>
