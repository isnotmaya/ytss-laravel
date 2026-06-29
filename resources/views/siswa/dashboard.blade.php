@extends('layouts.siswa')

@section('content')
<div class="space-y-10">
    <!-- WELCOME HEADER BANNER -->
    <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-r from-orange-600/20 via-orange-500/5 to-transparent border border-white/5 p-6 lg:p-8">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-orange-500/15 blur-[100px] rounded-full"></div>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-6">
            <!-- Profile Picture / Initial Badge -->
            <div class="flex-shrink-0">
                @if(!empty($siswa->upload_foto) && file_exists(public_path($siswa->upload_foto)))
                    <img src="{{ asset($siswa->upload_foto) }}" 
                         class="w-20 h-20 rounded-full object-cover border-2 border-orange-500 shadow-xl" 
                         alt="{{ $siswa->nama_lengkap }}">
                @else
                    <div class="w-20 h-20 rounded-full bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-500 text-3xl font-black heading-font shadow-lg">
                        {{ $siswa->getInitials() }}
                    </div>
                @endif
            </div>
            <div class="text-center sm:text-left flex-1">
                <p class="text-xs uppercase font-bold tracking-[0.2em] text-orange-500 mb-1">Selamat Datang di Portal YTSS</p>
                <h1 class="heading-font text-3xl sm:text-4xl lg:text-5xl font-black uppercase tracking-wide text-white leading-tight">
                    Halo, {{ $siswa->nama_lengkap }}
                </h1>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mt-3">
                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-xs font-medium text-white/80 flex items-center gap-1.5">
                        <i data-lucide="shield" class="w-3.5 h-3.5 text-orange-400"></i>
                        {{ $siswa->kelompokKelas ? $siswa->kelompokKelas->nama_kelompok : 'Belum Ada Kelompok' }}
                    </span>
                    
                    <!-- Status Badge -->
                    @php
                        $status = $stats['status_aktif'];
                        $badgeColors = [
                            'aktif' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            'cuti' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                            'tidak-aktif' => 'bg-red-500/10 text-red-400 border-red-500/20',
                            'daftar-reguler' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                            'daftar-beasiswa' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                            'daftar-tolak' => 'bg-neutral-800 text-neutral-400 border-neutral-700',
                        ];
                        $badgeLabels = [
                            'aktif' => 'Aktif',
                            'cuti' => 'Cuti',
                            'tidak-aktif' => 'Tidak Aktif',
                            'daftar-reguler' => 'Pendaftaran Reguler',
                            'daftar-beasiswa' => 'Pendaftaran Beasiswa',
                            'daftar-tolak' => 'Ditolak',
                        ];
                        $colorClass = $badgeColors[$status] ?? 'bg-white/5 text-white/60 border-white/10';
                        $labelText = $badgeLabels[$status] ?? ucfirst($status);
                    @endphp
                    <span class="px-3 py-1 border rounded-full text-xs font-semibold uppercase tracking-wider {{ $colorClass }}">
                        {{ $labelText }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK STATS GRID -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Kelompok Kelas -->
        <div class="group relative overflow-hidden bg-white/[0.03] border border-white/5 rounded-3xl p-5 hover:border-orange-500/20 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase font-bold tracking-wider text-white/40">Kelompok</span>
                <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <i data-lucide="shield" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="heading-font text-2xl font-black text-white uppercase truncate">
                {{ $stats['kelompok'] }}
            </h3>
            <p class="text-xs text-white/50 mt-1">Kelompok Kelas Aktif</p>
        </div>

        <!-- Agenda Count -->
        <div class="group relative overflow-hidden bg-white/[0.03] border border-white/5 rounded-3xl p-5 hover:border-orange-500/20 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase font-bold tracking-wider text-white/40">Agenda</span>
                <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="heading-font text-3xl font-black text-white">
                {{ $stats['agenda_count'] }}
            </h3>
            <p class="text-xs text-white/50 mt-1">Agenda Kelas Aktif</p>
        </div>

        <!-- Tournament Count -->
        <div class="group relative overflow-hidden bg-white/[0.03] border border-white/5 rounded-3xl p-5 hover:border-orange-500/20 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase font-bold tracking-wider text-white/40">Tournament</span>
                <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <i data-lucide="trophy" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="heading-font text-3xl font-black text-white">
                {{ $stats['tournament_count'] }}
            </h3>
            <p class="text-xs text-white/50 mt-1">Tournament Aktif</p>
        </div>

        <!-- Achievement Count -->
        <div class="group relative overflow-hidden bg-white/[0.03] border border-white/5 rounded-3xl p-5 hover:border-orange-500/20 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase font-bold tracking-wider text-white/40">Prestasi</span>
                <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <i data-lucide="medal" class="w-4 h-4"></i>
                </div>
            </div>
            <h3 class="heading-font text-3xl font-black text-white">
                {{ $stats['achievement_count'] }}
            </h3>
            <p class="text-xs text-white/50 mt-1">Total Prestasi Kelas</p>
        </div>
    </div>

    <!-- MAIN GRID: KELOMPOK KELAS + JADWAL -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- DETAIL KELOMPOK KELAS -->
        <div class="lg:col-span-1 bg-white/[0.03] border border-white/5 rounded-[32px] p-6 flex flex-col justify-between">
            <div>
                <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white mb-6 flex items-center gap-2.5">
                    <i data-lucide="users" class="w-5 h-5 text-orange-500"></i>
                    Informasi Kelompok
                </h2>
                
                @if($siswa->kelompokKelas)
                    <div class="space-y-5">
                        <!-- Group Image Banner -->
                        <div class="relative overflow-hidden rounded-2xl h-44 border border-white/5">
                            @if($siswa->kelompokKelas->banner_exists)
                                <img src="{{ asset($siswa->kelompokKelas->upload_kelompok_kelas) }}" 
                                     class="w-full h-full object-cover" 
                                     alt="{{ $siswa->kelompokKelas->nama_kelompok }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-600/30 to-amber-600/10 flex flex-col items-center justify-center text-orange-400 p-4">
                                    <i data-lucide="shield" class="w-12 h-12 mb-2 opacity-80"></i>
                                    <span class="heading-font font-black uppercase text-lg tracking-wider text-center">YTSS ACADEMY</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0c0c0c]/80 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <h3 class="heading-font text-xl font-bold uppercase text-white tracking-wide">
                                    {{ $siswa->kelompokKelas->nama_kelompok }}
                                </h3>
                            </div>
                        </div>

                        <!-- Info items -->
                        <div class="space-y-3.5">
                            <div>
                                <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Rentang Tahun Kelahiran</span>
                                <p class="text-sm font-semibold text-white/90 mt-0.5">
                                    {{ $siswa->kelompokKelas->dari_tahun_kelahiran }} - {{ $siswa->kelompokKelas->sampai_tahun_kelahiran }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Keterangan</span>
                                <p class="text-sm text-white/60 leading-relaxed mt-0.5">
                                    {{ $siswa->kelompokKelas->keterangan_kelompok_kelas ?: 'Tidak ada keterangan tambahan.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i data-lucide="shield-alert" class="w-10 h-10 text-white/30 mx-auto mb-3"></i>
                        <p class="text-sm text-white/50">Belum tergabung dalam kelompok kelas.</p>
                    </div>
                @endif
            </div>
            
            @if($siswa->kelompokKelas)
                <div class="pt-6 mt-6 border-t border-white/5">
                    <a href="{{ route('siswa.kelompok-kelas') }}" class="w-full py-3 bg-white/5 hover:bg-orange-500/10 hover:text-orange-400 border border-white/10 hover:border-orange-500/20 rounded-xl text-center text-xs font-bold uppercase tracking-wider text-white/80 transition duration-300 block">
                        Detail Kelompok Kelas
                    </a>
                </div>
            @endif
        </div>

        <!-- JADWAL LATIHAN TERDEKAT -->
        <div class="lg:col-span-2 bg-white/[0.03] border border-white/5 rounded-[32px] p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white flex items-center gap-2.5">
                        <i data-lucide="calendar-days" class="w-5 h-5 text-orange-500"></i>
                        Jadwal Latihan Terdekat
                    </h2>
                    <a href="{{ route('siswa.jadwal') }}" class="text-xs font-bold uppercase tracking-wider text-orange-400 hover:text-orange-300 transition">
                        Lihat Semua
                    </a>
                </div>

                @if($upcomingJadwal->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingJadwal as $jadwal)
                            <div class="group bg-white/[0.02] border border-white/5 rounded-2xl p-4 hover:border-orange-500/25 hover:bg-orange-500/[0.01] transition duration-300">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1.5">
                                        <h4 class="text-base font-bold text-white group-hover:text-orange-400 transition">
                                            {{ $jadwal->judul }}
                                        </h4>
                                        <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-white/50">
                                            <span class="flex items-center gap-1.5">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-orange-500"></i>
                                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <i data-lucide="clock" class="w-3.5 h-3.5 text-orange-500"></i>
                                                {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-white/70 bg-white/5 px-3 py-1.5 rounded-xl border border-white/5 self-start sm:self-center">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-orange-500"></i>
                                        {{ $jadwal->lokasi }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Elegant Empty State -->
                    <div class="text-center py-16 border border-dashed border-white/10 rounded-2xl">
                        <i data-lucide="calendar-x" class="w-12 h-12 text-white/20 mx-auto mb-3"></i>
                        <p class="text-sm font-medium text-white/55">Belum ada jadwal latihan terdekat.</p>
                        <p class="text-xs text-white/30 mt-1">Jadwal latihan terbaru akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- AGENDA TERBARU -->
    <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white flex items-center gap-2.5">
                <i data-lucide="book-open" class="w-5 h-5 text-orange-500"></i>
                Agenda Terbaru
            </h2>
            <a href="{{ route('siswa.agenda') }}" class="text-xs font-bold uppercase tracking-wider text-orange-400 hover:text-orange-300 transition">
                Lihat Semua
            </a>
        </div>

        @if($recentAgenda->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($recentAgenda as $agenda)
                    <div class="group bg-white/[0.02] border border-white/5 rounded-2xl p-5 hover:border-orange-500/25 hover:-translate-y-1 transition duration-300 flex flex-col justify-between min-h-[160px]">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-[10px] uppercase font-bold tracking-widest text-orange-500 bg-orange-500/10 px-2 py-0.5 rounded-md">
                                    Agenda
                                </span>
                                <span class="text-xs text-white/40">
                                    {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}
                                </span>
                            </div>
                            <h4 class="text-base font-bold text-white group-hover:text-orange-400 transition leading-snug">
                                {{ $agenda->judul }}
                            </h4>
                            <p class="text-xs text-white/50 mt-2 line-clamp-2 leading-relaxed">
                                {{ $agenda->deskripsi }}
                            </p>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-white/60 mt-4 pt-3 border-t border-white/5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-orange-500"></i>
                            <span class="truncate">{{ $agenda->lokasi }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Elegant Empty State -->
            <div class="text-center py-12 border border-dashed border-white/10 rounded-2xl">
                <i data-lucide="calendar" class="w-12 h-12 text-white/20 mx-auto mb-3"></i>
                <p class="text-sm font-medium text-white/55">Belum ada agenda yang tersedia.</p>
                <p class="text-xs text-white/30 mt-1">Kegiatan akademik atau agenda mendatang akan diinfokan di sini.</p>
            </div>
        @endif
    </div>
</div>
@endsection