@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.18),transparent_20%),radial-gradient(circle_at_bottom_left,rgba(217,138,58,0.12),transparent_28%),linear-gradient(180deg,#090909_0%,#110d09_50%,#070707_100%)] text-white">
        <div class="absolute inset-0 opacity-[0.04]"
            style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
        </div>

        <div class="relative z-10 flex min-h-screen flex-col">
            <header
                class="relative flex items-center justify-between gap-4 overflow-hidden border-b border-white/10 bg-[linear-gradient(to_right,#f97316,#f97316,#f97316)] px-4 py-3 shadow-[0_10px_40px_rgba(0,0,0,0.25)] md:px-8 md:py-4 lg:px-10">
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-b from-white/10 via-transparent to-black/20"></div>
                    <div class="absolute -left-20 top-[-120px] h-[260px] w-[420px] rounded-full bg-orange-200/20 blur-3xl opacity-60"></div>
                    <div class="absolute right-[-120px] top-[-80px] h-[220px] w-[380px] rounded-full bg-orange-500/10 blur-3xl"></div>
                </div>

                <div class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between gap-3">
                    <a href="{{ url('/') }}" class="mx-auto md:hidden" aria-label="YTSS Academy">
                        <img src="/images/ytss_logo.png" alt="YTSS Soccer School" class="h-11 w-11 object-contain">
                    </a>

                    <a href="{{ url('/') }}" class="hidden items-center gap-3 md:flex">
                        <img src="/images/ytss_logo.png" alt="YTSS Soccer School" class="h-12 w-12 object-contain">
                        <div>
                            <p class="font-['Barlow_Condensed'] text-2xl font-black uppercase tracking-[0.04em] text-white">
                                YTSS Academy
                            </p>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.32em] text-[#ffd3a0]/80">
                                Registration Status Portal
                            </p>
                        </div>
                    </a>

                    <div class="relative z-10 hidden items-center gap-3 md:flex">
                        <a href="{{ url('/') }}"
                            class="rounded-full border border-white/15 bg-white/[0.05] px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/85 transition hover:border-white/30 hover:bg-white/[0.14] hover:text-white">
                            Kembali
                        </a>
                        <a href="{{ route('login') }}"
                            class="rounded-full border border-white/15 bg-[#4a2200] px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-[#5a2a03]">
                            Login
                        </a>
                    </div>
                </div>
            </header>

            <div class="mx-auto flex w-full max-w-3xl flex-1 flex-col px-4 py-8 md:px-8 md:py-12">
                <section class="flex flex-1 items-center justify-center">
                    <div class="w-full rounded-[24px] border border-white/[0.08] bg-[linear-gradient(180deg,rgba(20,16,12,0.94)_0%,rgba(12,10,8,0.98)_100%)] p-6 shadow-[0_24px_80px_rgba(0,0,0,0.42)] backdrop-blur-xl md:rounded-[30px] md:p-10">
                        
                        <!-- Navigation Tabs -->
                        <div class="mb-8 flex justify-center w-full">
                            <div class="grid grid-cols-2 gap-1.5 p-1 rounded-2xl md:flex md:rounded-full border border-white/10 bg-black/40 backdrop-blur-sm w-full md:w-auto">
                                <a href="{{ route('login') }}"
                                    class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition text-white/60 hover:text-white whitespace-nowrap">
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
                                    class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition bg-orange-500 text-white shadow-[0_0_15px_rgba(249,115,22,0.3)] whitespace-nowrap">
                                    <span class="md:hidden">Status</span><span class="hidden md:inline">Cek Status</span>
                                </a>
                            </div>
                        </div>

                        <div class="mb-8 text-center">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-[#d98a3a]/75">Cek Status</p>
                            <h1 class="mt-3 font-['Barlow_Condensed'] text-3xl font-black uppercase text-white md:text-5xl tracking-wide">
                                CEK STATUS PENDAFTARAN
                            </h1>
                            <p class="mt-3 text-sm leading-7 text-white/60">
                                Masukkan Kode Pendaftaran dan Email Orang Tua untuk melacak status pendaftaran Anda.
                            </p>
                        </div>

                        <form action="{{ url('/cek-status') }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Kode Pendaftaran</label>
                                    <input type="text" name="kode_pendaftaran" required placeholder="Contoh: REG250001" value="{{ request('kode_pendaftaran') }}"
                                        class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#d98a3a]/40 focus:bg-white/[0.06]">
                                </div>

                                <div>
                                    <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Email Orang Tua</label>
                                    <input type="email" name="email" required placeholder="nama@email.com" value="{{ request('email') }}"
                                        class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#d98a3a]/40 focus:bg-white/[0.06]">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full rounded-[20px] bg-orange-500 hover:bg-orange-600 px-5 py-4 font-['Barlow_Condensed'] text-lg font-bold uppercase tracking-[0.16em] text-white transition">
                                Cari Pendaftaran
                              </button>
                        </form>

                        @if (isset($searched))
                            <div class="mt-10 border-t border-white/10 pt-8">
                                @if ($data)
                                    <div class="rounded-[20px] border border-white/[0.06] bg-white/[0.02] p-6 space-y-6">
                                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-white/5">
                                            <div>
                                                <p class="text-xs text-white/40 uppercase tracking-widest">Kode Pendaftaran</p>
                                                <p class="text-2xl font-black text-orange-500 mt-1">{{ $data->kode_pendaftaran }}</p>
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-white/40 uppercase tracking-widest mr-2">Status:</span>
                                                @if ($data->status_pendaftaran == 'pending')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-3 py-1.5 text-xs font-semibold text-amber-500 border border-amber-500/20">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                        Sedang Ditinjau
                                                    </span>
                                                @elseif ($data->status_pendaftaran == 'diterima')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold text-emerald-500 border border-emerald-500/20">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                        Diterima / Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-500 border border-red-500/20">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="grid gap-4 md:grid-cols-2 text-sm text-white/80">
                                            <div>
                                                <p class="text-xs text-white/40">Nama Calon Siswa</p>
                                                <p class="font-bold text-white mt-0.5">{{ $data->nama_lengkap }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-white/40">Kelompok Kelas</p>
                                                <p class="font-bold text-white mt-0.5">{{ $data->kelompok_kelas_label }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-white/40">Asal Sekolah</p>
                                                <p class="font-bold text-white mt-0.5">{{ $data->asal_sekolah }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-white/40">Email Terdaftar</p>
                                                <p class="font-bold text-white mt-0.5">{{ $data->email }}</p>
                                            </div>
                                            @if (isset($data->jenis_beasiswa_label))
                                                <div>
                                                    <p class="text-xs text-white/40">Jenis Beasiswa</p>
                                                    <p class="font-bold text-orange-500 mt-0.5">{{ $data->jenis_beasiswa_label }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- ACCOUNT DETAILS IF APPROVED -->
                                        @if ($data->status_pendaftaran == 'diterima')
                                            <div class="mt-6 rounded-[18px] border border-emerald-500/20 bg-emerald-500/[0.04] p-5">
                                                <h3 class="font-['Barlow_Condensed'] text-base font-bold uppercase tracking-wider text-emerald-500 mb-3">
                                                    AKUN LOGIN TELAH GENERATED
                                                </h3>
                                                <p class="text-xs text-white/70 leading-relaxed mb-4">
                                                    Pendaftaran Anda telah disetujui. Akun login terpisah untuk Orang Tua dan Siswa telah diaktifkan:
                                                </p>

                                                <div class="space-y-4">
                                                    <div class="p-3.5 rounded-[12px] bg-black/40 border border-white/5">
                                                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#d98a3a]">Akun Orang Tua (Wali)</p>
                                                        <div class="mt-2 text-xs space-y-1">
                                                            <p><span class="text-white/40">Email:</span> <span class="font-mono text-white select-all">{{ $data->email_ortu ?? $data->email }}</span></p>
                                                            <p><span class="text-white/40">Password:</span> <span class="text-white/60 font-semibold">Gunakan password yang Anda isi saat mendaftar</span></p>
                                                        </div>
                                                    </div>

                                                    <div class="p-3.5 rounded-[12px] bg-black/40 border border-white/5">
                                                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#d98a3a]">Akun Siswa (Pemain)</p>
                                                        <div class="mt-2 text-xs space-y-1">
                                                            <p><span class="text-white/40">Email:</span> <span class="font-mono text-white select-all">{{ $data->email_siswa ?? (strtolower($data->kode_pendaftaran) . '.siswa@ytss.com') }}</span></p>
                                                            <p><span class="text-white/40">Password:</span> <span class="text-white/60 font-semibold">Gunakan password yang Anda isi saat mendaftar</span></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="{{ route('login') }}" 
                                                    class="mt-5 flex w-full items-center justify-center rounded-[14px] bg-emerald-600 hover:bg-emerald-700 py-3 text-xs font-bold uppercase tracking-wider text-white transition">
                                                    Masuk Ke Portal &rarr;
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="rounded-[20px] border border-red-500/20 bg-red-500/10 p-6 text-center text-red-400">
                                        <p class="font-bold">Data Tidak Ditemukan</p>
                                        <p class="text-xs mt-1 text-white/50">Pastikan Kode Pendaftaran dan Email yang diisi sudah benar.</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="mt-8 text-center border-t border-white/10 pt-6">
                            <a href="{{ url('/') }}"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/40 transition hover:text-orange-400">
                                &larr; Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
