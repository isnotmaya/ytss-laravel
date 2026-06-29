<!-- SIDEBAR -->
<aside
    class="before:absolute before:inset-0 before:bg-[linear-gradient(180deg,rgba(255,255,255,0.02),transparent_18%),repeating-linear-gradient(-55deg,transparent,transparent_26px,rgba(255,255,255,0.01)_26px,rgba(255,255,255,0.01)_27px)] before:pointer-events-none
after:absolute
after:-top-20
after:left-[-120px]
after:w-[240px]
after:h-[320px]
after:bg-[radial-gradient(circle,rgba(255,140,0,0.12),transparent_72%)]
after:blur-3xl
after:pointer-events-none fixed left-0 top-0 z-50 hidden h-full w-[96px] flex-col border-r border-orange-200/[0.08] bg-[linear-gradient(180deg,
rgba(10,10,10,0.94)_0%,
rgba(14,14,14,0.90)_45%,
rgba(54, 36, 21, 0.92)_100%
)] shadow-[14px_0_50px_rgba(0,0,0,0.42)] backdrop-blur-lg duration-300 md:flex">
    <!-- LOGO -->
    <a href="/" class="flex h-24 w-full items-center justify-center border-b border-white/[0.05]" title="Beranda">
        <img src="/images/ytss_logo.png" alt="Logo YTSS Soccer School - Sekolah Sepak Bola Bogor"
            class="h-18  w-18 object-contain transition duration-500 hover:scale-[1.04] md:h-18 md:w-18">
    </a>

    @php
        $sidebarItems = [
            ['href' => route('profile.sekolah'), 'icon' => 'fa-building-columns', 'label' => 'Profile Sekolah'],
            ['href' => route('achievements'), 'icon' => 'fa-trophy', 'label' => 'Achievement'],
            [
                'href' => route('schedule'),
                'icon' => 'fa-calendar-days',
                'label' => 'Jadwal Latihan',
            ],
            [
                'href' => route('agenda'),
                'icon' => 'fa-clipboard-list',
                'label' => 'Agenda',
            ],
            [
                'href' => route('tournament'),
                'icon' => 'fa-futbol',
                'label' => 'Tournament',
            ],
        ];
    @endphp

    <!-- DESKTOP SIDEBAR MENU -->
    <div class="mt-8 flex w-full flex-1 flex-col items-center gap-3">
        @foreach ($sidebarItems as $item)
            <a href="{{ $item['href'] }}"
                class="group relative flex h-16 w-full items-center justify-center opacity-0 animate-[slideInLeft_.5s_ease_forwards]">
                <div
                    class="absolute left-0 top-1/2 h-[26px] w-[2px] -translate-y-1/2 rounded-r-full bg-[#d98a3a]/80 opacity-0 transition-all duration-300 group-hover:h-[34px] group-hover:opacity-100">
                </div>

                <div
                    class="relative z-20 flex h-[46px] w-[46px] items-center justify-center rounded-[13px] border border-white/[0.07] bg-[linear-gradient(to_bottom,rgba(255,255,255,0.045),rgba(255,255,255,0.02))] shadow-[inset_0_1px_0_rgba(255,255,255,0.04),0_8px_18px_rgba(0,0,0,0.24)] transition-all duration-300 ease-out group-hover:-translate-y-[1px] group-hover:border-[#d98a3a]/30 group-hover:bg-[linear-gradient(to_bottom,rgba(217,138,58,0.16),rgba(217,138,58,0.06))] group-hover:shadow-[0_12px_28px_rgba(0,0,0,0.3)]">
                    <i
                        class="fa-solid {{ $item['icon'] }} text-[14px] text-[#f3e3cf]/76 transition-all duration-300 group-hover:scale-[1.05] group-hover:text-[#ffd6a2] group-hover:drop-shadow-[0_0_10px_rgba(255,180,80,0.35)]"></i>
                </div>

                <div
                    class="pointer-events-none absolute left-[76px] top-1/2 z-30 flex h-[44px] min-w-[178px] -translate-y-1/2 translate-x-[-6px] items-center rounded-[14px] border border-white/[0.08] bg-[rgba(28,24,21,0.96)] px-5 text-[11px] font-semibold uppercase tracking-[0.16em] text-[#f5eadc] opacity-0 shadow-[0_12px_28px_rgba(0,0,0,0.32)] transition-all duration-200 ease-out group-hover:translate-x-0 group-hover:opacity-100">
                    {{ $item['label'] }}
                </div>
            </a>
        @endforeach
    </div>
</aside>
