@extends('layouts.app')

@section('seo_title', 'Prestasi & Penghargaan YTSS Soccer School | Akademi Sepak Bola Bogor')
@section('seo_description', 'Daftar prestasi, piala, dan medali yang diraih oleh YTSS Soccer School Bogor di turnamen regional, nasional, dan internasional.')
@section('seo_keywords', 'prestasi ytss soccer school, ssb bogor berprestasi, piala ssb bogor, juara turnamen sepak bola bogor, akademi sepak bola berprestasi bogor')

@section('content')
    @include('partials.sidebar')

    <main class="ml-0 md:ml-[96px]">
        @include('partials.navbar')

        @include('partials.mobile-menu')
        @php
            $totalAchievements = $achievements->count();

            $totalCategories = $achievements->pluck('id_kelompok_kelas')->filter()->unique()->count();

            $regionalCount = $achievements->where('tropi', 'regional')->count();

            $nasionalCount = $achievements->where('tropi', 'nasional')->count();

            $internasionalCount = $achievements->where('tropi', 'internasional')->count();
        @endphp
        <!-- ACHIEVEMENTS HERO -->
        <section
            class="relative overflow-hidden bg-gradient-to-b from-black via-[#0a0a0a] to-black px-6 md:px-16 pt-24 pb-16">
            <!-- BACKGROUND EFFECTS -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-500/20 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-20 -left-40 w-80 h-80 bg-orange-600/10 blur-3xl rounded-full"></div>
                <div class="absolute inset-0 opacity-[0.02]"
                    style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
                </div>
            </div>
<!-- BACKGROUND EFFECTS -->
<div class="absolute inset-0 overflow-hidden">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-500/20 blur-3xl rounded-full"></div>
    <div class="absolute -bottom-20 -left-40 w-80 h-80 bg-orange-600/10 blur-3xl rounded-full"></div>

    <div class="absolute inset-0 opacity-[0.02]"
        style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
    </div>
</div>

<!-- BACKGROUND ICON -->
<div class="hidden lg:block absolute right-[-80px] top-0 pointer-events-none opacity-[0.04] z-0">
    <i data-lucide="award"
        class="w-[420px] h-[420px] text-orange-400 float-icon">
    </i>
</div>

<div class="relative z-10 max-w-7xl mx-auto">

            <div class="relative z-10 max-w-7xl mx-auto">
                <!-- BREADCRUMB -->
                <div class="flex items-center gap-2 mb-8">
                    <a href="{{ url('/') }}" class="text-white/40 hover:text-white/60 text-sm transition">Home</a>
                    <span class="text-white/20">/</span>
                    <span class="text-orange-400 text-sm font-semibold">Achievements</span>
                </div>

                <!-- HEADER -->
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <i data-lucide="award" class="w-5 h-5 text-orange-400 float-icon">
                            </i>

                            <p class="uppercase font-bold tracking-[4px] text-orange-400 text-sm">
                                Our Achievements
                            </p>
                        </div>
                        <h1 class="text-4xl md:text-6xl font-black uppercase leading-tight mb-6">
                            Building <span
                                class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">Champions</span>
                        </h1>
                        <p class="text-lg text-white/60 leading-relaxed max-w-xl">
                            Prestasi pemain dan akademi menjadi bukti nyata pembinaan profesional YTSS Soccer School dalam
                            mencetak generasi atlet sepak bola masa depan.
                        </p>
                    </div>

                    <!-- STATS SUMMARY -->
                    <div class="grid grid-cols-2 gap-4">

                        <!-- TOTAL -->
                        <div
                            class="group bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm group hover:-translate-y-2 group-hover:shadow-[0_0_40px_rgba(249,115,22,0.18)] hover:shadow-[0_0_25px_rgba(249,115,22,0.15)] hover:border-orange-500/40 transition">

                            <div class="flex items-center justify-between mb-3">

                                <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center">

                                    <i data-lucide="trophy" class="w-6 h-6 text-orange-400 float-icon">
                                    </i>

                                </div>

                                <span class="text-xs text-orange-400 uppercase tracking-wider">
                                    Total
                                </span>

                            </div>

                            <div class="text-4xl font-black text-white">
                                {{ $totalAchievements }}
                            </div>

                            <p class="text-sm text-white/50 mt-2">
                                Total Achievements
                            </p>

                        </div>

                        <!-- CATEGORY -->
                        <div
                            class="group bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm group hover:-translate-y-2 group-hover:shadow-[0_0_40px_rgba(249,115,22,0.18)]
