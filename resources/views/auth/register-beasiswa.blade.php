@extends('layouts.app')

@section('seo_title', 'Pendaftaran Beasiswa Sepak Bola Bogor | YTSS Soccer School')
@section('seo_description', 'Pendaftaran program beasiswa sepak bola anak di Bogor oleh YTSS Soccer School. Raih kesempatan pembinaan akademis & bakat sepak bola gratis/potongan biaya.')
@section('seo_keywords', 'beasiswa sepak bola bogor, beasiswa ssb bogor, pendaftaran beasiswa ytss, akademi sepak bola murah bogor, beasiswa bola anak')

@section('content')
    <main class="min-h-screen bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.18),transparent_20%),radial-gradient(circle_at_bottom_left,rgba(217,138,58,0.12),transparent_28%),linear-gradient(180deg,#090909_0%,#110d09_50%,#070707_100%)] text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
            style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
        </div>

        <div class="relative z-10 flex min-h-screen flex-col">
            <header
                class="relative flex items-center justify-between gap-4 overflow-hidden border-b border-white/10 bg-[linear-gradient(to_right,#f97316,#f97316,#f97316)] px-4 py-3 shadow-[0_10px_40px_rgba(0,0,0,0.25)] md:px-8 md:py-4 lg:px-10">
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-b from-white/10 via-transparent to-black/20"></div>
                    <div class="absolute -left-20 top-[-120px] h-[260px] w-[420px] rounded-full bg-orange-200/20 blur-3xl opacity-60"></div>
                    <div class="absolute right-[-120px] top-[-80px] h-[220px] w-[380px] rounded-full bg-orange-500/10 blur-3xl"></div>
                </div>

                <div class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between gap-3">
                    <a href="{{ url('/') }}" class="mx-auto md:hidden" aria-label="YTSS Academy">
                        <img src="/images/ytss_logo.png" alt="YTSS Soccer School" class="h-11 w-11 object-contain">
                    </a>

                    <a href="{{ url('/') }}" class="hidden items-center gap-3 md:flex">
                        <img src="/images/ytss_logo.png" alt="YTSS Soccer School" class="h-12 w-12 object-contain">
                        <div>
                            <p class="font-['Barlow_Condensed'] text-2xl font-black uppercase tracking-[0.04em] text-white">
                                YTSS Academy
                            </p>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.32em] text-[#ffd3a0]/80">
                                Scholarship Registration Portal
                            </p>
                        </div>
                    </a>

                    <div class="relative z-10 hidden items-center gap-3 md:flex">
                        <a href="{{ url('/') }}"
                            class="rounded-full border border-white/15 bg-white/[0.05] px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/85 transition hover:border-white/30 hover:bg-white/[0.14] hover:text-white">
                            Kembali
                        </a>
                        <a href="{{ route('login') }}"
                            class="rounded-full border border-white/15 bg-[#4a2200] px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-[#5a2a03]">
                            Login
                        </a>
                    </div>
                </div>
            </header>

            <!-- Ambient Background Glows -->
            <div class="absolute top-10 left-10 w-[450px] h-[450px] bg-orange-500/10 blur-[120px] rounded-full pointer-events-none z-0"></div>
            <div class="absolute bottom-10 right-10 w-[450px] h-[450px] bg-orange-500/10 blur-[120px] rounded-full pointer-events-none z-0"></div>

            <div class="mx-auto flex w-full max-w-6xl flex-1 flex-col px-4 py-8 md:px-8 md:py-12 lg:px-10 relative z-10">
                <section class="flex flex-1 items-center justify-center">
                    <div class="w-full max-w-6xl rounded-[24px] border border-white/[0.08] bg-[linear-gradient(180deg,rgba(20,16,12,0.94)_0%,rgba(12,10,8,0.98)_100%)] p-6 shadow-[0_24px_80px_rgba(0,0,0,0.42)] backdrop-blur-xl md:rounded-[30px] md:p-10">
                        
                        <!-- Navigation Tabs -->
                        <div class="mb-8 flex justify-center w-full">
                            <div class="grid grid-cols-2 gap-1.5 p-1 rounded-2xl md:flex md:rounded-full border border-white/10 bg-black/40 backdrop-blur-sm w-full md:w-auto">
                                <a href="{{ route('login') }}"
                                    class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition text-white/60 hover:text-white whitespace-nowrap">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}"
                                    class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition text-white/60 hover:text-white whitespace-nowrap">
                                    Pendaftaran
                                </a>
                                <a href="{{ route('register.beasiswa') }}"
                                    class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition bg-orange-500 text-white shadow-[0_0_15px_rgba(249,115,22,0.3)] whitespace-nowrap">
                                    <span class="md:hidden">Beasiswa</span><span class="hidden md:inline">Ajukan Beasiswa</span>
                                </a>
                                <a href="{{ route('check-status') }}"
                                    class="text-center rounded-xl md:rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-[0.12em] transition text-white/60 hover:text-white whitespace-nowrap">
                                    <span class="md:hidden">Status</span><span class="hidden md:inline">Cek Status</span>
                                </a>
                            </div>
                        </div>

                        <!-- Mini Hero & Stats Counters -->
                        <div class="mb-8 text-center relative z-10">
                            <p class="text-[10px] font-bold uppercase tracking-[0.32em] text-[#d98a3a]/75">Form Pengajuan Beasiswa</p>
                            <h1 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase text-white md:text-5xl tracking-wide">
                                PENDAFTARAN BEASISWA YTSS
                            </h1>
                            <p class="mt-2 text-xs leading-5 text-white/50 max-w-md mx-auto">
                                Pengisian data pengajuan beasiswa dilakukan oleh orang tua/wali calon siswa.
                            </p>
                            
                            <!-- Stats counters -->
                            <div class="grid grid-cols-3 gap-3 max-w-lg mx-auto mt-6">
                                <div class="p-2.5 rounded-xl border border-white/5 bg-white/[0.02] backdrop-blur-sm text-center">
                                    <span class="font-['Barlow_Condensed'] text-xl font-black text-orange-500">{{ $stats['siswa'] > 0 ? $stats['siswa'] : '500+' }}</span>
                                    <p class="text-[8px] font-bold uppercase tracking-wider text-white/40 mt-0.5">Siswa Aktif</p>
                                </div>
                                <div class="p-2.5 rounded-xl border border-white/5 bg-white/[0.02] backdrop-blur-sm text-center">
                                    <span class="font-['Barlow_Condensed'] text-xl font-black text-orange-500">{{ $stats['prestasi'] > 0 ? $stats['prestasi'] : '50+' }}</span>
                                    <p class="text-[8px] font-bold uppercase tracking-wider text-white/40 mt-0.5">Prestasi</p>
                                </div>
                                <div class="p-2.5 rounded-xl border border-white/5 bg-white/[0.02] backdrop-blur-sm text-center">
                                    <span class="font-['Barlow_Condensed'] text-xl font-black text-orange-500">{{ $stats['kelompok'] > 0 ? $stats['kelompok'] : '10+' }}</span>
                                    <p class="text-[8px] font-bold uppercase tracking-wider text-white/40 mt-0.5">Kelompok Usia</p>
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="mb-8 rounded-[18px] border border-red-500/20 bg-red-500/10 p-5 text-sm text-red-400">
                                <p class="font-bold mb-2">Mohon perbaiki kesalahan berikut:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.beasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8"
                            x-data="{
                                activeStep: 1,
                                selectedBeasiswa: '{{ old('id_jenis_beasiswa') }}',
                                showPasswordParent: false,
                                showConfirmPasswordParent: false,
                                showPasswordStudent: false,
                                showConfirmPasswordStudent: false,
                                passwordParent: '',
                                passwordStudent: '',
                                getPasswordStrength(pass) {
                                    if (!pass) return '';
                                    if (pass.length < 8) return 'lemah';
                                    const hasUpper = /[A-Z]/.test(pass);
                                    const hasLower = /[a-z]/.test(pass);
                                    const hasNumber = /[0-9]/.test(pass);
                                    if (hasUpper && hasLower && hasNumber) return 'kuat';
                                    return 'sedang';
                                },
                                sertifikat_1PreviewUrl: '', sertifikat_1FileName: '', sertifikat_1FileSize: '', sertifikat_1FileType: '', sertifikat_1HasFile: false,
                                sertifikat_2PreviewUrl: '', sertifikat_2FileName: '', sertifikat_2FileSize: '', sertifikat_2FileType: '', sertifikat_2HasFile: false,
                                sertifikat_3PreviewUrl: '', sertifikat_3FileName: '', sertifikat_3FileSize: '', sertifikat_3FileType: '', sertifikat_3HasFile: false,
                                videoPreviewUrl: '', videoFileName: '', videoHasFile: false,
                                handleFileChange(event, field) {
                                    const file = event.target.files[0];
                                    if (!file) {
                                        this[field + 'PreviewUrl'] = '';
                                        this[field + 'FileName'] = '';
                                        this[field + 'FileSize'] = '';
                                        this[field + 'FileType'] = '';
                                        this[field + 'HasFile'] = false;
                                        return;
                                    }
                                    this[field + 'FileName'] = file.name;
                                    this[field + 'HasFile'] = true;
                                    
                                    if (field !== 'video') {
                                        const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                                        this[field + 'FileSize'] = sizeInMB + ' MB';
                                        if (file.type.startsWith('image/')) {
                                            this[field + 'FileType'] = 'image';
                                            this[field + 'PreviewUrl'] = URL.createObjectURL(file);
                                        } else if (file.type === 'application/pdf') {
                                            this[field + 'FileType'] = 'pdf';
                                            this[field + 'PreviewUrl'] = '';
                                        } else {
                                            this[field + 'FileType'] = 'other';
                                            this[field + 'PreviewUrl'] = '';
                                        }
                                    } else {
                                        this[field + 'PreviewUrl'] = URL.createObjectURL(file);
                                    }
                                }
                            }">
                            @csrf

                            <!-- Sticky Progress Step Indicator -->
                            <div class="sticky top-4 z-20 mb-8 max-w-xl mx-auto">
                                <div class="rounded-2xl border border-white/10 bg-black/85 p-3.5 backdrop-blur-md shadow-[0_10px_30px_rgba(0,0,0,0.5)]">
                                    <div class="flex items-center justify-between relative">
                                        <!-- progress line background -->
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 bg-white/10 z-0"></div>
                                        <!-- active progress line -->
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-orange-500 transition-all duration-300 z-0" 
                                             :style="'width: ' + ((activeStep - 1) / 4 * 100) + '%'"></div>
                                        
                                        <!-- step items -->
                                        <template x-for="step in [1, 2, 3, 4, 5]">
                                            <button type="button" 
                                                @click="activeStep = step; 
                                                        const ids = ['section-kategori', 'section-siswa', 'section-ortu', 'section-akun', 'section-dokumen'];
                                                        document.getElementById(ids[step - 1]).scrollIntoView({ behavior: 'smooth', block: 'center' })"
                                                class="relative z-10 flex flex-col items-center gap-1 group focus:outline-none">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border-2 transition duration-300"
                                                     :class="{
                                                         'bg-orange-500 border-orange-500 text-black shadow-[0_0_15px_rgba(249,115,22,0.4)]': activeStep === step,
                                                         'bg-[#120d09] border-orange-500 text-orange-500': step < activeStep,
                                                         'bg-[#0a0a0a] border-white/10 text-white/40 group-hover:border-white/30 group-hover:text-white': step > activeStep
                                                     }">
                                                     <span x-show="step >= activeStep" x-text="step"></span>
                                                     <span x-show="step < activeStep" class="text-[10px] font-bold">✓</span>
                                                </div>
                                                <span class="text-[8px] font-bold uppercase tracking-wider hidden sm:block"
                                                      :class="activeStep === step ? 'text-orange-500' : (step < activeStep ? 'text-orange-400' : 'text-white/30')">
                                                    <span x-text="['Kategori', 'Data Siswa', 'Orang Tua', 'Akun', 'Dokumen'][step - 1]"></span>
                                                </span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 1: KATEGORI BEASISWA -->
                            <div id="section-kategori" @focusin="activeStep = 1"
                                 class="rounded-[24px] border border-white/[0.08] bg-white/[0.02] p-6 shadow-md transition duration-300 hover:border-white/[0.15] hover:bg-white/[0.04]">
                                <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-6">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white">1</span>
                                    <h2 class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-orange-500">Pilih Kategori Beasiswa <span class="text-red-500">*</span></h2>
                                </div>

                                <input type="hidden" name="id_jenis_beasiswa" :value="selectedBeasiswa">

                                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($jenisBeasiswa as $beasiswa)
                                        <div @click="selectedBeasiswa = '{{ $beasiswa->id }}'"
                                             :class="selectedBeasiswa == '{{ $beasiswa->id }}' ? 'border-orange-500 bg-orange-500/[0.08] shadow-[0_0_25px_rgba(249,115,22,0.25)] scale-[1.03]' : 'border-white/[0.08] bg-black/20 hover:border-white/20 hover:bg-black/35 hover:scale-[1.02]'"
                                             class="relative flex flex-col justify-between p-5 rounded-2xl border cursor-pointer transition-all duration-300">
                                            
                                            <div>
                                                <h3 class="font-['Barlow_Condensed'] text-lg font-black uppercase text-white tracking-wide">
                                                    {{ $beasiswa->nama_beasiswa }}
                                                </h3>
                                                <p class="mt-2 text-xs text-white/50 leading-relaxed">
                                                    {{ $beasiswa->keterangan ?: 'Tidak ada keterangan tambahan.' }}
                                                </p>
                                            </div>
                                            
                                            <div class="mt-4 pt-3 border-t border-white/5 flex items-center justify-between">
                                                <span class="text-[10px] font-bold uppercase tracking-widest text-[#ffcf97]">Potongan SPP</span>
                                                <span class="text-sm font-black text-orange-500">{{ $beasiswa->potongan_spp }}%</span>
                                            </div>

                                            <div x-show="selectedBeasiswa == '{{ $beasiswa->id }}'"
                                                 class="absolute -top-2.5 -right-2.5 flex items-center gap-1 rounded-full bg-orange-500 px-3 py-1 text-[9px] font-black uppercase tracking-wider text-white shadow-[0_4px_10px_rgba(249,115,22,0.4)] border border-orange-400">
                                                 <span>✓</span>
                                                 <span>Terpilih</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Benefit Section -->
                                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 p-4 rounded-2xl border border-white/[0.06] bg-black/30">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-orange-500/10 text-orange-400 text-xs font-bold border border-orange-500/20">✓</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-white/80">Pembinaan Profesional</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-orange-500/10 text-orange-400 text-xs font-bold border border-orange-500/20">✓</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-white/80">Kompetisi Resmi</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-orange-500/10 text-orange-400 text-xs font-bold border border-orange-500/20">✓</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-white/80">Pelatih Berpengalaman</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-orange-500/10 text-orange-400 text-xs font-bold border border-orange-500/20">✓</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-white/80">Sertifikat Pembinaan</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Side-by-Side 2-Column Grid on Desktop -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start mt-8">
                                
                                <!-- SECTION 2: DATA SISWA -->
                                <div id="section-siswa" @focusin="activeStep = 2"
                                     class="rounded-[24px] border border-white/[0.08] bg-white/[0.02] p-6 shadow-md transition duration-300 hover:border-white/[0.15] hover:bg-white/[0.04]">
                                    <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-6">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white">2</span>
                                        <h2 class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-orange-500">Data Calon Siswa</h2>
                                    </div>

                                    <div class="grid gap-4">
                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Nama Lengkap Siswa</label>
                                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama Lengkap Siswa"
                                                class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Tempat Lahir</label>
                                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota Lahir"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" required
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-[#121212] px-5 py-4 text-sm text-white outline-none transition focus:border-[#f97316]/40">
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">No. WhatsApp Siswa</label>
                                                <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" required placeholder="08xxxxxxxxxx"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Asal Sekolah</label>
                                                <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" required placeholder="SD/SMP/SMA Asal"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Kelompok Kelas</label>
                                                <select name="id_kelompok_kelas" required
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-[#121212] px-5 py-4 text-sm text-white outline-none transition focus:border-[#f97316]/40">
                                                    <option value="">Pilih Kelompok Usia</option>
                                                    @foreach ($kelompokKelas as $kelompok)
                                                        <option value="{{ $kelompok->id }}" {{ old('id_kelompok_kelas') == $kelompok->id ? 'selected' : '' }}>
                                                            {{ $kelompok->nama_kelompok }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Alamat Lengkap</label>
                                            <textarea name="alamat" rows="3" required placeholder="Alamat rumah lengkap"
                                                class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">{{ old('alamat') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION 3: DATA ORANG TUA -->
                                <div id="section-ortu" @focusin="activeStep = 3"
                                     class="rounded-[24px] border border-white/[0.08] bg-white/[0.02] p-6 shadow-md transition duration-300 hover:border-white/[0.15] hover:bg-white/[0.04]">
                                    <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-6">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white">3</span>
                                        <h2 class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-orange-500">Data Orang Tua / Wali</h2>
                                    </div>

                                    <div class="grid gap-4">
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Nama Ayah</label>
                                                <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" required placeholder="Nama Ayah"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">No. HP / WA Ayah</label>
                                                <input type="text" name="nomor_hp_ayah" value="{{ old('nomor_hp_ayah') }}" required placeholder="08xxxxxxxxxx"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Pekerjaan Ayah</label>
                                            <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required placeholder="Pekerjaan Ayah"
                                                class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Nama Ibu</label>
                                                <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" required placeholder="Nama Ibu"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">No. HP / WA Ibu</label>
                                                <input type="text" name="nomor_hp_ibu" value="{{ old('nomor_hp_ibu') }}" required placeholder="08xxxxxxxxxx"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Pekerjaan Ibu</label>
                                            <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required placeholder="Pekerjaan Ibu"
                                                class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 4: CREDENTIALS (Akun Login) -->
                            <div id="section-akun" @focusin="activeStep = 4"
                                 class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                                
                                <!-- Parent Login Account -->
                                <div class="rounded-[24px] border border-white/[0.08] bg-white/[0.02] p-6 shadow-md transition duration-300 hover:border-white/[0.15] hover:bg-white/[0.04]">
                                    <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-6">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white">4</span>
                                        <h2 class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-orange-500">Akun Orang Tua</h2>
                                    </div>

                                    <div class="grid gap-4">
                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Email Orang Tua (Untuk Login)</label>
                                            <input type="email" name="email_ortu" value="{{ old('email_ortu') }}" required placeholder="nama.ortu@email.com"
                                                class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Password Orang Tua</label>
                                            <div class="relative">
                                                <input :type="showPasswordParent ? 'text' : 'password'" name="password_ortu" x-model="passwordParent" required placeholder="Minimal 8 karakter"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 pr-12 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                                <button type="button" @click="showPasswordParent = !showPasswordParent" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/45 hover:text-white transition focus:outline-none" aria-label="Toggle Password Visibility">
                                                    <span x-show="!showPasswordParent"><i data-lucide="eye" class="w-5 h-5"></i></span>
                                                    <span x-show="showPasswordParent" style="display:none;"><i data-lucide="eye-off" class="w-5 h-5"></i></span>
                                                </button>
                                            </div>
                                            <div class="mt-2 space-y-1" x-show="passwordParent.length > 0" style="display: none;">
                                                <div class="flex items-center justify-between text-[10px] uppercase font-bold tracking-wider">
                                                    <span class="text-white/40">Kekuatan Password:</span>
                                                    <span :class="{
                                                        'text-red-500': getPasswordStrength(passwordParent) === 'lemah',
                                                        'text-amber-500': getPasswordStrength(passwordParent) === 'sedang',
                                                        'text-emerald-500': getPasswordStrength(passwordParent) === 'kuat'
                                                    }" x-text="getPasswordStrength(passwordParent) === 'lemah' ? 'Lemah' : (getPasswordStrength(passwordParent) === 'sedang' ? 'Sedang' : 'Kuat')"></span>
                                                </div>
                                                <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                                                    <div class="h-full transition-all duration-300 rounded-full" :class="{
                                                        'bg-red-500 w-1/3': getPasswordStrength(passwordParent) === 'lemah',
                                                        'bg-amber-500 w-2/3': getPasswordStrength(passwordParent) === 'sedang',
                                                        'bg-emerald-500 w-full': getPasswordStrength(passwordParent) === 'kuat'
                                                    }"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Konfirmasi Password</label>
                                            <div class="relative">
                                                <input :type="showConfirmPasswordParent ? 'text' : 'password'" name="password_ortu_confirmation" required placeholder="Ulangi Password"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 pr-12 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                                <button type="button" @click="showConfirmPasswordParent = !showConfirmPasswordParent" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/45 hover:text-white transition focus:outline-none" aria-label="Toggle Password Visibility">
                                                    <span x-show="!showConfirmPasswordParent"><i data-lucide="eye" class="w-5 h-5"></i></span>
                                                    <span x-show="showConfirmPasswordParent" style="display:none;"><i data-lucide="eye-off" class="w-5 h-5"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Login Account -->
                                <div class="rounded-[24px] border border-white/[0.08] bg-white/[0.02] p-6 shadow-md transition duration-300 hover:border-white/[0.15] hover:bg-white/[0.04]">
                                    <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-6">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white">4</span>
                                        <h2 class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-orange-500">Akun Siswa</h2>
                                    </div>

                                    <div class="grid gap-4">
                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Email Siswa (Untuk Login Mandiri)</label>
                                            <input type="email" name="email_siswa" value="{{ old('email_siswa') }}" required placeholder="nama.siswa@email.com"
                                                class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Password Siswa</label>
                                            <div class="relative">
                                                <input :type="showPasswordStudent ? 'text' : 'password'" name="password_siswa" x-model="passwordStudent" required placeholder="Minimal 8 karakter"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 pr-12 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                                <button type="button" @click="showPasswordStudent = !showPasswordStudent" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/45 hover:text-white transition focus:outline-none" aria-label="Toggle Password Visibility">
                                                    <span x-show="!showPasswordStudent"><i data-lucide="eye" class="w-5 h-5"></i></span>
                                                    <span x-show="showPasswordStudent" style="display:none;"><i data-lucide="eye-off" class="w-5 h-5"></i></span>
                                                </button>
                                            </div>
                                            <div class="mt-2 space-y-1" x-show="passwordStudent.length > 0" style="display: none;">
                                                <div class="flex items-center justify-between text-[10px] uppercase font-bold tracking-wider">
                                                    <span class="text-white/40">Kekuatan Password:</span>
                                                    <span :class="{
                                                        'text-red-500': getPasswordStrength(passwordStudent) === 'lemah',
                                                        'text-amber-500': getPasswordStrength(passwordStudent) === 'sedang',
                                                        'text-emerald-500': getPasswordStrength(passwordStudent) === 'kuat'
                                                    }" x-text="getPasswordStrength(passwordStudent) === 'lemah' ? 'Lemah' : (getPasswordStrength(passwordStudent) === 'sedang' ? 'Sedang' : 'Kuat')"></span>
                                                </div>
                                                <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                                                    <div class="h-full transition-all duration-300 rounded-full" :class="{
                                                        'bg-red-500 w-1/3': getPasswordStrength(passwordStudent) === 'lemah',
                                                        'bg-amber-500 w-2/3': getPasswordStrength(passwordStudent) === 'sedang',
                                                        'bg-emerald-500 w-full': getPasswordStrength(passwordStudent) === 'kuat'
                                                    }"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Konfirmasi Password Siswa</label>
                                            <div class="relative">
                                                <input :type="showConfirmPasswordStudent ? 'text' : 'password'" name="password_siswa_confirmation" required placeholder="Ulangi Password"
                                                    class="w-full rounded-[18px] border border-white/[0.08] bg-white/[0.04] px-5 pr-12 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#f97316]/40 focus:bg-white/[0.06]">
                                                <button type="button" @click="showConfirmPasswordStudent = !showConfirmPasswordStudent" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/45 hover:text-white transition focus:outline-none" aria-label="Toggle Password Visibility">
                                                    <span x-show="!showConfirmPasswordStudent"><i data-lucide="eye" class="w-5 h-5"></i></span>
                                                    <span x-show="showConfirmPasswordStudent" style="display:none;"><i data-lucide="eye-off" class="w-5 h-5"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 5: DOKUMEN PRESTASI (OPSIONAL) -->
                            <div id="section-dokumen" @focusin="activeStep = 5"
                                 class="rounded-[24px] border border-white/[0.08] bg-white/[0.02] p-6 shadow-md transition duration-300 hover:border-white/[0.15] hover:bg-white/[0.04] mt-8">
                                <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-6">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white">5</span>
                                    <h2 class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-orange-500">Dokumen Pendukung Prestasi <span class="ml-1.5 rounded bg-orange-500/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-orange-400 border border-orange-500/20">Opsional</span></h2>
                                </div>

                                <div class="mb-6 rounded-[18px] border border-orange-500/20 bg-orange-500/[0.04] p-4 text-xs leading-relaxed text-white/70 flex items-start gap-3">
                                    <i data-lucide="info" class="w-5 h-5 text-orange-400 flex-shrink-0 mt-0.5"></i>
                                    <span>Dokumen prestasi dapat diunggah sekarang atau dilengkapi setelah calon siswa diterima menjadi siswa YTSS.</span>
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <!-- Sertifikat 1 -->
                                    <div class="rounded-2xl border border-white/5 bg-black/20 p-4">
                                        <label for="sertifikat_1" class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Sertifikat 1 (Opsional)</label>
                                        <input type="file" name="sertifikat_1" id="sertifikat_1" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                               @change="handleFileChange($event, 'sertifikat_1')"
                                               class="w-full text-xs text-white/50 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition">
                                        
                                        <div x-show="sertifikat_1HasFile" class="mt-3 p-3 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                            <div x-show="sertifikat_1FileType === 'image'" class="flex-shrink-0">
                                                <img :src="sertifikat_1PreviewUrl" class="w-12 h-12 rounded-lg object-cover border border-white/10">
                                            </div>
                                            <div x-show="sertifikat_1FileType === 'pdf'" class="w-12 h-12 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-xs font-bold font-['Barlow_Condensed']">
                                                PDF
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-white truncate" x-text="sertifikat_1FileName"></p>
                                                <p class="text-[10px] text-white/40" x-text="sertifikat_1FileSize"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sertifikat 2 -->
                                    <div class="rounded-2xl border border-white/5 bg-black/20 p-4">
                                        <label for="sertifikat_2" class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Sertifikat 2 (Opsional)</label>
                                        <input type="file" name="sertifikat_2" id="sertifikat_2" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                               @change="handleFileChange($event, 'sertifikat_2')"
                                               class="w-full text-xs text-white/50 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition">
                                        
                                        <div x-show="sertifikat_2HasFile" class="mt-3 p-3 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                            <div x-show="sertifikat_2FileType === 'image'" class="flex-shrink-0">
                                                <img :src="sertifikat_2PreviewUrl" class="w-12 h-12 rounded-lg object-cover border border-white/10">
                                            </div>
                                            <div x-show="sertifikat_2FileType === 'pdf'" class="w-12 h-12 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-xs font-bold font-['Barlow_Condensed']">
                                                PDF
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-white truncate" x-text="sertifikat_2FileName"></p>
                                                <p class="text-[10px] text-white/40" x-text="sertifikat_2FileSize"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sertifikat 3 -->
                                    <div class="rounded-2xl border border-white/5 bg-black/20 p-4">
                                        <label for="sertifikat_3" class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Sertifikat 3 (Opsional)</label>
                                        <input type="file" name="sertifikat_3" id="sertifikat_3" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                               @change="handleFileChange($event, 'sertifikat_3')"
                                               class="w-full text-xs text-white/50 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition">
                                        
                                        <div x-show="sertifikat_3HasFile" class="mt-3 p-3 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                            <div x-show="sertifikat_3FileType === 'image'" class="flex-shrink-0">
                                                <img :src="sertifikat_3PreviewUrl" class="w-12 h-12 rounded-lg object-cover border border-white/10">
                                            </div>
                                            <div x-show="sertifikat_3FileType === 'pdf'" class="w-12 h-12 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-xs font-bold font-['Barlow_Condensed']">
                                                PDF
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-white truncate" x-text="sertifikat_3FileName"></p>
                                                <p class="text-[10px] text-white/40" x-text="sertifikat_3FileSize"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Video Prestasi -->
                                    <div class="rounded-2xl border border-white/5 bg-black/20 p-4">
                                        <label for="video" class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Video Prestasi (Opsional)</label>
                                        <input type="file" name="video" id="video" accept=".mp4,.mov,.avi,.webm,.mkv"
                                               @change="handleFileChange($event, 'video')"
                                               class="w-full text-xs text-white/50 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition">
                                        
                                        <div x-show="videoHasFile" class="mt-3 p-3 rounded-xl bg-white/[0.02] border border-white/5 space-y-2" style="display: none;">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="video" class="w-4 h-4"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-white truncate" x-text="videoFileName"></p>
                                                </div>
                                            </div>
                                            <div class="rounded-xl overflow-hidden border border-white/10 bg-black max-w-xs mx-auto">
                                                <video :src="videoPreviewUrl" controls class="w-full h-auto max-h-36"></video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SUBMIT -->
                            <div class="space-y-5 pt-4">
                                <label class="flex items-start gap-3 rounded-[18px] border border-white/[0.06] bg-white/[0.03] px-4 py-4 text-sm leading-7 text-white/60 cursor-pointer">
                                    <input type="checkbox" required class="mt-1 h-4 w-4 rounded border-white/20 bg-transparent text-orange-500 focus:ring-0">
                                    <span>Saya menyatakan bahwa seluruh data yang diisi adalah benar dan menyetujui syarat pendaftaran Beasiswa YTSS Soccer School.</span>
                                </label>

                                <button type="submit" :disabled="!selectedBeasiswa"
                                    class="w-full rounded-[20px] bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-4 font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-[0.16em] text-white shadow-[0_16px_30px_rgba(249,115,22,0.28)] transition duration-300 hover:brightness-105 hover:scale-[1.01] disabled:opacity-50 disabled:cursor-not-allowed">
                                    Kirim Pendaftaran Beasiswa
                                </button>
                            </div>
                        </form>

                        <div class="mt-8 flex flex-col items-center gap-3 border-t border-white/10 pt-6 text-center">
                            <p class="text-sm text-white/65">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="font-bold text-orange-500 hover:text-orange-400 hover:underline transition">
                                    Masuk di sini
                                </a>
                            </p>

                            <a href="{{ url('/') }}"
                                class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/40 transition hover:text-orange-400">
                                &larr; Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
