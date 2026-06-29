@extends('layouts.siswa')

@section('content')
<div class="space-y-10">
    <!-- PAGE TITLE -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="heading-font text-4xl lg:text-5xl font-black uppercase tracking-wider text-white">
                PRESTASI KELAS
            </h1>
            <p class="text-sm text-white/50 mt-1">
                Daftar pencapaian, tropi, dan prestasi yang diraih oleh kelompok kelas Anda.
            </p>
        </div>
        <div class="bg-orange-500/10 border border-orange-500/20 px-4 py-2.5 rounded-2xl self-start md:self-center flex items-center gap-2 text-orange-400">
            <i data-lucide="shield" class="w-4 h-4"></i>
            <span class="text-xs uppercase font-bold tracking-wider heading-font">
                {{ $siswa->kelompokKelas ? $siswa->kelompokKelas->nama_kelompok : 'Umum' }}
            </span>
        </div>
    </div>

    @if($achievements->count() > 0)
        <!-- ACHIEVEMENTS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($achievements as $achievement)
                @php
                    $tropi = strtolower($achievement->tropi);
                    $badgeStyle = 'bg-orange-500 text-black';
                    $iconName = 'award';
                    $iconBg = 'bg-orange-500/10 border-orange-500/30';
                    $iconColor = 'text-orange-400';

                    if ($tropi === 'regional') {
                        $badgeStyle = 'bg-gradient-to-r from-blue-500 to-blue-600 text-white';
                        $iconName = 'medal';
                        $iconBg = 'bg-blue-500/10 border-blue-500/30';
                        $iconColor = 'text-blue-400';
                    } elseif ($tropi === 'nasional') {
                        $badgeStyle = 'bg-gradient-to-r from-orange-500 to-orange-600 text-black';
                        $iconName = 'trophy';
                        $iconBg = 'bg-orange-500/10 border-orange-500/30';
                        $iconColor = 'text-orange-400';
                    } elseif ($tropi === 'internasional') {
                        $badgeStyle = 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-black';
                        $iconName = 'sparkles';
                        $iconBg = 'bg-yellow-500/10 border-yellow-500/30';
                        $iconColor = 'text-yellow-400';
                    }
                @endphp

                <!-- ACHIEVEMENT CARD -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white/[0.06] to-white/[0.01] border border-white/10 rounded-3xl hover:border-orange-500/30 hover:shadow-[0_15px_40px_rgba(249,115,22,0.12)] transition-all duration-300 flex flex-col h-full">
                    <!-- IMAGE AREA -->
                    <div class="relative h-56 w-full overflow-hidden bg-neutral-900 border-b border-white/5">
                        @if($achievement->gambar_exists)
                            <img src="{{ asset($achievement->gambar) }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                                 alt="{{ $achievement->judul }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-orange-600/20 to-amber-600/5 flex items-center justify-center text-orange-400/40">
                                <i data-lucide="award" class="w-14 h-14 float-icon"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        
                        <!-- Badge -->
                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $badgeStyle }}">
                            {{ $achievement->tropi }}
                        </span>
                    </div>

                    <!-- CARD BODY -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $iconBg }}">
                                    <i data-lucide="{{ $iconName }}" class="w-5 h-5 {{ $iconColor }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="heading-font text-lg font-bold uppercase text-white leading-tight truncate group-hover:text-orange-400 transition">
                                        {{ $achievement->judul }}
                                    </h3>
                                    <p class="text-[10px] text-white/40 uppercase tracking-wider font-bold mt-1">
                                        {{ $siswa->kelompokKelas ? $siswa->kelompokKelas->nama_kelompok : 'YTSS' }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-xs text-white/60 leading-relaxed line-clamp-3">
                                {{ $achievement->deskripsi }}
                            </p>
                        </div>

                        <!-- CARD FOOTER -->
                        <div class="flex items-center gap-2 pt-3 border-t border-white/5 text-[10px] uppercase tracking-wider font-bold text-white/40">
                            <i data-lucide="shield" class="w-3.5 h-3.5 text-orange-500"></i>
                            <span>YTSS Soccer Academy</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Elegant Empty State -->
        <div class="text-center py-20 border border-dashed border-white/10 rounded-[32px] bg-white/[0.01]">
            <i data-lucide="medal" class="w-16 h-16 text-white/20 mx-auto mb-4"></i>
            <h3 class="heading-font text-2xl font-bold uppercase tracking-wider text-white mb-2">Belum Ada Prestasi</h3>
            <p class="text-sm text-white/50 max-w-md mx-auto leading-relaxed">
                Saat ini belum ada data prestasi terdaftar untuk kelompok kelas Anda. Ayo latihan giat untuk raih prestasi setinggi-tingginya!
            </p>
        </div>
    @endif
</div>
@endsection
