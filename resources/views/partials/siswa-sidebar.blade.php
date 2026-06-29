<!-- Desktop Sidebar -->
<aside class="fixed left-0 top-0 z-40 h-screen w-[280px] bg-[#0c0c0c]/80 backdrop-blur-xl border-r border-white/5 hidden lg:flex flex-col">
    <!-- Sidebar Header / Logo -->
    <div class="p-6 border-b border-white/5 flex items-center gap-3.5">
        <img src="/images/ytss_logo.png" class="w-11 h-11 object-contain" alt="YTSS Logo">
        <div>
            <h1 class="heading-font text-2xl font-black uppercase tracking-wider text-white">YTSS ACADEMY</h1>
            <p class="text-[10px] uppercase font-bold tracking-[0.2em] text-orange-500">Member Portal</p>
        </div>
    </div>

    <!-- Sidebar Menu Links -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <a href="{{ route('siswa.dashboard') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.dashboard') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('siswa.profile') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.profile') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="user" class="w-4 h-4"></i>
            <span>Profil Saya</span>
        </a>

        <a href="{{ route('siswa.ortu') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.ortu') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="users" class="w-4 h-4"></i>
            <span>Data Orang Tua</span>
        </a>

        <a href="{{ route('siswa.kelompok-kelas') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.kelompok-kelas') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="shield" class="w-4 h-4"></i>
            <span>Kelompok Kelas</span>
        </a>

        <a href="{{ route('siswa.jadwal') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.jadwal') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="calendar-days" class="w-4 h-4"></i>
            <span>Jadwal Latihan</span>
        </a>

        <a href="{{ route('siswa.agenda') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.agenda') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="book-open" class="w-4 h-4"></i>
            <span>Agenda</span>
        </a>

        <a href="{{ route('siswa.tournament') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.tournament') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="trophy" class="w-4 h-4"></i>
            <span>Tournament</span>
        </a>

        <a href="{{ route('siswa.achievement') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.achievement') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03] hover:text-white' }}">
            <i data-lucide="medal" class="w-4 h-4"></i>
            <span>Prestasi</span>
        </a>
    </nav>

    <!-- Logout Area -->
    <div class="p-4 border-t border-white/5">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="flex items-center gap-3.5 w-full px-4 py-3 rounded-2xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition duration-200">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Overlay & Drawer (Alpine.js powered) -->
<div x-show="mobileMenuOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm lg:hidden"
     style="display: none;">
    
    <!-- Drawer Container -->
    <div @click.away="mobileMenuOpen = false" 
         x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed left-0 top-0 bottom-0 w-[280px] bg-[#0c0c0c] border-r border-white/5 flex flex-col z-50">
        
        <!-- Drawer Header -->
        <div class="p-6 border-b border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <img src="/images/ytss_logo.png" class="w-9 h-9 object-contain" alt="YTSS Logo">
                <div>
                    <h1 class="heading-font text-xl font-black uppercase tracking-wider text-white">YTSS ACADEMY</h1>
                </div>
            </div>
            <button @click="mobileMenuOpen = false" class="text-white/60 hover:text-white transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Drawer Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <a href="{{ route('siswa.dashboard') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.dashboard') ? 'bg-orange-500/10 text-orange-500' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('siswa.profile') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.profile') ? 'bg-orange-500/10 text-orange-500' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="user" class="w-4 h-4"></i>
                <span>Profil Saya</span>
            </a>

            <a href="{{ route('siswa.ortu') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.ortu') ? 'bg-orange-500/10 text-orange-500' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Data Orang Tua</span>
            </a>

            <a href="{{ route('siswa.kelompok-kelas') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.kelompok-kelas') ? 'bg-orange-500/10 text-orange-500' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="shield" class="w-4 h-4"></i>
                <span>Kelompok Kelas</span>
            </a>

            <a href="{{ route('siswa.jadwal') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.jadwal') ? 'bg-orange-500/10 text-orange-500' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="calendar-days" class="w-4 h-4"></i>
                <span>Jadwal Latihan</span>
            </a>

            <a href="{{ route('siswa.agenda') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.agenda') ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                <span>Agenda</span>
            </a>

            <a href="{{ route('siswa.tournament') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.tournament') ? 'bg-orange-500/10 text-orange-500' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="trophy" class="w-4 h-4"></i>
                <span>Tournament</span>
            </a>

            <a href="{{ route('siswa.achievement') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-medium transition duration-200 {{ request()->routeIs('siswa.achievement') ? 'bg-orange-500/10 text-orange-500' : 'text-white/60 hover:bg-white/[0.03]' }}">
                <i data-lucide="medal" class="w-4 h-4"></i>
                <span>Prestasi</span>
            </a>
        </nav>

        <!-- Drawer Logout -->
        <div class="p-4 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="flex items-center gap-3.5 w-full px-4 py-3 rounded-2xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition duration-200">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>