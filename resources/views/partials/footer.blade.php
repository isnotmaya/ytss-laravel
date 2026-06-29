<!-- FOOTER -->
<footer class="bg-[#f5f5f5] border-t border-white/5 text-black px-6 md:px-16 py-16 relative overflow-hidden">
    <!-- Subtle top glow for a premium transition from dark page to light footer -->
    <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-orange-500/20 to-transparent"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 reveal-on-scroll">

        <!-- LEFT COLUMN: Academy Branding -->
        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <img src="/images/ytss_logo.png" alt="YTSS Logo" class="w-12 h-12 object-contain">
                <div>
                    <div class="font-['Barlow_Condensed'] font-black text-2xl uppercase tracking-wide leading-none">
                        YTSS Academy
                    </div>
                    <div class="text-[9px] font-bold uppercase tracking-[0.25em] text-orange-600 mt-1">
                        Soccer School Bogor
                    </div>
                </div>
            </div>

            <p class="text-sm text-gray-600 leading-relaxed font-sans">
                Membangun generasi atlet sepak bola profesional melalui pembinaan disiplin, prestasi, dan pembentukan karakter unggul sejak usia dini.
            </p>

            <div class="flex gap-4 mt-6">
                <a href="https://www.instagram.com/youth_tigers_ss?igsh=MTNjd2ppYnQycTZ4ZQ==" target="_blank" rel="noopener noreferrer" 
                   class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-700 hover:text-white hover:bg-orange-500 hover:border-orange-500 transition duration-300"
                   title="Instagram">
                    <i class="fa-brands fa-instagram text-lg"></i>
                </a>
                <a href="https://wa.me/6281513562607" target="_blank" rel="noopener noreferrer" 
                   class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-700 hover:text-white hover:bg-emerald-500 hover:border-emerald-500 transition duration-300"
                   title="WhatsApp">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </a>
            </div>
        </div>

        <!-- MIDDLE COLUMN 1: Programs & Info -->
        <div>
            <div class="font-['Barlow_Condensed'] font-black uppercase text-lg tracking-wider mb-6 relative pb-2 after:absolute after:bottom-0 after:left-0 after:w-8 after:h-0.5 after:bg-orange-500">
                Program & Latihan
            </div>
            <div class="flex flex-col gap-3.5 text-sm text-gray-600 font-medium font-sans">
                <a href="{{ route('schedule') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Jadwal & Waktu Latihan</a>
                <a href="{{ route('agenda') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Agenda Kegiatan</a>
                <a href="{{ route('tournament') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Turnamen & Kompetisi</a>
                <a href="{{ route('achievements') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Prestasi & Galeri</a>
            </div>
        </div>

        <!-- MIDDLE COLUMN 2: Pendaftaran & Akses -->
        <div>
            <div class="font-['Barlow_Condensed'] font-black uppercase text-lg tracking-wider mb-6 relative pb-2 after:absolute after:bottom-0 after:left-0 after:w-8 after:h-0.5 after:bg-orange-500">
                Pendaftaran & Akses
            </div>
            <div class="flex flex-col gap-3.5 text-sm text-gray-600 font-medium font-sans">
                <a href="{{ route('register') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Pendaftaran Reguler</a>
                <a href="{{ route('register.beasiswa') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Pendaftaran Beasiswa</a>
                <a href="{{ route('check-status') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Cek Status Pendaftaran</a>
                <a href="{{ route('login') }}" class="hover:text-orange-500 hover:translate-x-1 transition duration-200">Portal Masuk (Login)</a>
            </div>
        </div>

        <!-- RIGHT COLUMN: Lokasi & Kontak -->
        <div>
            <div class="font-['Barlow_Condensed'] font-black uppercase text-lg tracking-wider mb-6 relative pb-2 after:absolute after:bottom-0 after:left-0 after:w-8 after:h-0.5 after:bg-orange-500">
                Kontak & Lokasi
            </div>
            <div class="space-y-4 text-sm text-gray-600 font-sans">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-location-dot text-orange-500 mt-1 flex-shrink-0"></i>
                    <p class="leading-relaxed">
                        Lapangan Heulang, Jl. Heulang, Tanah Sareal, Kota Bogor, Jawa Barat 16161
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-phone text-orange-500 flex-shrink-0"></i>
                    <a href="tel:+6281513562607" class="hover:text-orange-500 transition duration-200">+62 815-1356-2607</a>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-envelope text-orange-500 flex-shrink-0"></i>
                    <a href="mailto:info@ytss.com" class="hover:text-orange-500 transition duration-200">info@ytss.com</a>
                </div>
            </div>
        </div>

    </div>

    <!-- BOTTOM BAR -->
    <div class="max-w-7xl mx-auto border-t border-gray-300 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-5 text-xs text-gray-500 font-sans">
        <p>
            © {{ now()->year }} YTSS Soccer School. All Rights Reserved.
        </p>
        <p class="uppercase tracking-[4px] font-bold text-[10px]">
            Precision • Performance • Prestige
        </p>
    </div>
</footer>