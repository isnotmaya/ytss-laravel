<!-- CATEGORY SECTION -->
<section class="
relative

bg-[#0a0a0a]

px-6 md:px-16

pt-20 pb-20 md:pt-24 md:pb-28

overflow-hidden
">

    <!-- TEXTURE -->
    <div
        class="
absolute inset-0

bg-[repeating-linear-gradient(-55deg,transparent,transparent_28px,rgba(255,255,255,0.012)_28px,rgba(255,255,255,0.012)_29px)]

pointer-events-none
">
    </div>

    <!-- AMBIENT GLOW -->
    <div
        class="
absolute

-bottom-[220px]
-left-[140px]

w-[620px]
h-[620px]

rounded-full

bg-[radial-gradient(circle,rgba(249,115,22,0.12)_0%,transparent_72%)]

pointer-events-none
">
    </div>
    <!-- TITLE -->
    <div class="flex flex-col xl:flex-row justify-between gap-10 mb-16 reveal-on-scroll">

        <div>

            <p
                class="
font-['Barlow_Condensed']

uppercase

text-[11px]
font-bold

tracking-[0.32em]

text-orange-400

flex items-center gap-3
">
                <span class="w-7 h-[2px] bg-orange-500"></span>
                Development Program
            </p>

            <h2
                class="
font-['Barlow_Condensed']

text-white
 
text-[42px] md:text-[72px]
font-black
italic

uppercase

leading-[0.9]

tracking-[-0.03em]

mt-5
">
                Student <span class="text-orange-500">Categories</span>
            </h2>

        </div>

        <p class="
max-w-[420px]

text-[15px]

leading-[1.9]

font-light

text-white/45

xl:text-right
"> Professional
            pathway scouting and specialized
            training programs based on biological age,
            technical ability, and competition level.
        </p>

    </div>

    <div class="flex overflow-x-auto snap-x snap-mandatory [scrollbar-width:none] [&::-webkit-scrollbar]:hidden gap-4 pb-6 -mx-6 px-6 md:grid md:grid-cols-2 md:overflow-visible md:snap-none md:gap-6 md:px-0 md:mx-0 md:pb-0 xl:grid-cols-4">

        @foreach ($kelompokKelas as $kelompok)
            <div x-data="{ open: false }"
                @click="
                if(window.innerWidth < 768){
                    open = !open
                }
            "
                class="
            flip-card
            group
            relative
            w-[280px]
            xs:w-[320px]
            shrink-0
            snap-center
            h-[450px]
            md:w-auto
            md:shrink
            md:h-[480px]
            overflow-hidden
            rounded-[20px]
            cursor-pointer
            reveal-on-scroll
            "
            style="transition-delay: {{ $loop->index * 100 }}ms;">

                {{-- FRONT --}}
                <div
                    class="
                card-front
                absolute inset-0

                bg-[linear-gradient(180deg,#161616_0%,#101010_100%)]

                border border-white/[0.06]

                transition-all duration-[850ms]

                ease-[cubic-bezier(0.785,0.135,0.150,0.860)]

                md:group-hover:-translate-x-full
                ">

                    <div
                        class="
                    pointer-events-none
                    absolute inset-x-0 top-0
                    h-px
                    bg-gradient-to-r
                    from-transparent
                    via-white/12
                    to-transparent
                    ">
                    </div>

                    {{-- IMAGE --}}
                    <div class="relative overflow-hidden h-[300px] md:h-80">

                        @if($kelompok->banner_exists)
                            <img src="{{ asset($kelompok->upload_kelompok_kelas) }}"
                                alt="{{ $kelompok->nama_kelompok }} - Kelompok Usia Akademi Sepak Bola Bogor YTSS"
                                loading="lazy"
                                class="
                            h-full
                            w-full
                            object-cover

                            brightness-[0.72]
                            saturate-[0.9]

                            transition-all duration-700
                            ease-[cubic-bezier(.22,1,.36,1)]

                            group-hover:scale-[1.07]
                            group-hover:brightness-[0.60]
                            group-hover:saturate-[1.08]
                            ">
                        @else
                            <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=600&auto=format&fit=crop"
                                alt="Default - Kelompok Usia Akademi Sepak Bola Bogor YTSS"
                                loading="lazy"
                                class="
                            h-full
                            w-full
                            object-cover

                            brightness-[0.72]
                            saturate-[0.9]

                            transition-all duration-700
                            ease-[cubic-bezier(.22,1,.36,1)]

                            group-hover:scale-[1.07]
                            group-hover:brightness-[0.60]
                            group-hover:saturate-[1.08]
                            ">
                        @endif

                        {{-- OVERLAY --}}
                        <div
                            class="
                        absolute inset-0
                        bg-[linear-gradient(to_bottom,transparent_10%,rgba(0,0,0,0.18)_45%,rgba(10,10,10,0.96)_100%)]
                        ">
                        </div>

                        {{-- NUMBER --}}
                        <div
                            class="
                        absolute
                        bottom-[-14px]
                        left-4

                        font-['Barlow_Condensed']
                        text-[82px]
                        font-black
                        italic
                        leading-none

                        text-white/[0.05]

                        pointer-events-none

                        transition-all duration-500

                        group-hover:text-orange-500/[0.10]
                        group-hover:translate-x-1
                        ">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div
                        class="
                    relative

                    px-5
                    pt-4
                    pb-6
                    md:px-7
                    md:pt-6
                    md:pb-10

                    before:content-['']
                    before:absolute
                    before:inset-x-0
                    before:top-0
                    before:h-16

                    before:bg-[linear-gradient(to_bottom,rgba(255,255,255,0.03),transparent)]

                    before:pointer-events-none
                    ">

                        <h3
                            class="
                        font-['Barlow_Condensed']
                        text-xl md:text-[26px]
                        font-black
                        uppercase
                        leading-none
                        tracking-[-0.01em]
                        text-white
                        ">
                            {{ $kelompok->nama_kelompok }}
                        </h3>

                        <p
                            class="
                        mt-1

                        text-[11px]
                        font-semibold

                        tracking-[0.16em]
                        uppercase

                        text-orange-400
                        ">
                            {{ $kelompok->dari_tahun_kelahiran }}
                            -
                            {{ $kelompok->sampai_tahun_kelahiran }}
                        </p>

                        <div class="mt-3 space-y-2 border-t border-white/10 pt-3 md:mt-5 md:space-y-3 md:pt-4">

                            <div class="mt-2.5 flex items-center gap-2 text-orange-400">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                                <span class="text-[11px] uppercase tracking-[0.18em] font-semibold">
                                    Elite Pathway
                                </span>
                            </div>

                        </div>

                    </div>

                    {{-- MOBILE BUTTON --}}
                    <div x-show="!open"
                        class="
                    absolute
                    bottom-5
                    right-5

                    z-20

                    md:hidden

                    flex items-center justify-center

                    w-9 h-9

                    rounded-full

                    border border-white/[0.08]

                    bg-[linear-gradient(180deg,rgba(255,255,255,0.10),rgba(255,255,255,0.03))]

                    backdrop-blur-xl

                    shadow-[0_8px_22px_rgba(0,0,0,0.28)]

                    text-white/55

                    transition-all duration-500
                    ">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                    </div>

                </div>

                {{-- BACK --}}
                <div :class="open ? 'translate-x-0' : 'translate-x-full'"
                    class="
                card-back
                absolute inset-0

                transition-all duration-[850ms]
                ease-[cubic-bezier(0.785,0.135,0.150,0.860)]

                md:translate-x-full
                md:group-hover:translate-x-0

                bg-[linear-gradient(180deg,#1a1208_0%,#120d08_45%,#0d0d0d_100%)]

                border border-orange-500/25

                flex flex-col
                ">
                    {{-- Subtle Close Button --}}
                    <button type="button" 
                        @click.stop="open = false"
                        class="
                    absolute
                    top-3
                    right-3

                    z-20
                    md:hidden

                    flex items-center justify-center

                    w-7 h-7

                    rounded-full

                    border border-white/10

                    bg-black/50
                    backdrop-blur-md

                    text-white/40
                    hover:text-white/70

                    transition-all duration-300
                    ">
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </button>

                    {{-- STRIPE --}}
                    <div
                        class="
                    h-[4px]
                    bg-[linear-gradient(to_right,#F97316,#EA6000,transparent)]
                    shrink-0
                    ">
                    </div>

                    {{-- IMAGE --}}
                    <div
                        class="
                    relative
                    h-[120px]
                    md:h-[150px]
                    overflow-hidden
                    shrink-0
                    ">

                        @if($kelompok->banner_exists)
                            <img src="{{ asset($kelompok->upload_kelompok_kelas) }}"
                                alt="{{ $kelompok->nama_kelompok }} - Program Latihan Sepak Bola Anak Bogor YTSS"
                                loading="lazy"
                                class="
                            w-full
                            h-full
                            object-cover

                            brightness-[0.40]
                            saturate-[0.8]
                            ">
                        @else
                            <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=600&auto=format&fit=crop"
                                alt="Default - Program Latihan Sepak Bola Anak Bogor YTSS"
                                loading="lazy"
                                class="
                            w-full
                            h-full
                            object-cover

                            brightness-[0.40]
                            saturate-[0.8]
                            ">
                        @endif

                        <div
                            class="
                        absolute inset-0
                        bg-[linear-gradient(to_bottom,transparent_30%,#1a0d00_100%)]
                        ">
                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div
                        class="
                    flex-1
                    flex flex-col
                    p-4
                    md:p-6
                    gap-3
                    md:gap-4
                    ">

                        <h3
                            class="
                        font-['Barlow_Condensed']
                        text-xl
                        md:text-[26px]
                        font-black
                        italic
                        uppercase
                        leading-none
                        text-white
                        ">
                            {{ $kelompok->nama_kelompok }}
                        </h3>

                        <div
                            class="
                        w-full
                        h-px
                        bg-[linear-gradient(to_right,rgba(249,115,22,0.4),transparent)]
                        ">
                        </div>




                        <div class="flex-1">

                            <div class="border-l-2 border-orange-500/60 pl-4">

                                <p
                                    class="
            text-white/70
            text-[13px]
            md:text-[14px]
            leading-[1.5]
            font-['Barlow_Condensed']
            line-clamp-3
            md:line-clamp-none
">
                                    {{ $kelompok->keterangan_kelompok_kelas }}
                                </p>

                            </div>


                        </div>

                        <a href="{{ route('register') }}"
                            class="
    relative
    overflow-hidden

    flex items-center justify-center

    w-full
    h-[40px]
    md:h-[48px]
    shrink-0

    rounded-[12px]
    md:rounded-[14px]

    bg-orange-500

    font-['Barlow_Condensed']
    text-[12px]
    font-black
    tracking-[0.14em]
    uppercase

    text-white

    shadow-[0_10px_30px_rgba(249,115,22,0.20)]

    transition-all duration-300

    hover:bg-[#EA6000]
    hover:-translate-y-[1px]
   ">
                            START YOUR JOURNEY <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                        </a>

                    </div>

                </div>

            </div>
        @endforeach

    </div>
</section>
