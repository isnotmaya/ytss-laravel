<!-- HERO SECTION -->
<section class="relative min-h-screen overflow-hidden -mt-16 md:mt-0">
    <!-- BACKGROUND -->
    <div class="absolute inset-0">

        <video autoplay muted loop playsinline class="w-full h-full object-cover object-center">

            <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">

        </video>

        <!-- MAIN OVERLAY -->
        <div class="absolute inset-0
        bg-gradient-to-b
        from-black/18
via-black/14
to-[#ff9a00]/18">
        </div>
        <div class="absolute inset-0
bg-[linear-gradient(to_top,rgba(255,145,0,0.08),transparent_40%)]">
        </div>
        <!-- CINEMATIC DEPTH -->
        <div
            class="absolute inset-0
        bg-[radial-gradient(circle_at_top_left,rgba(255,138,0,0.10),transparent_30%)]">
        </div>

        <div
            class="absolute inset-0
        bg-[radial-gradient(circle_at_bottom_right,rgba(255,138,0,0.08),transparent_35%)]">
        </div>

        <!-- GOLDEN ENERGY LIGHT -->
        <div class="absolute inset-0
bg-[radial-gradient(circle_at_bottom_left,rgba(255,180,60,0.18),transparent_38%)]">
        </div>

        <div class="absolute inset-0
bg-[radial-gradient(circle_at_top_right,rgba(255,160,40,0.10),transparent_30%)]">
        </div>
        <!-- VIGNETTE -->
        <div class="absolute inset-0
    bg-[radial-gradient(circle,transparent_45%,rgba(0,0,0,0.32)_100%)]">
        </div>
        <!-- FILMIC DEPTH -->
        <div
            class="absolute inset-0
bg-[linear-gradient(to_right,rgba(0,0,0,0.42),transparent_38%,transparent_70%,rgba(0,0,0,0.38))]
pointer-events-none">
        </div>
    </div>
    <!-- CTA READABILITY OVERLAY -->
    <div
        class="absolute inset-x-0 bottom-0

h-[38%]

bg-gradient-to-t
from-black/55
via-black/18
to-transparent

pointer-events-none">
    </div>

    <!-- CONTENT -->
    <div
        class="relative overflow-hidden z-10 max-w-[1180px] mx-auto
px-6 sm:px-7 md:px-16 xl:px-24
pt-24 md:pt-20 pb-12 md:pb-16
before:absolute
before:left-0
before:top-16
before:w-[620px]
before:h-[420px]
before:bg-[radial-gradient(circle,rgba(0,0,0,0.22),transparent_72%)]
before:blur-3xl
before:pointer-events-none">

        <!-- FLOATING ATMOSPHERE -->
        <div
            class="absolute
    -left-24 top-10

    w-[520px]
    h-[520px]

    bg-[radial-gradient(circle,rgba(255,138,0,0.10),transparent_70%)]

    blur-3xl
    opacity-70
    pointer-events-none">
        </div>
        <div class="
flex items-center justify-center md:justify-start

gap-4

mt-2
">

            <div class="w-10 h-[2px] bg-orange-500"></div>

            <span
                class="
    animate-hero-season

    font-['Barlow_Condensed']

    uppercase

    text-[11px]
    font-bold

    tracking-[0.42em]

    text-orange-400/95

    drop-shadow-[0_0_10px_rgba(255,140,0,0.18)]">

                @php
                    $year = now()->year;
                    $nextYear = substr($year + 1, -2);
                @endphp

                Season {{ $year }} / {{ $nextYear }} — Pendaftaran Dibuka
            </span>

        </div>

        <h1
            class="animate-hero-title mt-6 md:mt-8

max-w-[340px]
md:max-w-3xl

mx-auto md:mx-0

text-center md:text-left

font-['Barlow_Condensed']
italic
font-black
uppercase

leading-[0.88] md:leading-[0.82]
tracking-[-0.03em]

text-[clamp(2.15rem,11vw,6.5rem)]
text-white

drop-shadow-[0_12px_40px_rgba(0,0,0,0.58)]">
            Shape Your
            <span class="text-orange-400 animate-hero-accent">
                Future
            </span> <br>
            On The Pitch
        </h1>

<p class="
animate-hero-subtitle
mt-5 md:mt-6

max-w-[620px]

mx-auto md:mx-0

text-center md:text-left
">            <span
class="
block
text-orange-400
font-['Barlow_Condensed']
font-bold
uppercase
tracking-[0.12em]
text-sm md:text-base
mb-2

text-center md:text-left
">
                Latih Potensi. Bangun Karakter. Raih Prestasi.
            </span>

            <span
class="
block
font-['Barlow_Condensed']
text-white/75

text-sm md:text-xl

leading-relaxed
tracking-[0.03em]

text-center md:text-left
">
    Bersama YTSS Soccer School, setiap anak mendapat kesempatan untuk berkembang, berprestasi, dan meraih masa depan yang lebih baik melalui sepak bola.
</span>
        </p>

        <!-- PREMIUM CTA -->
        <div
            class="animate-hero-cta flex flex-col sm:flex-row

items-center md:items-start

gap-4 md:gap-5

mt-8 md:mt-10">

            <!-- PREMIUM CINEMATIC CTA -->
            <a href="{{ route('register.beasiswa') }}"
                class="group relative overflow-hidden
    h-[46px] md:h-[54px] w-[240px] md:w-auto px-5 md:px-7
    before:shadow-[0_0_80px_rgba(255,140,0,0.18)]
    rounded-full
    border border-white/14
    bg-[linear-gradient(180deg,#ff9a1f_0%,#ff8a00_45%,#c95500_100%)]
    backdrop-blur-2xl
    flex items-center justify-center
    uppercase
    text-[11px] md:text-[13px]
    font-bold
    tracking-[0.10em] md:tracking-[0.18em]
    text-white
    font-['Barlow_Condensed']">

                <!-- SWEEP SHINE -->
                <div
                    class="absolute inset-0

opacity-0
group-hover:opacity-100

transition-opacity duration-300

before:absolute
before:top-0
before:left-[-140%]

before:h-full
before:w-[55%]

before:skew-x-[-22deg]

before:bg-[linear-gradient(to_right,transparent,rgba(255,255,255,0.30),transparent)]

before:blur-[2px]

group-hover:before:left-[160%]

before:transition-all
before:duration-700">
                </div>
                <!-- CINEMATIC ORB -->
                <div
                    class="absolute

    -right-6
    top-1/2
    -translate-y-1/2

    w-28
    h-28

    rounded-full

    bg-orange-300/12

    blur-[38px]

    opacity-70

    transition-all duration-700

    group-hover:scale-[1.35]
    group-hover:opacity-100
    group-hover:-right-2">
                </div>



                <!-- TOP REFLECTION -->
                <div
                    class="absolute

    inset-x-6
    top-[1px]

    h-[1px]

    bg-gradient-to-r
    from-transparent
    via-white/30
    to-transparent">
                </div>
                <div
                    class="absolute inset-0

opacity-0
group-hover:opacity-100

transition duration-700

bg-[linear-gradient(120deg,transparent_10%,rgba(255,255,255,0.16)_50%,transparent_90%)]">
                </div>
                <span
                    class="
relative z-10

flex items-center gap-2 md:gap-3

animate-cta-flow

transition-all duration-500 ease-out

group-hover:translate-x-[4px]
">

                    <span
                        class="

transition-all duration-700 ease-[cubic-bezier(.22,1,.36,1)]

group-hover:text-white

group-hover:drop-shadow-[0_0_12px_rgba(255,220,160,0.32)]
">

                        Ajukan Beasiswa

                    </span>

                    <span
                        class="
    animate-chevron-flow delay-75
transition-all duration-700 ease-out
    text-[9px] md:text-[11px]

    tracking-[-0.10em]

    bg-[linear-gradient(180deg,#ffd89a_0%,#ffae42_40%,#ff7a00_100%)]

    bg-clip-text
    text-transparent

    opacity-100

    drop-shadow-[0_0_8px_rgba(255,150,40,0.20)]
    ">

                        ❯❯❯

                    </span>

                </span>
            </a>
            <!-- PREMIUM SECONDARY CTA -->
            <a href="{{ route('register') }}"
                class="group relative overflow-hidden

h-[46px] md:h-[54px]
w-[240px] md:w-auto
px-5 md:px-7

rounded-full

border border-white/16

bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.22),rgba(255,255,255,0.04))] backdrop-blur-2xl
font-['Barlow_Condensed']
uppercase
text-[11px] md:text-[12px]
font-bold
tracking-[0.10em] md:tracking-[0.16em]
text-white

shadow-[inset_0_1px_1px_rgba(255,255,255,0.05),0_14px_38px_rgba(0,0,0,0.28),0_0_30px_rgba(255,255,255,0.06)]

transition-all duration-500 ease-[cubic-bezier(.22,1,.36,1)]

hover:border-orange-300/18
hover:bg-white/[0.1]
hover:-translate-y-[2px]
hover:shadow-[0_18px_48px_rgba(255,180,60,0.20)]
active:translate-y-[1px]

flex items-center justify-center">

                <!-- AMBIENT LIGHT -->
                <div
                    class="absolute

    -left-10
    top-1/2
    -translate-y-1/2

    w-24
    h-24

    rounded-full

    bg-white/[0.07]

    blur-3xl

    opacity-40

    transition-all duration-700

    group-hover:left-4
    group-hover:bg-orange-200/10
    group-hover:opacity-80">
                </div>

                <div
                    class="absolute

    right-5
    top-1/2
    -translate-y-1/2

    w-[70px]
    h-[70px]

    rounded-full

    bg-orange-300/10

    blur-2xl

    opacity-0

    transition-all duration-500

    group-hover:opacity-80
    pointer-events-none">
                </div>

                <!-- GLASS SWEEP -->
                <div
                    class="absolute inset-0

    opacity-0
    group-hover:opacity-100

    transition duration-700

    bg-[linear-gradient(120deg,transparent_10%,rgba(255,255,255,0.16)_50%,transparent_90%)]">
                </div>

                <!-- TOP LIGHT -->
                <div
                    class="absolute
    inset-x-5
    top-0

    h-[1px]

    bg-gradient-to-r
    from-transparent
    via-white/20
    to-transparent">
                </div>

                <span
                    class="relative z-10

flex items-center justify-center gap-2 md:gap-3
    transition-all duration-500 ease-[cubic-bezier(.22,1,.36,1)]

    group-hover:translate-x-[2px]
    group-hover:-translate-y-[1px]
    hover:scale-[1.015]">

                    <span
                        class="transition-all duration-500 ease-[cubic-bezier(.22,1,.36,1)]
        group-hover:text-orange-100">

                        Pendaftaran

                    </span>

                </span>

            </a>

        </div>

    </div>

    @include('partials.social-desktop')

</section>
