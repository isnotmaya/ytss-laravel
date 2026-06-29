<!-- ACHIEVEMENT SECTION -->
<section id="achievement" class="relative overflow-hidden bg-black px-6 md:px-16 py-24">

    <!-- BACKGROUND GLOW -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-orange-500/10 blur-3xl rounded-full"></div>

    <div class="relative z-10">

        <!-- TITLE -->
        <div class="flex flex-col xl:flex-row justify-between gap-10 mb-16 reveal-on-scroll">
            <div>
                <p class="uppercase font-bold tracking-[4px] text-orange-400 text-sm">
                    Achievement
                </p>
                <h2 class="text-3xl md:text-5xl font-black uppercase mt-4 leading-tight">
                    Building Champions
                </h2>
            </div>
            <p class="max-w-2xl text-gray-400 leading-relaxed text-[15px] md:text-base">
                Prestasi pemain dan akademi menjadi bukti nyata
                pembinaan profesional YTSS Soccer School
                dalam mencetak generasi atlet sepak bola masa depan.
            </p>
        </div>

        <!-- CARD GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

            @forelse ($achievements as $achievement)
                @php
                    $badgeStyle = 'bg-orange-500 text-black';
                    $iconClass = 'fa-trophy';
                    $iconColor = 'text-orange-400';
                    $iconBg = 'bg-orange-500/10 border-orange-500/20';
                    $badgeText = ucfirst($achievement->tropi);

                    if ($achievement->tropi === 'regional') {
                        $badgeStyle = 'bg-gradient-to-r from-blue-500 to-blue-600 text-white';
                        $iconClass = 'fa-medal';
                        $iconColor = 'text-blue-400';
                        $iconBg = 'bg-blue-500/10 border-blue-500/20';
                    } elseif ($achievement->tropi === 'nasional') {
                        $badgeStyle = 'bg-gradient-to-r from-orange-500 to-orange-600 text-black';
                        $iconClass = 'fa-trophy';
                        $iconColor = 'text-orange-400';
                        $iconBg = 'bg-orange-500/10 border-orange-500/20';
                    } elseif ($achievement->tropi === 'internasional') {
                        $badgeStyle = 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-black';
                        $iconClass = 'fa-star';
                        $iconColor = 'text-yellow-400';
                        $iconBg = 'bg-yellow-500/10 border-yellow-500/20';
                    }
                @endphp

                <!-- CARD -->
                <div
                    class="group bg-white/[0.03] border border-white/10 rounded-3xl overflow-hidden hover:-translate-y-2 hover:border-orange-500/30 transition duration-300 reveal-on-scroll"
                    style="transition-delay: {{ $loop->index * 100 }}ms;">

                    <!-- IMAGE -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $achievement->gambar_exists ? asset($achievement->gambar) : 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?q=80&w=1200' }}"
                            alt="{{ $achievement->judul }} - Prestasi SSB Bogor YTSS Soccer School"
                            loading="lazy"
                            class="
        achievement-image
        h-72
        w-full
        object-cover
        group-hover:scale-125
        transition-all
        duration-700
    "
    style="animation-delay: {{ $loop->index * 0.8 }}s">
                        <div class="absolute inset-0 bg-black/40"></div>

                        <!-- BADGE -->
                        <div
                            class="absolute top-5 left-5 {{ $badgeStyle }} px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest">
                            {{ $badgeText }}
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="p-7">
                        <div class="flex items-start justify-between mb-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-12 h-12 rounded-2xl {{ $iconBg }}
        flex items-center justify-center">

                                    <i class="fa-solid {{ $iconClass }} {{ $iconColor }}">
                                    </i>

                                </div>

                                <div>

                                    <p class="font-black uppercase text-white">
                                        {{ $achievement->judul }}
                                    </p>

                                    <span class="text-sm text-gray-400">
                                        {{ $achievement->kelompokKelas?->nama_kelompok ?? 'All Category' }}
                                    </span>

                                </div>

                            </div>

                            <i data-lucide="arrow-up-right"
                                class="
        w-5 h-5
        text-orange-400

        opacity-0

        group-hover:opacity-100
        group-hover:translate-x-1

        transition-all">
                            </i>

                        </div>

                        <p class="text-gray-400 leading-relaxed">
                            {{ $achievement->deskripsi }}
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">

                            <span
                                class="
    px-3 py-1

    rounded-full

    bg-orange-500/10

    text-orange-400

    text-[11px]
    font-semibold">

                                Achievement

                            </span>

                        </div>

                    </div>

                </div>
            @empty
                <div
                    class="col-span-1 md:col-span-2 xl:col-span-3 text-center py-12 text-gray-500 border border-dashed border-white/10 rounded-3xl">
                    Belum ada data prestasi.
                </div>
            @endforelse

        </div>

        <!-- VIEW ALL BUTTON -->
        <div class="flex justify-center mt-16">
            <a href="{{ route('achievements') }}"
                class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold uppercase tracking-wider rounded-xl hover:shadow-[0_12px_30px_rgba(249,115,22,0.4)] transition duration-300 group">
                Explore All Achievements
                <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-1 transition"></i>
            </a>
        </div>

    </div>

</section>
