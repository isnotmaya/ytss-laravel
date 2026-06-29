<!-- STATS SECTION -->
<section class="relative overflow-hidden bg-[#111111] px-6 md:px-16 py-24">

    <!-- BACKGROUND GLOW -->
    <div class="absolute top-0 left-0 w-80 h-80 bg-orange-500/10 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-orange-500/5 blur-3xl rounded-full"></div>

    <div class="relative z-10">

        <!-- TITLE -->
        <div class="text-center mb-16 reveal-on-scroll">
            <p class="text-orange-500 uppercase tracking-[0.3em] text-xs font-bold">
                YTSS IN NUMBERS
            </p>

            <h2 class="font-['Barlow_Condensed'] uppercase font-black text-5xl md:text-6xl mt-3">
                OUR PERFORMANCE
            </h2>
        </div>

        <div class="grid grid-cols-2 xl:grid-cols-4 gap-6">

            <!-- ACTIVE PLAYERS -->
            <div class="reveal-on-scroll" style="transition-delay: 0ms;">
                <div
                    x-data="{
                    count:0,
                    rx:0,
                    ry:0
                }"
                x-intersect.once="
                    let target={{ $stats['siswa'] }};
                    let interval=setInterval(()=>{
                        if(count<target){
                            count++;
                        }else{
                            clearInterval(interval);
                        }
                    },15);
                "
                @mousemove="
                    const rect=$el.getBoundingClientRect();

                    const x=$event.clientX-rect.left;
                    const y=$event.clientY-rect.top;

                    ry=((x/rect.width)-0.5)*16;
                    rx=((y/rect.height)-0.5)*-16;
                "
                @mouseleave="
                    rx=0;
                    ry=0;
                "
                :style="`
                    transform:
                    perspective(1000px)
                    rotateX(${rx}deg)
                    rotateY(${ry}deg)
                    translateY(-8px);
                `"
                class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-white/[0.03] backdrop-blur-md p-8 text-center transition-all duration-300 hover:border-orange-500/30 hover:shadow-[0_20px_60px_rgba(249,115,22,0.18)]">

                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500"
                    :style="`
                        background:
                        radial-gradient(
                            circle at ${50 + ry * 3}% ${50 - rx * 3}%,
                            rgba(249,115,22,.18),
                            transparent 60%
                        );
                    `">
                </div>

                <div class="relative z-10">

                    <i data-lucide="users"
                        class="w-10 h-10 mx-auto text-orange-500 mb-5 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    </i>

                    <h3 class="text-4xl md:text-5xl font-black text-orange-500 transition-all duration-300 group-hover:scale-110">
                        <span x-text="count"></span>
                    </h3>

                    <p class="uppercase font-bold mt-4 tracking-widest text-sm">
                        ACTIVE PLAYERS
                    </p>

                    <p class="text-white/50 text-xs mt-2">
                        Registered students actively training
                    </p>

                </div>

            </div>
            </div>

            <!-- TRAINING GROUPS -->
            <div class="reveal-on-scroll" style="transition-delay: 100ms;">
                <div
                    x-data="{
                        count:0,
                        rx:0,
                        ry:0
                    }"
                x-intersect.once="
                    let target={{ $stats['kelompok'] }};
                    let interval=setInterval(()=>{
                        if(count<target){
                            count++;
                        }else{
                            clearInterval(interval);
                        }
                    },50);
                "
                @mousemove="
                    const rect=$el.getBoundingClientRect();

                    const x=$event.clientX-rect.left;
                    const y=$event.clientY-rect.top;

                    ry=((x/rect.width)-0.5)*16;
                    rx=((y/rect.height)-0.5)*-16;
                "
                @mouseleave="
                    rx=0;
                    ry=0;
                "
                :style="`
                    transform:
                    perspective(1000px)
                    rotateX(${rx}deg)
                    rotateY(${ry}deg)
                    translateY(-8px);
                `"
                class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-white/[0.03] backdrop-blur-md p-8 text-center transition-all duration-300 hover:border-orange-500/30 hover:shadow-[0_20px_60px_rgba(249,115,22,0.18)]">

                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500"
                    :style="`
                        background:
                        radial-gradient(
                            circle at ${50 + ry * 3}% ${50 - rx * 3}%,
                            rgba(249,115,22,.18),
                            transparent 60%
                        );
                    `">
                </div>

                <div class="relative z-10">

                    <i data-lucide="shield"
                        class="w-10 h-10 mx-auto text-orange-500 mb-5 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    </i>

                    <h3 class="text-4xl md:text-5xl font-black text-orange-500 transition-all duration-300 group-hover:scale-110">
                        <span x-text="count"></span>
                    </h3>

                    <p class="uppercase font-bold mt-4 tracking-widest text-sm">
                        TRAINING GROUPS
                    </p>

                    <p class="text-white/50 text-xs mt-2">
                        Development categories by age
                    </p>

                </div>

            </div>
            </div>

            <!-- ACHIEVEMENTS -->
            <div class="reveal-on-scroll" style="transition-delay: 200ms;">
                <div
                    x-data="{count:0,rx:0,ry:0}"
                x-intersect.once="
                    let target={{ $stats['prestasi'] }};
                    let interval=setInterval(()=>{
                        if(count<target){
                            count++;
                        }else{
                            clearInterval(interval);
                        }
                    },40);
                "
                @mousemove="
                    const rect=$el.getBoundingClientRect();
                    const x=$event.clientX-rect.left;
                    const y=$event.clientY-rect.top;
                    ry=((x/rect.width)-0.5)*16;
                    rx=((y/rect.height)-0.5)*-16;
                "
                @mouseleave="rx=0;ry=0;"
                :style="`
                    transform:
                    perspective(1000px)
                    rotateX(${rx}deg)
                    rotateY(${ry}deg)
                    translateY(-8px);
                `"
                class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-white/[0.03] backdrop-blur-md p-8 text-center transition-all duration-300 hover:border-orange-500/30 hover:shadow-[0_20px_60px_rgba(249,115,22,0.18)]">

                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500"
                    :style="`
                        background:
                        radial-gradient(
                            circle at ${50 + ry * 3}% ${50 - rx * 3}%,
                            rgba(249,115,22,.18),
                            transparent 60%
                        );
                    `">
                </div>

                <div class="relative z-10">

                    <i data-lucide="trophy"
                        class="w-10 h-10 mx-auto text-orange-500 mb-5 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    </i>

                    <h3 class="text-4xl md:text-5xl font-black text-orange-500 transition-all duration-300 group-hover:scale-110">
                        <span x-text="count"></span>
                    </h3>

                    <p class="uppercase font-bold mt-4 tracking-widest text-sm">
                        ACHIEVEMENTS
                    </p>

                    <p class="text-white/50 text-xs mt-2">
                        Awards earned by YTSS teams
                    </p>

                </div>

            </div>
            </div>

            <!-- TOURNAMENTS -->
            <div class="reveal-on-scroll" style="transition-delay: 300ms;">
                <div
                    x-data="{count:0,rx:0,ry:0}"
                x-intersect.once="
                    let target={{ $stats['tournament'] }};
                    let interval=setInterval(()=>{
                        if(count<target){
                            count++;
                        }else{
                            clearInterval(interval);
                        }
                    },40);
                "
                @mousemove="
                    const rect=$el.getBoundingClientRect();
                    const x=$event.clientX-rect.left;
                    const y=$event.clientY-rect.top;
                    ry=((x/rect.width)-0.5)*16;
                    rx=((y/rect.height)-0.5)*-16;
                "
                @mouseleave="rx=0;ry=0;"
                :style="`
                    transform:
                    perspective(1000px)
                    rotateX(${rx}deg)
                    rotateY(${ry}deg)
                    translateY(-8px);
                `"
                class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-white/[0.03] backdrop-blur-md p-8 text-center transition-all duration-300 hover:border-orange-500/30 hover:shadow-[0_20px_60px_rgba(249,115,22,0.18)]">

                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500"
                    :style="`
                        background:
                        radial-gradient(
                            circle at ${50 + ry * 3}% ${50 - rx * 3}%,
                            rgba(249,115,22,.18),
                            transparent 60%
                        );
                    `">
                </div>

                <div class="relative z-10">

                    <i data-lucide="medal"
                        class="w-10 h-10 mx-auto text-orange-500 mb-5 transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
                    </i>

                    <h3 class="text-4xl md:text-5xl font-black text-orange-500 transition-all duration-300 group-hover:scale-110">
                        <span x-text="count"></span>
                    </h3>

                    <p class="uppercase font-bold mt-4 tracking-widest text-sm">
                        TOURNAMENTS
                    </p>

                    <p class="text-white/50 text-xs mt-2">
                        Competitions and events joined
                    </p>

                </div>

            </div>
            </div>

        </div>

    </div>

</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});
</script>