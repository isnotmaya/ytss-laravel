@extends('layouts.app')

@section('seo_title', 'Jadwal Latihan YTSS Soccer School | Akademi Sepak Bola Bogor')
@section('seo_description', 'Jadwal latihan rutin, lokasi lapangan, dan sesi pembinaan kelompok usia akademi sepak bola YTSS Soccer School Bogor.')
@section('seo_keywords', 'jadwal latihan ssb bogor, jadwal ytss soccer school, latihan sepak bola anak bogor, ssb bogor terdekat, tempat latihan bola bogor')

@section('content')
    @include('partials.sidebar')

    <main class="ml-0 md:ml-[96px]">

        @include('partials.navbar')
        @include('partials.mobile-menu')

        {{-- HERO --}}
        <section
            class="relative overflow-hidden bg-gradient-to-b from-black via-[#0a0a0a] to-black px-6 md:px-16 pt-24 pb-16">

            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-500/20 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-20 -left-40 w-80 h-80 bg-orange-600/10 blur-3xl rounded-full"></div>
            </div>
            {{-- WATERMARK --}}
            <div
                class="
    hidden lg:block
    absolute
    right-[-80px]
    top-0

    pointer-events-none
    opacity-[0.05]
    z-0">

                <i data-lucide="calendar-range" class="w-[420px] h-[420px] text-orange-400 float-icon">
                </i>

            </div>
            <div class="relative z-10 max-w-7xl mx-auto">

                <div class="flex items-center gap-2 mb-8">
                    <a href="{{ url('/') }}" class="text-white/40 hover:text-white/60 text-sm">
                        Home
                    </a>

                    <span class="text-white/20">/</span>

                    <span class="text-orange-400 text-sm font-semibold">
                        Jadwal Latihan
                    </span>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">

                    <div>
                        <div class="flex items-center gap-3 mb-4">

                            <div
                                class="w-10 h-10
               rounded-xl
               bg-orange-500/10
               border border-orange-500/20
               flex items-center justify-center">

                                <i data-lucide="calendar-days" class="w-5 h-5 text-orange-400">
                                </i>

                            </div>

                            <p class="uppercase font-bold tracking-[4px] text-orange-400 text-sm">
                                Training Schedule
                            </p>

                        </div>

                        <h1 class="text-5xl md:text-7xl font-black uppercase leading-[0.95] mb-6">
                            Training
                            <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                                Schedule
                            </span>
                        </h1>

                        <p class="text-lg text-white/60 max-w-xl">
                            Jadwal latihan resmi YTSS Academy untuk seluruh kelompok usia
                            dan kategori pembinaan.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div
                            class="
group
bg-white/[0.05]
border border-orange-500/20
rounded-2xl
p-6

transition-all
duration-500

hover:-translate-y-2
hover:border-orange-500/40
hover:shadow-[0_0_30px_rgba(249,115,22,.18)]
">

                            <div class="flex items-center justify-between mb-4">

                                <div
                                    class="
        w-14 h-14
        rounded-2xl
        bg-orange-500/10
        border border-orange-500/20

        flex items-center justify-center">

                                    <i data-lucide="calendar-range" class="w-6 h-6 text-orange-400 float-icon">
                                    </i>

                                </div>

                                <div class="
        text-4xl
        font-black
        text-orange-400">

                                    {{ $schedules->count() }}

                                </div>

                            </div>

                            <p class="text-white/60">
                                Total Schedule
                            </p>

                        </div>
                        <div
                            class="
group
bg-white/[0.05]
border border-orange-500/20
rounded-2xl
p-6

transition-all
duration-500

