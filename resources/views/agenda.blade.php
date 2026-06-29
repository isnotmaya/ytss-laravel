@extends('layouts.app')

@section('seo_title', 'Agenda Kegiatan & Event YTSS Soccer School | SSB Bogor')
@section('seo_description', 'Ikuti agenda kegiatan terbaru dari YTSS Soccer School Bogor seperti laga persahabatan, festival sepak bola, coaching clinic, dan kumpul orang tua.')
@section('seo_keywords', 'agenda ssb bogor, kegiatan ytss soccer school, event sepak bola bogor, festival ssb bogor, coaching clinic bogor')

@section('content')
    @include('partials.sidebar')

    <main class="ml-0 md:ml-[96px]">

        @include('partials.navbar')
        @include('partials.mobile-menu')
        @php
            $totalAgenda = $agendas->count();

            $upcomingAgenda = $agendas
                ->filter(fn($agenda) => \Carbon\Carbon::parse($agenda->tanggal)->gte(now()))
                ->count();

            $thisMonthAgenda = $agendas
                ->filter(
                    fn($agenda) => \Carbon\Carbon::parse($agenda->tanggal)->month === now()->month &&
                        \Carbon\Carbon::parse($agenda->tanggal)->year === now()->year,
                )
                ->count();

            $totalLocations = $agendas->pluck('lokasi')->filter()->unique()->count();
        @endphp
        {{-- HERO --}}
        <section
            class="relative overflow-hidden bg-gradient-to-b from-black via-[#0a0a0a] to-black px-6 md:px-16 pt-24 pb-16">

            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-500/20 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-20 -left-40 w-80 h-80 bg-orange-600/10 blur-3xl rounded-full"></div>

                <div class="absolute inset-0 opacity-[0.02]"
                    style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
                </div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto">
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

                    <i data-lucide="clipboard-check" class="w-[420px] h-[420px] text-orange-400 float-icon">
                    </i>

                </div>
                {{-- Breadcrumb --}}
                <div class="flex items-center gap-2 mb-8">
                    <a href="{{ url('/') }}" class="text-white/40 hover:text-white/60 text-sm transition">
                        Home
                    </a>

                    <span class="text-white/20">/</span>

                    <span class="text-orange-400 text-sm font-semibold">
                        Agenda
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

                                <i data-lucide="clipboard-list" class="w-5 h-5 text-orange-400">
                                </i>

                            </div>

                            <p class="uppercase font-bold tracking-[4px] text-orange-400 text-sm">
                                Academy Agenda
                            </p>

                        </div>

                        <h1 class="text-5xl md:text-7xl font-black uppercase leading-[0.95] mb-6">

                            Academy

                            <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                                Agenda
                            </span>

                        </h1>

                        <p class="text-lg text-white/60 leading-relaxed max-w-xl">
                            Ikuti seluruh agenda kegiatan, event akademi,
                            pertandingan persahabatan, pertemuan orang tua,
                            dan berbagai program pengembangan pemain YTSS.
                        </p>

                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-2 gap-4">

                        {{-- TOTAL EVENTS --}}
                        <div
                            class="
        group
min-h-[150px]

bg-white/[0.05]
border border-orange-500/20

rounded-2xl
p-6

flex
flex-col
justify-between

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

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $totalAgenda }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Total Agenda
                            </p>

                        </div>

                        {{-- UPCOMING --}}
                        <div
                            class="
        group
min-h-[150px]

bg-white/[0.05]
border border-orange-500/20

rounded-2xl
p-6

flex
flex-col
justify-between

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

                                    <i data-lucide="sparkles" class="w-6 h-6 text-orange-400 float-icon">
                                    </i>

                                </div>

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $upcomingAgenda }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Agenda Aktif
                            </p>

                        </div>

                        {{-- THIS MONTH --}}
                        <div
                            class="
        group
min-h-[150px]

bg-white/[0.05]
border border-orange-500/20

rounded-2xl
p-6

flex
flex-col
justify-between

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

                                    <i data-lucide="calendar-days" class="w-6 h-6 text-orange-400 float-icon">
                                    </i>

                                </div>

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $thisMonthAgenda }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Bulan Ini
                            </p>

                        </div>

                        {{-- LOCATIONS --}}
                        <div
                            class="
        group
min-h-[150px]

bg-white/[0.05]
border border-orange-500/20

rounded-2xl
p-6

