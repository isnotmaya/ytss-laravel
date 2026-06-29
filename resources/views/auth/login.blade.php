@extends('layouts.app')

@section('content')
    <main x-data="{ showPassword: false }"
        class="min-h-screen bg-[radial-gradient(circle_at_top_left,rgba(249,115,22,0.18),transparent_22%),radial-gradient(circle_at_bottom_right,rgba(217,138,58,0.14),transparent_28%),linear-gradient(180deg,#0a0a0a_0%,#120d09_48%,#080808_100%)] text-white">
        <div class="absolute inset-0 opacity-[0.04]"
            style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
        </div>

        <div class="relative z-10 flex min-h-screen flex-col">
            <header
                class="relative flex items-center justify-between gap-4 overflow-hidden border-b border-white/10 bg-[linear-gradient(to_right,#f97316,#f97316,#f97316)] px-4 py-3 shadow-[0_10px_40px_rgba(0,0,0,0.25)] md:px-8 md:py-4 lg:px-10">
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-b from-white/10 via-transparent to-black/5"></div>
                    <div
                        class="absolute -left-20 top-[-120px] h-[260px] w-[420px] rounded-full bg-orange-200/20 blur-3xl opacity-60">
                    </div>
                    <div
                        class="absolute right-[-120px] top-[-80px] h-[220px] w-[380px] rounded-full bg-orange-500/10 blur-3xl">
                    </div>
                    <div class="absolute inset-x-0 bottom-0 h-[28px] bg-gradient-to-b from-transparent to-black/20"></div>
                </div>

                <div class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between gap-3">
                    <a href="{{ url('/') }}" class="mx-auto md:hidden" aria-label="YTSS Academy">
                        <img src="/images/ytss_logo.png" alt="YTSS Soccer School" class="h-11 w-11 object-contain">
                    </a>

                    <a href="{{ url('/') }}" class="hidden items-center gap-3 md:flex">
                        <img src="/images/ytss_logo.png" alt="YTSS Soccer School" class="h-12 w-12 object-contain">
                        <div class="relative z-10">
                            <p class="font-['Barlow_Condensed'] text-2xl font-black uppercase tracking-[0.04em] text-white">
                                YTSS Academy
                            </p>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.32em] text-[#ffd3a0]/80">
                                Player Access Portal
                            </p>
                        </div>
                    </a>

                    <div class="relative z-10 hidden items-center gap-3 md:flex">
                        <a href="{{ url('/') }}"
                            class="rounded-full border border-white/15 bg-white/[0.05] px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/85 transition hover:border-white/30 hover:bg-white/[0.14] hover:text-white">
                            Kembali
                        </a>
                        <a href="{{ route('register') }}"
                            class="rounded-full border border-white/15 bg-[#4a2200] px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-[#5a2a03]">
                            Daftar
                        </a>
                    </div>
                </div>
            </header>

            <!-- Ambient Background Glows -->
            <div
                class="absolute top-10 left-10 w-[450px] h-[450px] bg-orange-500/10 blur-[120px] rounded-full pointer-events-none z-0">
            </div>
            <div
                class="absolute bottom-10 right-10 w-[450px] h-[450px] bg-orange-500/10 blur-[120px] rounded-full pointer-events-none z-0">
            </div>

            <div class="mx-auto flex w-full max-w-6xl flex-1 flex-col px-4 py-8 md:px-8 md:py-14 lg:px-10 relative z-10">
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 w-full items-center">

                    <!-- LEFT COLUMN: Academy Visual Value Propositions & Counters -->
                    <div
                        class="hidden lg:flex lg:col-span-6 flex-col justify-between p-8 xl:p-10 min-h-[580px] rounded-[30px] border border-white/[0.08] bg-[linear-gradient(180deg,rgba(249,115,22,0.05)_0%,rgba(12,10,8,0.95)_100%)] relative overflow-hidden shadow-2xl">
                        <!-- Ambient Inner Glow -->
                        <div class="absolute -left-20 -top-20 w-80 h-80 bg-orange-500/10 blur-[80px] rounded-full"></div>

                        <!-- Top Part: Logo & Branding -->
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <img src="/images/ytss_logo.png" alt="YTSS Soccer School Logo"
                                class="h-20 w-20 object-contain drop-shadow-[0_0_20px_rgba(249,115,22,0.25)]">
                            <h2
                                class="font-['Barlow_Condensed'] text-2xl font-black uppercase tracking-[0.06em] text-white mt-4">
                                YTSS SOCCER SCHOOL
                            </h2>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-orange-400 mt-1">
                                Player Access Portal
                            </p>
                        </div>

                        <!-- Middle Part: Counters Grid -->
                        <div class="relative z-10 grid grid-cols-3 gap-3 my-6">
                            <!-- Counter 1: Siswa Aktif -->
                            <div x-data="{
                                count: 0,
                                target: {{ $stats['siswa'] > 0 ? $stats['siswa'] : 500 }},
                                suffix: '{{ $stats['siswa'] > 0 ? '' : '+' }}',
                                init() {
                                    let observer = new IntersectionObserver((entries) => {
                                        if (entries[0].isIntersecting) {
                                            let start = 0;
                                            let end = this.target;
                                            let duration = 1200;
                                            let startTime = null;
                                            const animate = (timestamp) => {
                                                if (!startTime) startTime = timestamp;
                                                let progress = timestamp - startTime;
                                                let current = Math.min(Math.floor((progress / duration) * end), end);
                                                this.count = current;
                                                if (progress < duration) {
                                                    window.requestAnimationFrame(animate);
                                                } else {
                                                    this.count = end;
                                                }
                                            };
                                            window.requestAnimationFrame(animate);
                                            observer.disconnect();
                                        }
                                    }, { threshold: 0.1 });
                                    observer.observe(this.$el);
                                }
                            }"
                                class="flex flex-col items-center p-3 bg-white/[0.02] border border-white/5 rounded-2xl backdrop-blur-md">
                                <span class="font-['Barlow_Condensed'] text-3xl font-black text-orange-500"
                                    x-text="count + suffix">0</span>
                                <span
                                    class="text-[9px] font-bold uppercase tracking-wider text-white/50 mt-1 text-center">Siswa
                                    Aktif</span>
                            </div>

                            <!-- Counter 2: Prestasi -->
                            <div x-data="{
                                count: 0,
                                target: {{ $stats['prestasi'] > 0 ? $stats['prestasi'] : 50 }},
                                suffix: '{{ $stats['prestasi'] > 0 ? '' : '+' }}',
                                init() {
                                    let observer = new IntersectionObserver((entries) => {
                                        if (entries[0].isIntersecting) {
                                            let start = 0;
                                            let end = this.target;
                                            let duration = 1200;
                                            let startTime = null;
                                            const animate = (timestamp) => {
                                                if (!startTime) startTime = timestamp;
                                                let progress = timestamp - startTime;
                                                let current = Math.min(Math.floor((progress / duration) * end), end);
                                                this.count = current;
                                                if (progress < duration) {
                                                    window.requestAnimationFrame(animate);
                                                } else {
                                                    this.count = end;
                                                }
                                            };
                                            window.requestAnimationFrame(animate);
                                            observer.disconnect();
                                        }
                                    }, { threshold: 0.1 });
                                    observer.observe(this.$el);
                                }
                            }"
                                class="flex flex-col items-center p-3 bg-white/[0.02] border border-white/5 rounded-2xl backdrop-blur-md">
                                <span class="font-['Barlow_Condensed'] text-3xl font-black text-orange-500"
                                    x-text="count + suffix">0</span>
                                <span
                                    class="text-[9px] font-bold uppercase tracking-wider text-white/50 mt-1 text-center">Prestasi</span>
                            </div>

                            <!-- Counter 3: Kelompok Usia -->
                            <div x-data="{
                                count: 0,
                                target: {{ $stats['kelompok'] > 0 ? $stats['kelompok'] : 10 }},
                                suffix: '{{ $stats['kelompok'] > 0 ? '' : '+' }}',
                                init() {
                                    let observer = new IntersectionObserver((entries) => {
                                        if (entries[0].isIntersecting) {
                                            let start = 0;
                                            let end = this.target;
                                            let duration = 1200;
                                            let startTime = null;
                                            const animate = (timestamp) => {
                                                if (!startTime) startTime = timestamp;
                                                let progress = timestamp - startTime;
                                                let current = Math.min(Math.floor((progress / duration) * end), end);
                                                this.count = current;
                                                if (progress < duration) {
                                                    window.requestAnimationFrame(animate);
                                                } else {
                                                    this.count = end;
                                                }
                                            };
                                            window.requestAnimationFrame(animate);
                                            observer.disconnect();
                                        }
                                    }, { threshold: 0.1 });
                                    observer.observe(this.$el);
                                }
                            }"
                                class="flex flex-col items-center p-3 bg-white/[0.02] border border-white/5 rounded-2xl backdrop-blur-md">
                                <span class="font-['Barlow_Condensed'] text-3xl font-black text-orange-500"
                                    x-text="count + suffix">0</span>
                                <span
                                    class="text-[9px] font-bold uppercase tracking-wider text-white/50 mt-1 text-center">Kelompok
                                    Usia</span>
                            </div>
                        </div>

                        <!-- Bottom Part: Value Propositions -->
                        <div class="relative z-10 space-y-3 border-t border-white/10 pt-4">
                            <div class="grid grid-cols-2 gap-3">

                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.01] border border-white/5">
                                    <i data-lucide="shield-check"    class="w-4 h-4 text-orange-400 flex-shrink-0 icon-float-glow"></i>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-white/80">
                                        Pembinaan Profesional
                                    </span>
                                </div>

                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.01] border border-white/5">
                                    <i data-lucide="trophy" class="w-4 h-4 text-orange-400 flex-shrink-0 icon-float-glow"></i>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-white/80">
                                        Tournament & Liga
                                    </span>
                                </div>

                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.01] border border-white/5">
                                    <i data-lucide="goal" class="w-4 h-4 text-orange-400 flex-shrink-0 icon-float-glow"></i>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-white/80">
                                        Evaluasi Berkala
                                    </span>
                                </div>

                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.01] border border-white/5">
                                    <i data-lucide="users" class="w-4 h-4 text-orange-400 flex-shrink-0 icon-float-glow"></i>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-white/80">
                                        Pengembangan Karakter
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Login Form Container -->
                    <div class="w-full lg:col-span-6 flex justify-center">
                        <div
                            class="w-full max-w-xl rounded-[24px] border border-white/[0.08] bg-[linear-gradient(180deg,rgba(20,16,12,0.94)_0%,rgba(12,10,8,0.98)_100%)] p-5 shadow-[0_24px_80px_rgba(0,0,0,0.42)] backdrop-blur-xl md:rounded-[30px] md:p-8">

                            <!-- Modern Navigasi Tabs -->
                            <div class="mb-6 flex justify-center w-full">
                                <div class="grid grid-cols-2 gap-1.5 p-1 rounded-2xl md:flex md:rounded-full border border-white/10 bg-black/40 backdrop-blur-sm w-full md:w-auto">
                                    <a href="{{ route('login') }}"
                                        class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition bg-orange-500 text-white shadow-[0_0_15px_rgba(249,115,22,0.3)] whitespace-nowrap">
                                        Masuk
                                    </a>
                                    <a href="{{ route('register') }}"
                                        class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition text-white/60 hover:text-white whitespace-nowrap">
                                        Pendaftaran
                                    </a>
                                    <a href="{{ route('register.beasiswa') }}"
                                        class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition text-white/60 hover:text-white whitespace-nowrap">
                                        <span class="md:hidden">Beasiswa</span><span class="hidden md:inline">Ajukan Beasiswa</span>
                                    </a>
                                    <a href="{{ route('check-status') }}"
                                        class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition text-white/60 hover:text-white whitespace-nowrap">
                                        <span class="md:hidden">Status</span><span class="hidden md:inline">Cek Status</span>
                                    </a>
                                </div>
                            </div>

                            <div class="mb-6 text-center">
                                <p
                                    class="text-[10px] font-bold uppercase tracking-[0.32em] text-[#d98a3a]/75 flex items-center justify-center gap-1.5">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#d98a3a]"></i>
                                    Member Login
                                </p>
                                <h1
                                    class="mt-2 font-['Barlow_Condensed'] text-2xl font-black uppercase text-white tracking-wide flex items-center justify-center gap-2">
                                    <i data-lucide="lock" class="w-6 h-6 text-orange-500"></i>
                                    Welcome Back
                                </h1>
                                <p class="mt-2 text-xs leading-5 text-white/60">
                                    Masuk menggunakan email dan password akun orang tua atau pemain.
                                </p>
                            </div>

                            @if ($errors->any())
                                <div
                                    class="mb-4 rounded-lg bg-red-500/10 border border-red-500/30 p-3 text-xs text-red-300">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label
                                        class="mb-1.5 block text-[10px] font-bold uppercase tracking-[0.18em] text-white/70">
                                        Email
                                    </label>
                                    <div class="relative flex items-center">
                                        <div class="absolute left-4 text-white/40">
                                            <i data-lucide="mail" class="w-4 h-4 float-icon"></i>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            placeholder="nama@email.com"
                                            class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] py-3.5 pl-11 pr-4 text-xs text-white outline-none transition placeholder:text-white/25 focus:border-[#d98a3a]/40 focus:bg-white/[0.06]"
                                            required>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="mb-1.5 block text-[10px] font-bold uppercase tracking-[0.18em] text-white/70">
                                        Password
                                    </label>
                                    <div class="relative flex items-center w-full">
                                        <div class="absolute left-4 text-white/40 pointer-events-none">
                                            <i data-lucide="key-round" class="w-4 h-4 float-icon"></i>
                                        </div>
                                        <input :type="showPassword ? 'text' : 'password'" name="password"
                                            placeholder="Masukkan password"
                                            class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] py-3.5 pl-11 pr-12 text-xs text-white outline-none transition placeholder:text-white/25 focus:border-[#d98a3a]/40 focus:bg-white/[0.06]"
                                            required>
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-white/45 transition hover:text-white"
                                            :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'">
                                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="flex flex-col gap-2.5 text-xs text-white/60 sm:flex-row sm:items-center sm:justify-between">
                                    <label class="flex items-center gap-2 cursor-pointer select-none">
                                        <input type="checkbox"
                                            class="h-3.5 w-3.5 rounded border-white/20 bg-transparent text-[#d98a3a] focus:ring-0">
                                        <span>Ingat saya</span>
                                    </label>

                                    <button type="button"
                                        class="text-left text-[#ffcf97] transition hover:text-white sm:text-right">
                                        Lupa password?
                                    </button>
                                </div>

                                <button type="submit"
                                    class="w-full mt-2 rounded-[18px] bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] py-3.5 font-['Barlow_Condensed'] text-base font-bold uppercase tracking-[0.16em] text-white shadow-[0_16px_30px_rgba(249,115,22,0.2)] transition hover:brightness-105 flex items-center justify-center gap-2">
                                    <i data-lucide="log-in" class="w-5 h-5"></i>
                                    <span>Masuk</span>
                                </button>
                            </form>

                            <div class="mt-5 text-center text-xs leading-6 text-white/60">
                                Belum punya akun?
                                <a href="{{ route('register') }}"
                                    class="font-bold text-[#ffcf97] hover:text-white transition">
                                    Daftar di sini
                                </a>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="{{ url('/') }}"
                                    class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-[0.18em] text-white/40 transition hover:text-[#ffcf97]">
                                    <span class="text-[10px] leading-[1] -translate-y-[0.5px]">&larr;</span>
                                    Back to website
                                </a>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </main>
@endsection
