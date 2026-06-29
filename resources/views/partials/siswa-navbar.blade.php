@php
    $siswaModel = \App\Models\Siswa::where('kd_users', Auth::user()->kd_users)->first();
    $hasPhoto = $siswaModel && !empty($siswaModel->upload_foto) && file_exists(public_path($siswaModel->upload_foto));
@endphp

<header class="sticky top-0 z-30 bg-[#050505]/85 backdrop-blur-md border-b border-white/5 px-6 py-4 flex items-center justify-between">
    <!-- Mobile Menu Open Trigger -->
    <div class="flex items-center gap-4">
        <button @click="mobileMenuOpen = true" class="lg:hidden p-2 rounded-xl text-white/70 hover:text-white hover:bg-white/5 transition">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <div>
            <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white lg:text-3xl">
                STUDENT PORTAL
            </h2>
        </div>
    </div>

    <!-- User Section -->
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <p class="text-sm font-semibold text-white leading-tight">
                {{ Auth::user()->name }}
            </p>
            <p class="text-[10px] uppercase font-bold tracking-wider text-orange-500">
                Siswa
            </p>
        </div>
        @if($hasPhoto)
            <img src="{{ asset($siswaModel->upload_foto) }}" 
                 class="w-10 h-10 rounded-full border border-white/10 object-cover bg-neutral-900 shadow-lg" 
                 alt="Avatar">
        @else
            <div class="w-10 h-10 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-500 flex items-center justify-center font-bold text-sm uppercase heading-font">
                {{ Auth::user()->getInitials() }}
            </div>
        @endif
    </div>
</header>