    <nav x-data="{ scrolled: false }"
        x-init="scrolled = (window.pageYOffset > 20)"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        class="relative h-[66px] md:h-[68px] flex items-center justify-between px-4 md:px-0 md:pl-10 md:pr-6 xl:pl-14 xl:pr-8 sticky top-0 z-40 overflow-visible border-b md:border-b-0 md:bg-[linear-gradient(to_right,#f97316,#f97316,#f97316)] md:shadow-[0_10px_40px_rgba(0,0,0,0.25)] md:backdrop-blur-md transition-all duration-500 ease-out"
        :class="scrolled ? 'bg-[#050505]/75 backdrop-blur-xl border-white/5 shadow-lg shadow-black/30' : 'bg-transparent border-transparent shadow-none backdrop-blur-none'">
        <!-- ATMOSPHERIC DEPTH -->
        <div class="absolute inset-0 pointer-events-none hidden md:block">

            <!-- DARK CINEMATIC TOP -->
            <div class="absolute inset-0
    bg-gradient-to-b
    from-white/10
via-transparent
to-black/5">
            </div>

            <!-- LEFT LIGHT -->
            <div
                class="absolute
    -left-20
    top-[-120px]

    w-[420px]
    h-[260px]

    rounded-full

    bg-orange-200/20

    blur-3xl

    opacity-60">
            </div>

            <!-- RIGHT VIGNETTE -->
            <div
                class="absolute
    right-[-120px]
    top-[-80px]

    w-[380px]
    h-[220px]

    rounded-full

    bg-orange-500/10

    blur-3xl">
            </div>

            <!-- FILMIC SHADOW -->
            <div
                class="absolute bottom-0 inset-x-0

    h-[28px]

    bg-gradient-to-b
    from-transparent
    to-black/20">
            </div>

        </div>

        <!-- MOBILE MENU BUTTON -->
        <button @click="mobileMenu = true"
            class="
md:hidden

w-10
h-10
rounded-xl
border border-white/5
hover:bg-white/5

drop-shadow-[0_2px_8px_rgba(0,0,0,0.45)]
flex items-center justify-center

text-white text-[16px]

transition-all duration-300
">

            <i class="fa-solid fa-bars"></i>

        </button>
        <!-- LEFT DESKTOP -->
        <div class="hidden md:flex items-center gap-10 relative z-10">

            <div class="flex flex-col ml-4 leading-none">

                <div
                    class="
font-['Barlow_Condensed']
text-[28px]
font-black
tracking-[0.02em]
uppercase
text-white
drop-shadow-lg">

                    YTSS Academy

                </div>

                <span
                    class="
font-['Barlow_Condensed']
mt-[2px]
text-[11px]
uppercase
tracking-[0.28em]
text-white/80
font-semibold">

                    Football Academy Program

                </span>

            </div>

            <!-- DIVIDER -->
            <div class="h-10 w-px bg-white/20"></div>

<a href="{{ route('register.beasiswa') }}"                class="group relative overflow-hidden

flex items-center gap-3

px-6 py-2.5

rounded-full

border border-white/15
bg-white/[0.05]
backdrop-blur-lg

text-white
font-['Barlow_Condensed']
font-bold
tracking-[0.18em]
text-[12px]
uppercase

shadow-[inset_0_1px_1px_rgba(255,255,255,0.12),0_4px_18px_rgba(0,0,0,0.18)]

transition-all duration-500

hover:bg-white/[0.18]
hover:border-white/30
hover:-translate-y-[1px]">

                <div
                    class="absolute inset-0 opacity-0
    group-hover:opacity-100
    transition duration-500

    bg-[linear-gradient(to_right,transparent,rgba(255,255,255,0.10),transparent)]">
                </div>

                <i class="fa-solid fa-graduation-cap relative z-10 text-[10px]"></i>

                <span class="relative z-10">
                    Ajukan Beasiswa
                </span>

            </a>

        </div>

        <!-- MOBILE LOGO -->
        <div class="md:hidden absolute left-1/2 -translate-x-1/2 flex items-center justify-center">

            <img src="/images/ytss_logo.png"
                alt="Logo Resmi YTSS Soccer School Bogor"
                class="
w-[64px]
h-[54px]

object-contain

drop-shadow-[0_3px_10px_rgba(0,0,0,0.45)]
">

        </div>
        <!-- RIGHT -->
        <div class="flex items-center gap-3 ml-auto relative">

            <!-- MOBILE PROFILE -->
            <div class="md:hidden relative">

                <!-- BUTTON -->
                <button @click="profileMenu = !profileMenu"
                    class="
text-white
drop-shadow-[0_2px_8px_rgba(0,0,0,0.45)]
text-[16px]

w-10
h-10
rounded-xl
border border-white/5

flex items-center justify-center

transition-all duration-300

hover:bg-white/5
">

                    <i class="fa-regular fa-user"></i>

                </button>

                <!-- DROPDOWN -->
                <div x-show="profileMenu" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    @click.away="profileMenu = false"
                    class="absolute right-0 mt-5 w-[185px] overflow-hidden rounded-[18px] border border-white/[0.05] ring-1 ring-white/[0.02] bg-[linear-gradient(180deg,rgba(16,12,9,0.88)_0%,rgba(10,8,6,0.82)_100%)] backdrop-blur-xl shadow-[0_12px_28px_rgba(0,0,0,0.32)] z-[999]">
                    <div
                        class="absolute -top-10 right-[-20px] w-[120px] h-[120px]