flex
flex-col
justify-between

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

                                    <i data-lucide="map-pin" class="w-6 h-6 text-orange-400 float-icon">
                                    </i>

                                </div>

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $totalLocations }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Lokasi Kegiatan
                            </p>

                        </div>

                    </div>

                </div>

        </section>

        {{-- CONTENT --}}
        <section class="bg-black px-6 md:px-16 py-20">

            <div class="max-w-7xl mx-auto">
                <div class="mb-12">

                    <p
                        class="
        uppercase
        tracking-[4px]
        text-orange-400
        text-sm
        font-bold
        mb-3">

                        Academy Activities

                    </p>

                    <h2
                        class="
        text-4xl
        md:text-5xl

        font-black
        uppercase

        text-white">

                        Upcoming Agenda

                    </h2>

                </div>
                <div class="
grid
md:grid-cols-2
xl:grid-cols-3
gap-8">

                    @forelse($agendas as $agenda)
                        <div
                            class="
relative
group

bg-white/[0.04]
border border-white/10

rounded-3xl

overflow-hidden

transition-all
duration-500

hover:-translate-y-2
hover:border-orange-500/40
hover:shadow-[0_0_35px_rgba(249,115,22,.15)]
">

                            {{-- TOP ACCENT --}}
                            <div
                                class="
    h-1
    w-full

    bg-gradient-to-r
    from-orange-400
    via-orange-500
    to-orange-600">
                            </div>

                            <div class="
p-8

flex
flex-col

h-full">
                                {{-- ARROW --}}
                                <div
                                    class="
        absolute
        top-6
        right-6

        opacity-0

        group-hover:opacity-100
        group-hover:translate-x-1

        transition-all
        duration-500">

                                    <i data-lucide="arrow-up-right" class="w-5 h-5 text-orange-400">
                                    </i>

                                </div>

                                {{-- BADGE --}}
                                <div class="mb-5">

                                    <div
                                        class="
            inline-flex
            items-center
            gap-2

            bg-orange-500/10
            border border-orange-500/20

            px-4
            py-2

            rounded-full

            text-orange-400

            text-xs
            font-bold
            uppercase">

                                        <i data-lucide="users-round" class="w-3 h-3">
                                        </i>

                                        {{ $agenda->kelompokKelas->nama_kelompok }}

                                    </div>

                                </div>

                                {{-- TITLE --}}
                                <h3
                                    class="
        text-2xl
        font-black
        uppercase

        text-white

        mb-4">

                                    {{ $agenda->judul }}

                                </h3>

                                {{-- DESCRIPTION --}}
                                <p class="
text-white/60
leading-relaxed

mb-8

flex-grow">

                                    {{ $agenda->deskripsi }}

                                </p>

                                {{-- DETAILS --}}
                                <div class="space-y-4">

                                    <div class="flex items-center gap-3">

                                        <i data-lucide="calendar-days" class="w-4 h-4 text-orange-400">
                                        </i>

                                        <span class="text-white/80">

                                            {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}

                                        </span>

                                    </div>

                                    <div class="flex items-center gap-3">

                                        <i data-lucide="clock-3" class="w-4 h-4 text-orange-400">
                                        </i>

                                        <span class="text-white/80">

                                            {{ substr($agenda->jam_mulai, 0, 5) }}
                                            -
                                            {{ substr($agenda->jam_selesai, 0, 5) }}

                                        </span>

                                    </div>

                                    <div class="flex items-center gap-3">

                                        <i data-lucide="map-pin" class="w-4 h-4 text-orange-400">
                                        </i>

                                        <span class="text-white/80">

                                            {{ $agenda->lokasi }}

                                        </span>

                                    </div>

                                </div>
                                <div class="
mt-8
pt-6

border-t
border-white/10

flex
items-center
justify-between">

                                    <span class="
    text-xs
    uppercase
    tracking-[2px]

    text-orange-400">

                                        YTSS EVENT

                                    </span>

                                    <i data-lucide="arrow-right"
                                        class="
        w-4 h-4
        text-orange-400

        group-hover:translate-x-1
        transition-all">
                                    </i>

                                </div>
                            </div>

                        </div>

                    @empty

                        <div class="text-center py-20 border border-dashed border-white/10 rounded-3xl">

                            <div
                                class="
w-24 h-24

mx-auto mb-6

rounded-3xl

bg-orange-500/10
border border-orange-500/20

flex items-center justify-center">

                                <i data-lucide="clipboard-x" class="w-10 h-10 text-orange-400">
                                </i>

                            </div>

                            <p class="text-white/40 text-lg">
                                Belum ada agenda yang tersedia.
                            </p>

                        </div>
                    @endforelse

                </div>

            </div>

        </section>

        @include('partials.footer')

    </main>
@endsection
