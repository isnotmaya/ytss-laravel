@extends('layouts.siswa')

@section('content')
<div class="space-y-10">
    <!-- PAGE TITLE -->
    <div>
        <h1 class="heading-font text-4xl lg:text-5xl font-black uppercase tracking-wider text-white">
            DATA ORANG TUA
        </h1>
        <p class="text-sm text-white/50 mt-1">
            Informasi wali atau orang tua yang terhubung dengan akun siswa (Read-only).
        </p>
    </div>

    @if($ortu)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- FATHER'S CARD -->
            <div class="group relative overflow-hidden bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 hover:border-orange-500/25 transition duration-300">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-orange-500/5 blur-[80px] rounded-full"></div>
                </div>
                <div class="relative z-10 space-y-6">
                    <div class="flex items-center gap-4 border-b border-white/5 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-500">
                            <i data-lucide="user" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Informasi Ayah</h2>
                            <p class="text-xs text-white/40">Data wali ayah kandung</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Nama Ayah</span>
                            <p class="text-base font-bold text-white mt-1">
                                {{ $ortu->nama_ayah ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Pekerjaan Ayah</span>
                            <p class="text-base font-bold text-white mt-1">
                                {{ $ortu->pekerjaan_ayah ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Nomor HP / WhatsApp</span>
                            <div class="flex items-center gap-2 mt-1">
                                <i data-lucide="phone" class="w-4 h-4 text-orange-500"></i>
                                <span class="text-base font-bold text-white">
                                    {{ $ortu->nomor_hp_ayah ?: '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MOTHER'S CARD -->
            <div class="group relative overflow-hidden bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 hover:border-orange-500/25 transition duration-300">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-orange-500/5 blur-[80px] rounded-full"></div>
                </div>
                <div class="relative z-10 space-y-6">
                    <div class="flex items-center gap-4 border-b border-white/5 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-500">
                            <i data-lucide="user" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Informasi Ibu</h2>
                            <p class="text-xs text-white/40">Data wali ibu kandung</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Nama Ibu</span>
                            <p class="text-base font-bold text-white mt-1">
                                {{ $ortu->nama_ibu ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Pekerjaan Ibu</span>
                            <p class="text-base font-bold text-white mt-1">
                                {{ $ortu->pekerjaan_ibu ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Nomor HP / WhatsApp</span>
                            <div class="flex items-center gap-2 mt-1">
                                <i data-lucide="phone" class="w-4 h-4 text-orange-500"></i>
                                <span class="text-base font-bold text-white">
                                    {{ $ortu->nomor_hp_ibu ?: '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20 border border-dashed border-white/10 rounded-[32px] bg-white/[0.01]">
            <i data-lucide="users" class="w-16 h-16 text-white/20 mx-auto mb-4"></i>
            <h3 class="heading-font text-2xl font-bold uppercase tracking-wider text-white mb-2">Belum Ada Data Orang Tua</h3>
            <p class="text-sm text-white/50 max-w-md mx-auto leading-relaxed">
                Informasi orang tua atau wali Anda belum terdaftar di sistem. Silakan hubungi bagian manajemen administrasi YTSS.
            </p>
        </div>
    @endif
</div>
@endsection