rounded-[14px] bg-[#d98a3a]/10

blur-2xl

pointer-events-none
">
                    </div>

                    <div
                        class="
px-6
pt-4
pb-2

text-[10px]

font-bold

tracking-[0.22em]

uppercase

text-[#d98a3a]/55
font-['Barlow_Condensed']
">

                        Account Access

                    </div>
                    <a href="{{ route('login') }}"
                        class="
                        overflow-hidden rounded-[14px] mx-2 group relative flex items-center px-5 py-3 transition-all duration-300 active:scale-[0.97]">

                        <!-- HOVER BG -->
                        <div
                            class="absolute inset-0 opacity-0 transition duration-300 group-hover:opacity-100 bg-[linear-gradient(to_right,rgba(217,138,58,0.06),transparent)]">
                        </div>

                        <div class="relative z-10 flex w-full items-center gap-4">

                            <div
                                class="w-8 h-8 rounded-[14px] flex items-center justify-center pl-[1px] shrink-0 bg-[#d98a3a]/10 border-[#d98a3a]/15 text-orange-300 text-[12px]">

                                <i class="fa-solid fa-user"></i>

                            </div>

                            <div class="flex flex-col">

                                <span
                                    class="font-['Barlow_Condensed'] text-[14px] tracking-[0.08em] font-bold uppercase text-white">

                                    Login

                                </span>


                            </div>

                        </div>
                    </a>

                    <div class="mx-5 h-px bg-white/[0.05]"></div>

                    <a href="{{ route('register') }}"
                        class="overflow-hidden rounded-[14px] mx-2 group relative flex items-center px-6 py-3 transition-all duration-300 active:scale-[0.97]">

                        <div
                            class="absolute inset-0 opacity-0 transition duration-300 group-hover:opacity-100 bg-[linear-gradient(to_right,rgba(217,138,58,0.06),transparent)]">
                        </div>

                        <div class="relative z-10 flex w-full items-center gap-4">

                            <div
                                class="w-8 h-8 rounded-[14px] flex items-center justify-center shrink-0 bg-[#d98a3a]/10 border-[#d98a3a]/15 text-orange-300 text-[12px]">

                                <i class="fa-solid fa-user-plus"></i>

                            </div>

                            <div class="flex flex-col">

                                <span
                                    class="font-['Barlow_Condensed'] text-[14px] tracking-[0.08em] font-bold uppercase text-white">

                                    Daftar

                                </span>

                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <!-- DESKTOP AUTH -->
            <div class="hidden md:flex items-center">

                <div
                    class="
    relative group flex items-center

    p-[4px]

    rounded-[16px]

    border border-white/[0.08]
    bg-[linear-gradient(to_bottom,rgba(255,255,255,0.12),rgba(255,255,255,0.03))]
    backdrop-blur-2xl
    backdrop-saturate-130

    shadow-[inset_0_1px_1px_rgba(255,255,255,0.10),0_12px_32px_rgba(0,0,0,0.22),0_0_42px_rgba(255,160,0,0.20)]
    overflow-hidden

    transition-all duration-500 ease-[cubic-bezier(.22,1,.36,1)]
    hover:shadow-[0_16px_45px_rgba(255,160,0,0.18)]
    ">

                    <div
                        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2
    w-[150px]
    h-[150px]
    rounded-full
    bg-orange-400/12
    blur-3xl
    opacity-0
    pointer-events-none
    transition duration-500
    group-hover:opacity-100">
                    </div>

                    <!-- ACTIVE GLIDER -->
                    <div class="absolute

top-[4px]
left-[5px]
h-[calc(100%-8px)]
w-[84px]

rounded-[10px]

border border-white/[0.08]

bg-gradient-to-br
from-[#4a2200]
via-[#6a2b00]
to-[#3a1800]

shadow-[0_0_24px_rgba(255,160,0,0.14),inset_0_1px_1px_rgba(255,255,255,0.05)]

transition-all duration-500 ease-[cubic-bezier(.22,1,.36,1)]"
                        :class="authTab === 'daftar'
                            ?
                            'translate-x-[84px]' :
                            'translate-x-0'">
                    </div>

                    <!-- LOGIN -->
                    <a href="{{ route('login') }}"
                        @click="authTab = 'login'"
                        class="
            relative z-10

            w-[90px]

            px-5 py-2

font-['Barlow_Condensed']
text-[12px]
font-bold
uppercase

            text-center

            transition-all duration-400 ease-[cubic-bezier(.22,1,.36,1)]"
                        :class="authTab === 'login'
                            ?
                            'text-white' :
                            'text-black/85 hover:text-black/95'">

                        Login

                    </a>

                    <!-- DAFTAR -->
                    <a href="{{ route('register') }}"
                        @click="authTab = 'daftar'"
                        class="
            relative z-10

            w-[80px]

            px-2 py-2

font-['Barlow_Condensed']
text-[13px]
font-bold
uppercase

            text-center

            transition-all duration-400 ease-[cubic-bezier(.22,1,.36,1)]"
                        :class="authTab === 'daftar'
                            ?
                            'text-white' :
                            'text-black/85 hover:text-black/95'">

                        Daftar

                    </a>

                </div>

            </div>


        </div>

    </nav>
