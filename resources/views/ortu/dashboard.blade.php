@extends('layouts.ortu')

@section('content')
<div class="space-y-10">
    <!-- WELCOME HEADER BANNER -->
    <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-r from-orange-600/20 via-orange-500/5 to-transparent border border-white/5 p-6 lg:p-8">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-orange-500/15 blur-[100px] rounded-full"></div>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-6">
            <!-- Parent Avatar Initials -->
            <div class="flex-shrink-0">
                @if($ortu && $ortu->upload_foto && file_exists(public_path($ortu->upload_foto)))
                    <img src="{{ asset($ortu->upload_foto) }}" 
                         class="w-20 h-20 rounded-full object-cover border-2 border-orange-500 shadow-xl" 
                         alt="{{ Auth::user()->name }}">
                @else
                    <div class="w-20 h-20 rounded-full bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-500 text-3xl font-black heading-font shadow-lg">
                        {{ Auth::user()->getInitials() }}
                    </div>
                @endif
            </div>
            <div class="text-center sm:text-left flex-1">
                <p class="text-xs uppercase font-bold tracking-[0.2em] text-orange-500 mb-1">Selamat Datang di Portal Wali YTSS</p>
                <h1 class="heading-font text-3xl sm:text-4xl lg:text-5xl font-black uppercase tracking-wide text-white leading-tight">
                    Halo, {{ Auth::user()->name }}
                </h1>
                <p class="text-xs text-white/50 mt-1">
                    Pantau perkembangan latihan, kompetisi, dan prestasi anak Anda di YTSS Soccer School.
                </p>
            </div>
        </div>
    </div>

    <!-- INFORMASI ANAK BANNER -->
    <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6">
        <div class="flex items-center gap-3 border-b border-white/5 pb-4">
            <i data-lucide="users" class="w-5 h-5 text-orange-500"></i>
            <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Informasi Anak</h2>
        </div>

        @if($siswa)
            <div class="flex flex-col md:flex-row items-center gap-6 bg-white/[0.01] border border-white/5 rounded-2xl p-5">
                <!-- Child Photo / Initials -->
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

                <!-- Child Info details -->
                <div class="flex-1 text-center md:text-left space-y-2">
                    <h3 class="heading-font text-2xl font-bold uppercase text-white tracking-wide">
                        {{ $siswa->nama_lengkap }}
                    </h3>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-xs">
                        <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full font-medium text-white/80 flex items-center gap-1.5">
                            <i data-lucide="shield" class="w-3.5 h-3.5 text-orange-400"></i>
                            {{ $siswa->kelompokKelas ? $siswa->kelompokKelas->nama_kelompok : 'Belum Terdaftar Kelompok' }}
                        </span>

                        <!-- Status Badge -->
                        @php
                            $status = $stats['status_anak'];
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

                <!-- Link Actions -->
                <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('ortu.anak') }}" class="flex-1 md:flex-initial px-5 py-3 bg-orange-500 hover:bg-orange-600 rounded-xl text-center text-xs font-bold uppercase tracking-wider text-black shadow-lg shadow-orange-500/15 hover:shadow-orange-500/25 transition duration-300">
                        Profil Lengkap Anak
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-10 border border-dashed border-white/10 rounded-2xl">
                <i data-lucide="user-x" class="w-12 h-12 text-white/20 mx-auto mb-3"></i>
                <p class="text-sm text-white/50">Data anak belum terdaftar atau terhubung dengan akun ini.</p>
            </div>
        @endif
    </div>

    @if($siswa)
        <!-- MAIN GRID: JADWAL + AGENDA -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- JADWAL LATIHAN ANAK -->
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 space-y-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-4">
                        <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white flex items-center gap-2.5">
                            <i data-lucide="calendar-days" class="w-5 h-5 text-orange-500"></i>
                            Jadwal Latihan Terdekat
                        </h2>
                        <a href="{{ route('ortu.jadwal') }}" class="text-xs font-bold uppercase tracking-wider text-orange-400 hover:text-orange-300 transition">
                            Lihat Semua
                        </a>
                    </div>

                    @if($upcomingJadwal->count() > 0)
                        <div class="space-y-4 mt-6">
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
                                                    {{ $jadwal->tanggal->format('d M Y') }}
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
                        <div class="text-center py-16 border border-dashed border-white/10 rounded-2xl mt-6">
                            <i data-lucide="calendar-x" class="w-12 h-12 text-white/20 mx-auto mb-3"></i>
                            <p class="text-sm font-medium text-white/55">Belum ada jadwal latihan anak.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- AGENDA TERBARU -->
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 space-y-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-4">
                        <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white flex items-center gap-2.5">
                            <i data-lucide="book-open" class="w-5 h-5 text-orange-500"></i>
                            Agenda Akademi
                        </h2>
                        <a href="{{ route('ortu.agenda') }}" class="text-xs font-bold uppercase tracking-wider text-orange-400 hover:text-orange-300 transition">
                            Lihat Semua
                        </a>
                    </div>

                    @if($recentAgenda->count() > 0)
                        <div class="space-y-4 mt-6">
                            @foreach($recentAgenda as $agenda)
                                <div class="group bg-white/[0.02] border border-white/5 rounded-2xl p-4 hover:border-orange-500/25 hover:bg-orange-500/[0.01] transition duration-300">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="space-y-1.5 flex-1 min-w-0">
                                            <h4 class="text-base font-bold text-white group-hover:text-orange-400 transition truncate">
                                                {{ $agenda->judul }}
                                            </h4>
                                            <p class="text-xs text-white/50 line-clamp-2">
                                                {{ $agenda->deskripsi }}
                                            </p>
                                            <div class="flex items-center gap-3 text-xs text-white/40 pt-1">
                                                <span class="flex items-center gap-1">
                                                    <i data-lucide="calendar" class="w-3 h-3 text-orange-500"></i>
                                                    {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i data-lucide="map-pin" class="w-3 h-3 text-orange-500"></i>
                                                    {{ $agenda->lokasi }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 border border-dashed border-white/10 rounded-2xl mt-6">
                            <i data-lucide="book-open" class="w-12 h-12 text-white/20 mx-auto mb-3"></i>
                            <p class="text-sm font-medium text-white/55">Belum ada agenda tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PRESTASI ANAK -->
        <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white flex items-center gap-2.5">
                    <i data-lucide="medal" class="w-5 h-5 text-orange-500"></i>
                    Prestasi Kategori Anak
                </h2>
                <a href="{{ route('ortu.achievement') }}" class="text-xs font-bold uppercase tracking-wider text-orange-400 hover:text-orange-300 transition">
                    Lihat Semua
                </a>
            </div>

            @if($achievements->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach($achievements as $achievement)
                        @php
                            $tropi = strtolower($achievement->tropi);
                            $badgeStyle = 'bg-orange-500 text-black';
                            if ($tropi === 'regional') $badgeStyle = 'bg-gradient-to-r from-blue-500 to-blue-600 text-white';
                            elseif ($tropi === 'nasional') $badgeStyle = 'bg-gradient-to-r from-orange-500 to-orange-600 text-black';
                            elseif ($tropi === 'internasional') $badgeStyle = 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-black';
                        @endphp
                        <div class="group bg-white/[0.02] border border-white/5 rounded-2xl p-5 hover:border-orange-500/25 transition duration-300 flex flex-col justify-between min-h-[160px]">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="text-[9px] uppercase font-black tracking-widest px-2 py-0.5 rounded-full {{ $badgeStyle }}">
                                        {{ $achievement->tropi }}
                                    </span>
                                </div>
                                <h4 class="text-base font-bold text-white group-hover:text-orange-400 transition leading-snug truncate">
                                    {{ $achievement->judul }}
                                </h4>
                                <p class="text-xs text-white/50 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $achievement->deskripsi }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 border border-dashed border-white/10 rounded-2xl">
                    <i data-lucide="award" class="w-12 h-12 text-white/20 mx-auto mb-3"></i>
                    <p class="text-sm font-medium text-white/55">Belum ada prestasi untuk kelompok ini.</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection