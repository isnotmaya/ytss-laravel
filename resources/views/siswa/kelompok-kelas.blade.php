@extends('layouts.siswa')

@section('content')
<div class="space-y-10">
    <!-- PAGE TITLE -->
    <div>
        <h1 class="heading-font text-4xl lg:text-5xl font-black uppercase tracking-wider text-white">
            KELOMPOK KELAS SAYA
        </h1>
        <p class="text-sm text-white/50 mt-1">
            Informasi kategori pembinaan sepak bola kelompok umur Anda yang terdaftar di YTSS.
        </p>
    </div>

    @if($kelompok)
        <!-- HERO SECTION -->
        <div class="relative overflow-hidden rounded-[32px] border border-white/5 h-64 md:h-80 w-full bg-neutral-900 shadow-2xl">
            @if($kelompok->banner_exists)
                <img src="{{ asset($kelompok->upload_kelompok_kelas) }}" 
                     class="w-full h-full object-cover" 
                     alt="{{ $kelompok->nama_kelompok }}">
            @else
                <div class="w-full h-full bg-gradient-to-r from-orange-600/30 via-orange-500/10 to-transparent flex flex-col items-center justify-center p-6 text-center text-orange-400">
                    <i data-lucide="shield" class="w-20 h-20 mb-3 opacity-60 float-icon"></i>
                    <h2 class="heading-font text-3xl font-black uppercase tracking-widest">YTSS SOCCER SCHOOL</h2>
                    <p class="text-xs uppercase font-bold tracking-[0.3em] text-white/40 mt-1">Premium Football Academy</p>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/45 to-transparent"></div>
            <div class="absolute bottom-6 left-6 md:left-8 z-10">
                <span class="text-[10px] uppercase font-bold tracking-widest text-orange-400 bg-orange-500/10 px-3 py-1 rounded-full border border-orange-500/20">
                    Kelompok Kelas
                </span>
                <h2 class="heading-font text-3xl md:text-5xl font-black uppercase tracking-wide text-white mt-3 leading-tight">
                    {{ $kelompok->nama_kelompok }}
                </h2>
            </div>
        </div>

        <!-- INFO GRID -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Details info -->
            <div class="md:col-span-2 bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6">
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="info" class="w-5 h-5 text-orange-500"></i>
                    <h3 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Deskripsi Kategori</h3>
                </div>

                <div class="space-y-4">
                    <p class="text-base text-white/70 leading-relaxed">
                        {{ $kelompok->keterangan_kelompok_kelas ?: 'Keterangan kelompok umur ini belum tersedia.' }}
                    </p>
                </div>
            </div>

            <!-- Stats info -->
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                        <i data-lucide="target" class="w-5 h-5 text-orange-500"></i>
                        <h3 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Sasaran Usia</h3>
                    </div>

                    <div class="space-y-5 mt-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 flex-shrink-0">
                                <i data-lucide="calendar" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Tahun Kelahiran</span>
                                <p class="text-lg font-bold text-white mt-0.5">
                                    {{ $kelompok->dari_tahun_kelahiran }} - {{ $kelompok->sampai_tahun_kelahiran }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 flex-shrink-0">
                                <i data-lucide="shield" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Metode Pembinaan</span>
                                <p class="text-sm font-semibold text-white/80 mt-0.5 leading-relaxed">
                                    Kurikulum terstandar YTSS Academy berfokus pada teknik, fisik, taktik, dan mental.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20 border border-dashed border-white/10 rounded-[32px] bg-white/[0.01]">
            <i data-lucide="shield-alert" class="w-16 h-16 text-white/20 mx-auto mb-4"></i>
            <h3 class="heading-font text-2xl font-bold uppercase tracking-wider text-white mb-2">Belum Terdaftar Kelompok</h3>
            <p class="text-sm text-white/50 max-w-md mx-auto leading-relaxed">
                Anda belum terdaftar dalam kelompok kelas manapun. Silakan lengkapi pendaftaran Anda atau hubungi admin akademi.
            </p>
        </div>
    @endif
</div>
@endsection
