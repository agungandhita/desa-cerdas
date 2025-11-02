<header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 lg:px-6">
        <!-- Logo dan Toggle Sidebar -->
        <div class="flex items-center space-x-4">
            <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
                <i class="fas fa-bars text-slate-600"></i>
            </button>
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="w-8 h-8 rounded-lg">
                <h1 class="text-xl font-semibold text-slate-800 hidden sm:block">Admin Dashboard</h1>
            </div>
        </div>

        <!-- Menu Kanan -->
        <div class="flex items-center space-x-4">
            <!-- Notifikasi -->


            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profile-toggle" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700 hidden sm:block">Admin</span>
                    <i class="fas fa-chevron-down text-xs text-slate-500 hidden sm:block"></i>
                </button>

                <!-- Profile Dropdown Menu -->
                <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 hidden">
                    <div class="py-2">
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <i class="fas fa-user-circle mr-3 text-slate-400"></i>
                            Profile
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <i class="fas fa-cog mr-3 text-slate-400"></i>
                            Pengaturan
                        </a>
                        <hr class="my-2 border-slate-200">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-3 text-red-400"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