hover:shadow-[0_0_25px_rgba(249,115,22,0.15)] hover:border-orange-500/40 transition">

                            <div class="flex items-center justify-between mb-3">

                                <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">

                                    <i data-lucide="layers-3" class="w-6 h-6 text-blue-400 float-icon">
                                    </i>

                                </div>

                                <span class="text-xs text-blue-400 uppercase tracking-wider">
                                    Category
                                </span>

                            </div>

                            <div class="text-4xl font-black text-white">
                                {{ $totalCategories }}
                            </div>

                            <p class="text-sm text-white/50 mt-2">
                                Active Categories
                            </p>

                        </div>

                        <!-- REGIONAL -->
                        <div
                            class="group bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm group hover:-translate-y-2 group-hover:shadow-[0_0_40px_rgba(249,115,22,0.18)] hover:shadow-[0_0_25px_rgba(249,115,22,0.15)] hover:border-orange-500/40 transition">

                            <div class="flex items-center justify-between mb-3">

                                <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center">

                                    <i data-lucide="medal" class="w-6 h-6 text-green-400 float-icon">
                                    </i>

                                </div>

                                <span class="text-xs text-green-400 uppercase tracking-wider">
                                    Regional
                                </span>

                            </div>

                            <div class="text-4xl font-black text-white">
                                {{ $regionalCount }}
                            </div>

                            <p class="text-sm text-white/50 mt-2">
                                Regional Awards
                            </p>

                        </div>

                        <!-- NASIONAL + INTERNASIONAL -->
                        <div
                            class="group bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm group hover:-translate-y-2 group-hover:shadow-[0_0_40px_rgba(249,115,22,0.18)] hover:shadow-[0_0_25px_rgba(249,115,22,0.15)] hover:border-orange-500/40 transition">

                            <div class="flex items-center justify-between mb-3">

                                <div class="w-12 h-12 rounded-xl bg-yellow-500/10 flex items-center justify-center">

                                    <i data-lucide="sparkles" class="w-6 h-6 text-yellow-400 float-icon">
                                    </i>

                                </div>

                                <span class="text-xs text-yellow-400 uppercase tracking-wider">
                                    Elite
                                </span>

                            </div>

                            <div class="text-4xl font-black text-white">
                                {{ $nasionalCount + $internasionalCount }}
                            </div>

                            <p class="text-sm text-white/50 mt-2">
                                National & International
                            </p>

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <div x-data="{
            search: '',
            activeTab: 'all',
            limit: 6,
            achievements: @js($achievements),
            getBadgeStyle(tropi) {
                if (tropi === 'regional') return 'bg-gradient-to-r from-blue-500 to-blue-600 text-white';
                if (tropi === 'nasional') return 'bg-gradient-to-r from-orange-500 to-orange-600 text-black';
                if (tropi === 'internasional') return 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-black';
                return 'bg-orange-500 text-black';
            },
            getLucideIcon(tropi) {
        
                if (tropi === 'regional')
                    return 'medal';
        
                if (tropi === 'nasional')
                    return 'trophy';
        
                if (tropi === 'internasional')
                    return 'sparkles';
        
                return 'award';
            },
            getIconClass(tropi) {
                if (tropi === 'regional') return 'fa-medal text-blue-400';
                if (tropi === 'nasional') return 'fa-trophy text-orange-400';
                if (tropi === 'internasional') return 'fa-star text-yellow-400';
                return 'fa-trophy text-orange-400';
            },
            getIconBg(tropi) {
                if (tropi === 'regional') return 'bg-blue-500/10 border-blue-500/30';
                if (tropi === 'nasional') return 'bg-orange-500/10 border-orange-500/30';
                if (tropi === 'internasional') return 'bg-yellow-500/10 border-yellow-500/30';
                return 'bg-orange-500/10 border-orange-500/30';
            },
            get filteredAchievements() {
                return this.achievements.filter(item => {
                    const matchesSearch = item.judul.toLowerCase().includes(this.search.toLowerCase()) ||
                        (item.deskripsi && item.deskripsi.toLowerCase().includes(this.search.toLowerCase())) ||
                        (item.kelompok_kelas && item.kelompok_kelas.nama_kelompok.toLowerCase().includes(this.search.toLowerCase()));
                    const matchesTab = this.activeTab === 'all' || item.tropi === this.activeTab;
                    return matchesSearch && matchesTab;
                });
            },
            get visibleAchievements() {
                return this.filteredAchievements.slice(0, this.limit);
            }
        }">
            <!-- FILTER & SEARCH -->
            <section class="relative bg-black px-6 md:px-16 py-8">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                        <!-- SEARCH -->
                        <div class="relative w-full md:w-96">
                            <input type="text" placeholder="Search achievements..." x-model="search"
                                class="w-full bg-white/[0.05] border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-white/30 outline-none transition focus:border-orange-500/40 focus:bg-white/[0.08]">
                            <i data-lucide="search" class="w-4 h-4 text-white/30 absolute right-4 top-1/2 -translate-y-1/2">
                            </i>
                        </div>

                        <!-- FILTER TABS -->
                        <div class="flex gap-2 overflow-x-auto">
                            <button @click="activeTab = 'all'"
                                :class="activeTab === 'all' ? 'bg-orange-500 text-black font-semibold' :
                                    'bg-white/5 text-white/60 border border-white/10'"
                                class="px-4 py-2 rounded-full text-sm font-semibold transition hover:bg-orange-600 whitespace-nowrap">
                                All
                            </button>
                            <button @click="activeTab = 'regional'"
                                :class="activeTab === 'regional' ? 'bg-orange-500 text-black font-semibold' :
                                    'bg-white/5 text-white/60 border border-white/10'"
                                class="px-4 py-2 rounded-full text-sm font-semibold transition hover:bg-orange-600 whitespace-nowrap">
                                Regional
                            </button>
                            <button @click="activeTab = 'nasional'"
                                :class="activeTab === 'nasional' ? 'bg-orange-500 text-black font-semibold' :
                                    'bg-white/5 text-white/60 border border-white/10'"
                                class="px-4 py-2 rounded-full text-sm font-semibold transition hover:bg-orange-600 whitespace-nowrap">
                                Nasional
                            </button>
                            <button @click="activeTab = 'internasional'"
                                :class="activeTab === 'internasional' ? 'bg-orange-500 text-black font-semibold' :
                                    'bg-white/5 text-white/60 border border-white/10'"
                                class="px-4 py-2 rounded-full text-sm font-semibold transition hover:bg-orange-600 whitespace-nowrap">
                                Internasional
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ACHIEVEMENTS GRID -->
            <section class="relative bg-black px-6 md:px-16 py-20">
                <div class="max-w-7xl mx-auto">
                    <h2 class="sr-only">Daftar Prestasi & Penghargaan SSB Bogor - YTSS Soccer School</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <template x-for="achievement in visibleAchievements" :key="achievement.id">
                            <!-- ACHIEVEMENT CARD -->
                            <div
                                class="
