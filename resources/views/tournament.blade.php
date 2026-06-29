@extends('layouts.app')

@section('seo_title', 'Turnamen & Kompetisi Sepak Bola YTSS Soccer School Bogor')
@section('seo_description', 'Info jadwal turnamen sepak bola anak, festival SSB, dan laga kompetisi yang diikuti oleh YTSS Soccer School Bogor.')
@section('seo_keywords', 'turnamen sepak bola bogor, kompetisi ssb bogor, festival sepak bola anak, ytss tournament, akademi sepak bola bogor')

@section('content')
    @include('partials.sidebar')

    <main class="ml-0 md:ml-[96px]">

        @include('partials.navbar')
        @include('partials.mobile-menu')
        @php
            $totalTournament = $tournaments->count();

            $activeTournament = $tournaments
                ->filter(fn($item) => \Carbon\Carbon::parse($item->tanggal)->gte(now()))
                ->count();

            $totalCategory = $tournaments->pluck('id_kelompok_kelas')->filter()->unique()->count();

            $totalLocation = $tournaments->pluck('lokasi')->filter()->unique()->count();
        @endphp
        <section
            class="relative overflow-hidden
bg-gradient-to-b
from-black
via-[#0a0a0a]
to-black
px-6 md:px-16
pt-24
pb-20">

            <div class="absolute inset-0">

                <div class="absolute top-0 right-0
w-[500px] h-[500px]
bg-orange-500/10
blur-3xl
rounded-full">
                </div>

            </div>
            <div class="
hidden lg:block
absolute
right-[-80px]
top-0

pointer-events-none

opacity-[0.05]
z-0">

                <i data-lucide="goal" class="w-[420px] h-[420px] text-orange-400 float-icon">
                </i>

            </div>
            <div class="relative z-10 max-w-7xl mx-auto">

                <div class="flex items-center gap-2 mb-8">

                    <a href="{{ url('/') }}" class="text-white/40 text-sm">
                        Home
                    </a>

                    <span class="text-white/20">/</span>

                    <span class="text-orange-400 text-sm font-semibold">
                        Tournament
                    </span>

                </div>

                <div class="grid md:grid-cols-2 gap-12">

                    <div>

                        <div class="flex items-center gap-3 mb-4">

                            <div
                                class="w-10 h-10
               rounded-xl
               bg-orange-500/10
               border border-orange-500/20
               flex items-center justify-center">

                                <i data-lucide="trophy" class="w-5 h-5 text-orange-400 float-icon">
                                </i>

                            </div>

                            <p class="uppercase tracking-[4px] text-orange-400 font-bold text-sm">
                                Competition Series
                            </p>

                        </div>

                        <h1 class="text-5xl md:text-7xl
font-black
uppercase
leading-[0.95]
mb-6">

                            Future

                            <span class="bg-gradient-to-r
from-orange-400
to-orange-600
bg-clip-text
text-transparent">

                                Champions

                            </span>

                        </h1>

                        <p class="text-lg text-white/60">

                            Ikuti berbagai turnamen,
                            kompetisi persahabatan,
                            dan event sepak bola yang diikuti
                            oleh atlet YTSS Academy.

                        </p>

                    </div>
                    <div class="grid grid-cols-2 gap-4">

                        {{-- TOURNAMENT --}}
                        <div
                            class="group min-h-[150px] bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 flex flex-col justify-between transition-all duration-500 hover:-translate-y-2 hover:border-orange-500/40 hover:shadow-[0_0_30px_rgba(249,115,22,.18)]">

                            <div class="flex justify-between items-center">

                                <div
                                    class="w-14 h-14 rounded-2xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center">

                                    <i data-lucide="trophy" class="w-6 h-6 text-orange-400 float-icon"></i>

                                </div>

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $totalTournament }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Tournament
                            </p>

                        </div>

                        {{-- ACTIVE --}}
                        <div
                            class="group min-h-[150px] bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 flex flex-col justify-between transition-all duration-500 hover:-translate-y-2 hover:border-orange-500/40 hover:shadow-[0_0_30px_rgba(249,115,22,.18)]">

                            <div class="flex justify-between items-center">

                                <div
                                    class="w-14 h-14 rounded-2xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center">

                                    <i data-lucide="award" class="w-6 h-6 text-orange-400 float-icon"></i>

                                </div>

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $activeTournament }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Active Event
                            </p>

                        </div>

                        {{-- CATEGORY --}}
                        <div
                            class="group min-h-[150px] bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 flex flex-col justify-between transition-all duration-500 hover:-translate-y-2 hover:border-orange-500/40 hover:shadow-[0_0_30px_rgba(249,115,22,.18)]">

                            <div class="flex justify-between items-center">

                                <div
                                    class="w-14 h-14 rounded-2xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center">

                                    <i data-lucide="users-round" class="w-6 h-6 text-orange-400 float-icon"></i>

                                </div>

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $totalCategory }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Categories
                            </p>

                        </div>

                        {{-- LOCATION --}}
                        <div
                            class="group min-h-[150px] bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 flex flex-col justify-between transition-all duration-500 hover:-translate-y-2 hover:border-orange-500/40 hover:shadow-[0_0_30px_rgba(249,115,22,.18)]">

                            <div class="flex justify-between items-center">

                                <div
                                    class="w-14 h-14 rounded-2xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center">

                                    <i data-lucide="map-pin" class="w-6 h-6 text-orange-400 float-icon"></i>

                                </div>

                                <div class="text-4xl font-black text-orange-400">
                                    {{ $totalLocation }}
                                </div>

                            </div>

                            <p class="text-white/60">
                                Locations
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-black
px-6 md:px-16
pb-24">

            <div class="max-w-7xl mx-auto">
                <h2 class="sr-only">Jadwal & Info Turnamen Sepak Bola Anak Bogor YTSS</h2>

                <div class="grid
