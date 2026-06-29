<a href="{{ $href }}" @click="activeMenu = '{{ $menu }}'; mobileMenu = false"
    :class="activeMenu === '{{ $menu }}'
        ?
        'ring-1 ring-white/[0.02] group relative flex items-center justify-between overflow-hidden rounded-[22px] border border-[#d98a3a]/14 bg-[linear-gradient(135deg,rgba(217,138,58,0.10),rgba(217,138,58,0.03)_40%,rgba(255,255,255,0.015)_100%)] px-4 py-4 text-[#f1d2ad] backdrop-blur-xl shadow-[0_0_0_1px_rgba(217,138,58,0.08),0_14px_34px_rgba(0,0,0,0.28)] transition-all duration-300 ease-out active:scale-[0.985]' :
        'ring-1 ring-white/[0.02] group relative flex items-center justify-between overflow-hidden rounded-[22px] border border-white/[0.05] bg-[linear-gradient(180deg,rgba(255,255,255,0.035),rgba(255,255,255,0.018))] px-4 py-4 text-white/88 backdrop-blur-md shadow-[0_8px_22px_rgba(0,0,0,0.16)] transition-all duration-300 ease-out hover:border-[#d98a3a]/10 hover:bg-[linear-gradient(180deg,rgba(255,255,255,0.042),rgba(255,255,255,0.02))] active:scale-[0.985]'">

    <!-- ACTIVE LIGHT -->
    <div x-show="activeMenu === '{{ $menu }}'"
        class="pointer-events-none absolute inset-0 rounded-[22px] bg-[linear-gradient(135deg,rgba(217,138,58,0.035),transparent_58%)] ring-1 ring-[#d98a3a]/10 shadow-inner shadow-[#d98a3a]/[0.04]">
    </div>

    <div x-show="activeMenu === '{{ $menu }}'"
        class="pointer-events-none absolute inset-x-6 top-0 h-px
    bg-gradient-to-r from-transparent via-[#f3c892]/45 to-transparent">
    </div>

    <!-- TOP LIGHT -->
    <div
        class="pointer-events-none absolute inset-x-0 top-0 h-1/2 rounded-t-[22px]
    bg-gradient-to-b from-white/[0.03] to-transparent opacity-50">
    </div>

    <!-- ACTIVE AMBIENT -->
    <div x-show="activeMenu === '{{ $menu }}'"
        class="pointer-events-none absolute -left-8 top-2 h-16 w-32 rounded-full bg-[#d98a3a]/[0.06] blur-2xl">
    </div>

    <!-- HOVER WASH -->
    <div
        class="pointer-events-none absolute top-1/2 h-[72%] w-[52%]
left-4 -translate-y-1/2 rounded-[18px] bg-[#d98a3a]/0 opacity-0 transition-all duration-300 ease-out group-hover:bg-[#d98a3a]/[0.03] group-hover:opacity-100">
    </div>

    <div class="relative z-10 flex items-center gap-4">

        <!-- ICON -->
        <div class="flex h-10 w-10 items-center justify-center rounded-[13px] backdrop-blur-md transition-all duration-300 ease-out"
            :class="activeMenu === '{{ $menu }}'
                ?
                'border border-[#d98a3a]/14 bg-[linear-gradient(180deg,rgba(217,138,58,0.15),rgba(217,138,58,0.05))] ring-1 ring-[#f0c38f]/10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05),0_8px_18px_rgba(0,0,0,0.16)]' :
                'border border-white/[0.04] bg-[linear-gradient(180deg,rgba(255,255,255,0.06),rgba(255,255,255,0.028))] ring-1 ring-white/[0.025] shadow-[inset_0_1px_1px_rgba(255,255,255,0.03)] group-hover:border-[#d98a3a]/10 group-hover:bg-[linear-gradient(180deg,rgba(217,138,58,0.08),rgba(255,255,255,0.02))]'">

            <i class="{{ $icon }} text-[16px] transition duration-300"
                :class="activeMenu === '{{ $menu }}'
                    ?
                    'shadow-[0_0_18px_rgba(240,195,143,0.08)] text-[#efc18a]' :
                    'text-white/68 group-hover:text-white/78'"></i>

        </div>

        <!-- TEXT -->
        <div class="min-w-0">

            <p class="text-[14px] font-semibold uppercase tracking-[0.08em] leading-tight transition-colors duration-300"
                :class="activeMenu === '{{ $menu }}'
                    ?
                    'text-[#f4e7d6]' :
                    'text-white/88'">

                {{ $title }}

            </p>

            <span class="mt-1 block text-[10px] font-medium uppercase tracking-[0.11em] transition duration-300"
                :class="activeMenu === '{{ $menu }}'
                    ?
                    'text-[#efc18a]/60' :
                    'text-white/50'">

                {{ $subtitle }}

            </span>

        </div>

    </div>

    <!-- ARROW -->
    <i class="fa-solid fa-chevron-right relative z-10 mt-[1px] text-[11px] transition-all duration-300 group-active:translate-x-1"
        :class="activeMenu === '{{ $menu }}'
            ?
            'shadow-[0_0_18px_rgba(240,195,143,0.08)] text-[#efc18a]/60' :
            'text-white/34 group-hover:text-[#efc18a]/55'"></i>

</a>