group

bg-gradient-to-br
from-white/[0.08]
to-white/[0.03]

border border-white/10

rounded-2xl
overflow-hidden
group-hover:scale-[1.02]
hover:-translate-y-3
hover:border-orange-500/40

hover:shadow-[0_15px_50px_rgba(249,115,22,0.18)]

transition-all
duration-500">
                                <!-- IMAGE -->
                                <div class="relative overflow-hidden h-64">
                                    <img :src="achievement.gambar_exists ? '/' + achievement.gambar :
                                        'https://images.unsplash.com/photo-1517466787929-bc90951d0974?q=80&w=600'"
                                        :alt="achievement.judul + ' - Prestasi SSB Bogor YTSS Soccer School'"
                                        loading="lazy"
                                        class="w-full h-full object-cover
achievement-image
        group-hover:scale-125
        transition-all
        duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                                    <!-- BADGE -->
                                    <div :class="getBadgeStyle(achievement.tropi)"
                                        class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider"
                                        x-text="achievement.tropi">
                                    </div>
                                    

                                    <div
                                        class="absolute bottom-4 left-4 bg-black/50 backdrop-blur-md px-3 py-1 rounded-lg text-xs text-white">

                                        <span
                                            x-text="achievement.kelompok_kelas ?
            achievement.kelompok_kelas.nama_kelompok :
            'YTSS'">
                                        </span>

                                    </div>
                                </div>

                                <!-- CONTENT -->
                                <div class="p-6">
                                    <div class="flex items-start gap-3 mb-4">
                                        <div :class="getIconBg(achievement.tropi)"
                                            class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i :data-lucide="getLucideIcon(achievement.tropi)" class="w-5 h-5 icon-hover">
                                            </i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-black uppercase text-white text-sm leading-tight"
                                                x-text="achievement.judul">
                                            </h3>
                                            <p class="text-xs text-white/50 mt-1"
                                                x-text="achievement.kelompok_kelas ? achievement.kelompok_kelas.nama_kelompok : 'All Category'">
                                            </p>
                                        </div>
                                    </div>

                                    <p class="text-sm text-white/60 leading-relaxed mb-4" x-text="achievement.deskripsi">
                                    </p>

                                    <!-- FOOTER -->
                                    <div class="flex items-center justify-between pt-4 border-t border-white/5">

                                        <div class="flex items-center gap-2">

                                            <i data-lucide="shield" class="w-4 h-4 text-orange-400">
                                            </i>

                                            <span class="text-xs uppercase tracking-[2px] text-white/40">

                                                YTSS Academy

                                            </span>

                                        </div>

                                        <i data-lucide="arrow-up-right"
                                            class="
        w-4 h-4
        text-orange-400

        opacity-0

        group-hover:opacity-100
        group-hover:translate-x-1

        transition-all">
                                        </i>

                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- EMPTY STATE -->
                    <div x-show="filteredAchievements.length === 0"
                        class="text-center py-20 border border-dashed border-white/10 rounded-3xl mt-6">
                        <p class="text-white/45">No achievements found matching your search or filters.</p>
                    </div>

                    <!-- LOAD MORE -->
                    <div class="text-center mt-16" x-show="visibleAchievements.length < filteredAchievements.length">
                        <button @click="limit += 6"
                            class="px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-black font-bold uppercase tracking-wider rounded-xl hover:shadow-[0_0_30px_rgba(249,115,22,0.4)] transition duration-300">
                            Load More Achievements
                        </button>
                    </div>
                </div>
            </section>
        </div>

        @include('partials.footer')
    </main>
@endsection