md:grid-cols-2
xl:grid-cols-3
gap-8">

                    @forelse($tournaments as $tournament)
                        @php
                            $isActive = \Carbon\Carbon::parse($tournament->tanggal)->gte(now());
                        @endphp
                        <div
                            class="
group
relative

bg-gradient-to-br
from-white/[0.05]
to-white/[0.02]

border border-white/10

rounded-3xl

overflow-hidden

transition-all
duration-500

hover:-translate-y-2
hover:border-orange-500/40
hover:shadow-[0_0_35px_rgba(249,115,22,.18)]
">

                            <div class="absolute
top-0
left-0
right-0
h-1
bg-gradient-to-r
from-orange-500
to-orange-600">
                            </div>

                            <div class="p-8 flex flex-col h-full">

                                <div class="flex justify-between items-start mb-6">

                                    <div
                                        class="
inline-flex
items-center
gap-2

px-4
py-2

rounded-full

bg-orange-500/10
border border-orange-500/20

text-orange-400

text-xs
font-black
uppercase">

                                        <i data-lucide="shield" class="w-3 h-3">
                                        </i>

                                        {{ $tournament->kelompokKelas->nama_kelompok ?? 'General' }}

                                    </div>
                                    @if ($isActive)
                                        <div class="flex items-center gap-2 text-green-400 text-xs font-bold">

                                            <i data-lucide="badge-check" class="w-4 h-4"></i>

                                            OPEN

                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold">

                                            <i data-lucide="circle-off" class="w-4 h-4"></i>

                                            CLOSED

                                        </div>
                                    @endif

                                </div>

                                <h3 class="text-2xl
font-black
uppercase
text-white
mb-4">

                                    {{ $tournament->judul }}

                                </h3>

                                <p class="text-white/60
leading-relaxed
mb-6
flex-grow">

                                     {{ $tournament->deskripsi }}

                                 </p>

                                 <div class="space-y-3">
                                     <div class="flex items-center gap-3">
                                         <i data-lucide="calendar-days" class="w-4 h-4 text-orange-400">
                                         </i>

                                         <span class="text-white/80">
                                             {{ \Carbon\Carbon::parse($tournament->tanggal)->format('d M Y') }}
                                         </span>

                                     </div>

                                     <div class="flex items-center gap-3">

                                         <i data-lucide="clock-3" class="w-4 h-4 text-orange-400">
                                         </i>

                                         <span class="text-white/80">
                                             {{ substr($tournament->jam_mulai, 0, 5) }}
                                             -
                                             {{ substr($tournament->jam_selesai, 0, 5) }}
                                         </span>

                                     </div>

                                     <div class="flex items-center gap-3">

                                         <i data-lucide="map-pin" class="w-4 h-4 text-orange-400">
                                         </i>

                                         <span class="text-white/80">
                                             {{ $tournament->lokasi }}
                                         </span>

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

                                             TOURNAMENT

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
                         </div>


                     @empty

                         <div class="col-span-full
text-center
py-20
border border-dashed
border-white/10
rounded-3xl">

                             <p class="text-white/40">

                                 Belum ada tournament tersedia.

                             </p>

                         </div>
                     @endforelse
         </section>

         @include('partials.footer')

     </main>
 @endsection