hover:-translate-y-2
hover:border-orange-500/40
hover:shadow-[0_0_30px_rgba(249,115,22,.18)]
">

                            <div class="flex items-center justify-between mb-4">

                                <div
                                    class="
        w-14 h-14
        rounded-2xl
        bg-orange-500/10
        border border-orange-500/20

        flex items-center justify-center">

                                    <i data-lucide="users-round" class="w-6 h-6 text-orange-400 float-icon">
                                    </i>

                                </div>

                                <div class="
        text-4xl
        font-black
        text-orange-400">

                                    {{ $schedules->groupBy('id_kelompok_kelas')->count() }}

                                </div>

                            </div>

                            <p class="text-white/60">
                                Categories
                            </p>

                        </div>



                    </div>

                </div>

            </div>
        </section>

        {{-- CONTENT --}}
        <section class="bg-black px-6 md:px-16 py-20">

            <div class="max-w-7xl mx-auto">
                <h2 class="sr-only">Jadwal Latihan Akademi Sepak Bola Bogor YTSS</h2>

                <div class="grid gap-6">

                    @forelse($schedules as $schedule)
                        <div
                            class="
relative
group

bg-white/[0.05]
border border-white/10

rounded-2xl

p-6 pt-8

transition-all
duration-500

hover:-translate-y-1
hover:border-orange-500/40
hover:bg-white/[0.07]

hover:shadow-[0_0_35px_rgba(249,115,22,.15)]
">
                            <div
                                class="
    absolute
    left-0
    top-0

    h-full
    w-2

    bg-gradient-to-b
    from-orange-400
    to-orange-600

    rounded-l-2xl

    opacity-0

    group-hover:opacity-100

    transition-all
    duration-500">
                            </div>
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                                <div>

                                    <div class="absolute
           -top-4
           left-8">

                                        <div
                                            class="
    bg-gradient-to-r
    from-orange-500
    to-orange-600

    text-black

    font-black
    text-xs

    uppercase

    tracking-[2px]

    px-5
    py-2

    rounded-full

    shadow-[0_0_20px_rgba(249,115,22,.4)]
    ">

                                            {{ $schedule->kelompokKelas->nama_kelompok }}

                                        </div>

                                    </div>

                                    <h3 class="text-2xl font-black uppercase text-white mb-2">

                                        {{ $schedule->judul }}

                                    </h3>

                                    <p class="text-white/60">
                                        {{ $schedule->deskripsi }}
                                    </p>

                                </div>

                                <div class="grid md:grid-cols-3 gap-4 lg:min-w-[500px]">

                                    <div class="bg-black/40 rounded-xl p-4">

                                        <div class="flex items-center gap-2 mb-2">

                                            <i data-lucide="calendar-days" class="w-4 h-4 text-orange-400">
                                            </i>

                                            <div class="text-orange-400 text-xs uppercase">
                                                Tanggal
                                            </div>

                                        </div>

                                        <div class="text-white font-semibold">
                                            {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                                        </div>

                                    </div>

                                    <div class="bg-black/40 rounded-xl p-4">

                                        <div class="flex items-center gap-2 mb-2">

                                            <i data-lucide="clock-3" class="w-4 h-4 text-orange-400">
                                            </i>

                                            <div class="text-orange-400 text-xs uppercase">
                                                Waktu
                                            </div>

                                        </div>

                                        <div class="text-white font-semibold">
                                            {{ substr($schedule->jam_mulai, 0, 5) }}
                                            -
                                            {{ substr($schedule->jam_selesai, 0, 5) }}
                                        </div>

                                    </div>

                                    <div class="bg-black/40 rounded-xl p-4">

                                        <div class="flex items-center gap-2 mb-2">

                                            <i data-lucide="map-pin" class="w-4 h-4 text-orange-400">
                                            </i>

                                            <div class="text-orange-400 text-xs uppercase">
                                                Lokasi
                                            </div>

                                        </div>

                                        <div class="text-white font-semibold">
                                            {{ $schedule->lokasi }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-20 border border-dashed border-white/10 rounded-3xl">

                            <p class="text-white/40">
                                Belum ada jadwal latihan.
                            </p>

                        </div>
                    @endforelse

                </div>

            </div>

        </section>

        @include('partials.footer')

    </main>
@endsection
