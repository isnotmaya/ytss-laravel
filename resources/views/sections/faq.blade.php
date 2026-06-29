<!-- FAQ SECTION -->
<section id="faq" class="relative overflow-hidden bg-black px-6 md:px-16 py-24 border-t border-white/[0.05]">

    <!-- BACKGROUND GLOW EFFECTS -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-orange-500/10 blur-3xl rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-20 -right-40 w-80 h-80 bg-orange-600/5 blur-3xl rounded-full pointer-events-none"></div>

    <div class="relative z-10 max-w-5xl mx-auto">

        <!-- TITLE & HEADER -->
        <div class="text-center mb-16 reveal-on-scroll">
            <p class="uppercase tracking-[4px] text-orange-400 text-xs font-bold mb-4 flex items-center justify-center gap-2">
                <span class="w-6 h-[2px] bg-orange-500"></span>
                Frequently Asked Questions
                <span class="w-6 h-[2px] bg-orange-500"></span>
            </p>
            <h2 class="text-4xl md:text-5xl font-black uppercase text-white tracking-wide">
                Pertanyaan <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">Sering Diajukan</span>
            </h2>
            <p class="text-sm md:text-base text-white/50 max-w-xl mx-auto mt-4 font-light">
                Temukan informasi lengkap mengenai latihan, program beasiswa, dan pembinaan sepak bola anak di Bogor bersama YTSS Soccer School.
            </p>
        </div>

        <!-- FAQ ACCORDION -->
        <div x-data="{ active: null }" class="space-y-4">

            @php
                $faqs = [
                    [
                        'q' => 'Di mana lokasi tempat latihan sepak bola anak Bogor di YTSS Soccer School?',
                        'a' => 'Tempat latihan sepak bola anak Bogor YTSS Soccer School berlokasi di Bogor, Jawa Barat. Kami menyediakan fasilitas lapangan berkualitas tinggi untuk mendukung perkembangan sepak bola anak secara optimal.'
                    ],
                    [
                        'q' => 'Mengapa YTSS dianggap sebagai sekolah sepak bola anak terbaik di Bogor?',
                        'a' => 'YTSS Soccer School adalah sekolah sepak bola anak terbaik di Bogor yang mengusung metode pembinaan sepak bola usia dini Bogor secara komprehensif. Kami fokus pada teknik, karakter, disiplin, dan didukung oleh pelatih berlisensi profesional.'
                    ],
                    [
                        'q' => 'Apakah YTSS merupakan sekolah sepak bola murah di Bogor dengan kualitas profesional?',
                        'a' => 'Ya, YTSS adalah sekolah sepak bola terjangkau di Bogor (SSB murah di Bogor) yang tetap berkomitmen menyajikan program latihan standar tinggi. Kami percaya pembinaan sepak bola berkualitas harus bisa diakses oleh seluruh kalangan masyarakat.'
                    ],
                    [
                        'q' => 'Bagaimana cara mendaftar program beasiswa sepak bola Bogor di YTSS Academy?',
                        'a' => 'Kami menyediakan beasiswa sepak bola Bogor bagi anak-anak berbakat. Orang tua dapat mengajukan berkas secara online melalui portal resmi YTSS Academy dengan menyertakan piagam prestasi atau video rekaman latihan anak.'
                    ],
                    [
                        'q' => 'Apa perbedaan antara SSB Bogor biasa dengan akademi sepak bola Bogor YTSS?',
                        'a' => 'YTSS sebagai akademi sepak bola murah di Bogor tidak hanya sekadar SSB Bogor biasa. Kami memiliki kurikulum terstruktur (Youth Tiger Soccer School), kelompok usia pembinaan dari U-8 hingga U-16, serta jaringan kompetisi regional dan nasional.'
                    ],
                    [
                        'q' => 'Bagaimana jadwal latihan sepak bola anak Bogor di YTSS?',
                        'a' => 'Jadwal latihan rutin kami diadakan beberapa kali dalam seminggu di sore hari, disesuaikan dengan masing-masing kelompok usia agar tidak mengganggu waktu sekolah formal anak.'
                    ]
                ];
            @endphp

            @foreach ($faqs as $index => $faq)
                <div class="group border border-white/[0.08] bg-white/[0.02] rounded-2xl overflow-hidden transition-all duration-300 hover:border-orange-500/30 hover:bg-white/[0.04] reveal-on-scroll"
                    style="transition-delay: {{ $index * 100 }}ms;">
                    
                    <!-- Accordion Trigger Button -->
                    <button 
                        @click="active = (active === {{ $index }} ? null : {{ $index }})"
                        class="w-full text-left px-6 py-5 flex items-center justify-between gap-4 font-semibold text-white/90 hover:text-white transition duration-300"
                        type="button">
                        <span class="text-sm md:text-base pr-4 group-hover:text-orange-400 transition-colors duration-300">
                            {{ $faq['q'] }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white/50 group-hover:text-orange-400 group-hover:border-orange-500/30 transition-all duration-300"
                             :class="{ 'rotate-185 bg-orange-500/10 border-orange-500/20 text-orange-400': active === {{ $index }} }">
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300"
                               :class="{ 'rotate-180': active === {{ $index }} }"></i>
                        </div>
                    </button>

                    <!-- Accordion Panel Content -->
                    <div 
                        x-show="active === {{ $index }}" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-[500px]"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 max-h-[500px]"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="border-t border-white/[0.05] bg-black/30"
                        style="display: none;">
                        <div class="px-6 py-5 text-sm leading-relaxed text-white/70">
                            {{ $faq['a'] }}
                        </div>
                    </div>

                </div>
            @endforeach

        </div>

    </div>

</section>
