<!-- MOBILE MENU -->
<div x-cloak x-show="mobileMenu"
    class="fixed inset-0 z-[999] bg-[radial-gradient(circle_at_top_left,rgba(196,110,33,0.08),transparent_24%),radial-gradient(circle_at_bottom_right,rgba(196,110,33,0.05),transparent_28%),linear-gradient(180deg,#070707_0%,#0a0908_48%,#120d09_100%)] backdrop-blur-xl md:hidden">

    <!-- AMBIENT LIGHT -->
    <div class="absolute -left-24 -top-24 h-64 w-64 rounded-full bg-[#c46e21]/8 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 h-64 w-64 rounded-full bg-[#c46e21]/[0.06] blur-3xl"></div>

    <!-- TEXTURE -->
    <div class="absolute inset-0 opacity-[0.03]"
        style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.018)_0,rgba(255,255,255,0.018)_1px,transparent_1px,transparent_26px); mix-blend-mode: soft-light;">
    </div>

    <div class="pointer-events-none absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-white/[0.03] to-transparent">
    </div>

    <div class="relative z-10 flex h-screen flex-col overflow-y-auto">
        <!-- HEADER -->
        <div class="flex items-center justify-between border-b border-white/[0.05] px-6 py-4">

            <div class="flex items-center gap-3">

                <img src="/images/ytss_logo.png" alt="Logo Resmi YTSS Soccer School Bogor" class="h-11 w-11 object-contain">

                <div>

                    <p class="text-[11px] font-semibold uppercase tracking-[0.34em] text-[#d98a3a]/75">
                        YTSS
                    </p>

                    <p class="text-[10px] uppercase tracking-[0.18em] text-white/30">
                        Youth Tiger Soccer School
                    </p>

                </div>

            </div>

            <button @click="mobileMenu = false"
                class="flex h-10 w-10 items-center justify-center rounded-[18px] border border-white/[0.06] bg-white/[0.03] backdrop-blur-md transition-all duration-300 hover:border-[#d98a3a]/20 hover:bg-white/[0.05] active:scale-[0.95]">

                <i class="fa-solid fa-xmark text-[18px] text-white/70"></i>

            </button>

        </div>

        <!-- CONTENT -->
        <div class="flex-1 px-5 pb-8 pt-8">
            <div class="space-y-8">

                <!-- MAIN MENU -->
                <div>

                    <div class="mb-4 flex items-center gap-3 px-1">

                        <div class="h-px w-10 bg-[#d98a3a]/25"></div>

                        <p class="text-[10px] font-medium uppercase tracking-[0.36em] text-[#d98a3a]/52">
                            Main Menu
                        </p>

                    </div>

                    <div class="space-y-4">

                        @include('partials.mobile-menu-item', [
                            'href' => route('profile.sekolah'),
                            'menu' => 'profile',
                            'icon' => 'fa-solid fa-school',
                            'title' => 'Profile Sekolah',
                            'subtitle' => 'About academy & vision',
                        ])

                        @include('partials.mobile-menu-item', [
                            'href' => route('achievements'),
                            'menu' => 'achievement',
                            'icon' => 'fa-solid fa-trophy',
                            'title' => 'Prestasi',
                            'subtitle' => 'Trophy & achievements',
                        ])

                    </div>

                </div>

                <!-- ACADEMY -->
                <div>

                    <div class="mb-4 flex items-center gap-3 px-1">

                        <div class="h-px w-10 bg-[#d98a3a]/20"></div>

                        <p class="text-[10px] font-medium uppercase tracking-[0.36em] text-[#d98a3a]/48">
                            Academy
                        </p>

                    </div>

                    <div class="space-y-4">

                        @include('partials.mobile-menu-item', [
                            'href' => route('schedule'),
                            'menu' => 'schedule',
                            'icon' => 'fa-solid fa-calendar',
                            'title' => 'Jadwal Latihan',
                            'subtitle' => 'Weekly training session',
                        ])

                        @include('partials.mobile-menu-item', [
                            'href' => route('agenda'),
                            'menu' => 'agenda',
                            'icon' => 'fa-solid fa-clipboard',
                            'title' => 'Agenda',
                            'subtitle' => 'Upcoming academy events',
                        ])

                    </div>

                </div>

                <!-- EVENTS -->
                <div>

                    <div class="mb-4 flex items-center gap-3 px-1">

                        <div class="h-px w-10 bg-[#d98a3a]/20"></div>

                        <p class="text-[10px] font-medium uppercase tracking-[0.36em] text-[#d98a3a]/48">
                            Events
                        </p>

                    </div>

                    <div class="space-y-4">

                        @include('partials.mobile-menu-item', [
                            'href' => route('tournament'),
                            'menu' => 'tournament',
                            'icon' => 'fa-solid fa-futbol',
                            'title' => 'Tournament',
                            'subtitle' => 'Match & competition info',
                        ])

                    </div>

                </div>

            </div>

        </div>

        <!-- SOCIAL -->
        <div class="mt-auto w-full px-5 pb-[max(1.5rem,env(safe-area-inset-bottom))] pt-2">

            <div class="border-t border-white/[0.05] pt-5">

                @include('partials.social-mobile')

            </div>

            <div class="mt-5 text-center">

                <p class="text-[10px] tracking-[0.25em] text-white/20 uppercase">
                    Follow The Tigers
                </p>

            </div>

        </div>


    </div>

</div>
