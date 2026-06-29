@extends('layouts.siswa')

@section('content')
<div class="space-y-10">
    <!-- PAGE TITLE -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="heading-font text-4xl lg:text-5xl font-black uppercase tracking-wider text-white">
                TOURNAMENT & KOMPETISI
            </h1>
            <p class="text-sm text-white/50 mt-1">
                Jadwal kompetisi, liga internal/eksternal, dan festival sepak bola yang diikuti kelompok kelas Anda.
            </p>
        </div>
        <div class="bg-orange-500/10 border border-orange-500/20 px-4 py-2.5 rounded-2xl self-start md:self-center flex items-center gap-2 text-orange-400">
            <i data-lucide="shield" class="w-4 h-4"></i>
            <span class="text-xs uppercase font-bold tracking-wider heading-font">
                {{ $siswa->kelompokKelas ? $siswa->kelompokKelas->nama_kelompok : 'Umum' }}
            </span>
        </div>
    </div>

    @if($tournaments->count() > 0)
        <!-- TOURNAMENT GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tournaments as $tournament)
                <div class="group relative overflow-hidden bg-white/[0.03] border border-white/5 rounded-[28px] p-6 hover:border-orange-500/25 transition duration-300 flex flex-col justify-between min-h-[220px]">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-2">
                            <!-- Date Badge -->
                            <div class="flex items-center gap-2 text-xs text-orange-400 font-semibold uppercase tracking-wider bg-orange-500/5 border border-orange-500/10 px-3 py-1.5 rounded-xl">
                                <i data-lucide="trophy" class="w-3.5 h-3.5"></i>
                                {{ \Carbon\Carbon::parse($tournament->tanggal)->format('d M Y') }}
                            </div>
                            <!-- Time Badge -->
                            <div class="text-xs text-white/40 font-medium">
                                {{ substr($tournament->jam_mulai, 0, 5) }} - {{ substr($tournament->jam_selesai, 0, 5) }} WIB
                            </div>
                        </div>

                        <div>
                            <h3 class="heading-font text-xl font-bold uppercase text-white group-hover:text-orange-400 transition leading-tight">
                                {{ $tournament->judul }}
                            </h3>
                            <p class="text-xs text-white/50 mt-2.5 leading-relaxed line-clamp-3">
                                {{ $tournament->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-white/70 bg-white/5 px-4 py-2.5 rounded-xl border border-white/5 mt-6 w-full">
                        <i data-lucide="map-pin" class="w-4 h-4 text-orange-500 flex-shrink-0"></i>
                        <span class="truncate">{{ $tournament->lokasi }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Elegant Empty State -->
        <div class="text-center py-20 border border-dashed border-white/10 rounded-[32px] bg-white/[0.01]">
            <i data-lucide="trophy" class="w-16 h-16 text-white/20 mx-auto mb-4"></i>
            <h3 class="heading-font text-2xl font-bold uppercase tracking-wider text-white mb-2">Belum Ada Tournament</h3>
            <p class="text-sm text-white/50 max-w-md mx-auto leading-relaxed">
                Saat ini belum ada agenda tournament terdaftar untuk kelompok kelas Anda. Persiapkan diri Anda untuk kompetisi yang akan datang!
            </p>
        </div>
    @endif
</div>
@endsection
