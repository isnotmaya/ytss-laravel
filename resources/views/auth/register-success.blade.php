@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.18),transparent_20%),radial-gradient(circle_at_bottom_left,rgba(217,138,58,0.12),transparent_28%),linear-gradient(180deg,#090909_0%,#110d09_50%,#070707_100%)] text-white">
        <div class="absolute inset-0 opacity-[0.04]"
            style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
        </div>

        <div class="relative z-10 flex min-h-screen flex-col justify-center items-center px-4 py-12">
            <div class="w-full max-w-2xl rounded-[24px] border border-white/[0.08] bg-[linear-gradient(180deg,rgba(20,16,12,0.94)_0%,rgba(12,10,8,0.98)_100%)] p-8 text-center shadow-[0_24px_80px_rgba(0,0,0,0.42)] backdrop-blur-xl md:rounded-[30px] md:p-12">
                
                <!-- Success Checkmark Icon -->
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 mb-8">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-[#d98a3a]/75">Registrasi Berhasil</p>
                <h1 class="mt-3 font-['Barlow_Condensed'] text-4xl font-black uppercase text-white md:text-5xl tracking-wide">
                    PENDAFTARAN BERHASIL
                </h1>
                
                <p class="mt-4 text-sm leading-relaxed text-white/60 max-w-md mx-auto">
                    Terima kasih telah melakukan pendaftaran. Silakan simpan dan catat Kode Pendaftaran di bawah ini untuk melacak status persetujuan dari admin.
                </p>

                <!-- Kode Pendaftaran Box -->
                <div class="my-8 rounded-[20px] border border-orange-500/20 bg-orange-500/5 p-6 md:p-8">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#d98a3a]/80 mb-2">Kode Pendaftaran Anda</p>
                    <p class="font-['Barlow_Condensed'] text-4xl md:text-5xl font-black text-orange-500 tracking-wider select-all">
                        {{ session('kode_pendaftaran') }}
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('check-status') }}"
                        class="w-full sm:w-auto min-w-[180px] rounded-full bg-orange-500 hover:bg-orange-600 px-8 py-3.5 text-xs font-bold uppercase tracking-wider text-white transition shadow-[0_12px_24px_rgba(249,115,22,0.24)]">
                        Cek Status &rarr;
                    </a>
                    
                    <a href="{{ url('/') }}"
                        class="w-full sm:w-auto min-w-[180px] rounded-full border border-white/15 bg-white/[0.05] px-8 py-3.5 text-xs font-semibold uppercase tracking-wider text-white/85 transition hover:border-white/30 hover:bg-white/[0.14] hover:text-white">
                        Kembali Ke Home
                    </a>
                </div>

            </div>
        </div>
    </main>
@endsection