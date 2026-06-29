@php
    $filePreviewBlock = function ($field, $label) {
        return '
        <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
            <span class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">' .
            $label .
            '</span>
            <div class="mt-2" x-show="selectedRecord && selectedRecord[\'' .
            $field .
            '\']">
                <div class="text-xs text-white/30 mb-2 break-all" x-text="getFileName(selectedRecord[\'' .
            $field .
            '\'])"></div>
                
                <!-- File Existence Warning -->
                <div class="mt-1 mb-2 text-xs text-red-400 font-semibold flex items-center gap-1.5" x-show="fileExistence[selectedRecord[\'' .
            $field .
            '\']] === false">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>File tidak ditemukan di server</span>
                </div>

                <!-- Preview -->
                <div class="mt-1" x-show="fileExistence[selectedRecord[\'' .
            $field .
            '\']] !== false">
                    <template x-if="fileKindFromPath(selectedRecord[\'' .
            $field .
            '\']) === \'image\'">
                        <img :src="resolvedUrls[selectedRecord[\'' .
            $field .
            '\']] || \'/\' + selectedRecord[\'' .
            $field .
            '\']" class="max-h-40 rounded-xl border border-white/10 object-contain shadow-lg">
                    </template>
                    <template x-if="fileKindFromPath(selectedRecord[\'' .
            $field .
            '\']) === \'video\'">
                        <video :src="resolvedUrls[selectedRecord[\'' .
            $field .
            '\']] || \'/\' + selectedRecord[\'' .
            $field .
            '\']" controls class="max-h-40 rounded-xl border border-white/10 bg-black w-full"></video>
                    </template>
                    <template x-if="fileKindFromPath(selectedRecord[\'' .
            $field .
            '\']) === \'pdf\'">
                        <iframe :src="resolvedUrls[selectedRecord[\'' .
            $field .
            '\']] || \'/\' + selectedRecord[\'' .
            $field .
            '\']" class="w-full h-80 rounded-xl border border-white/10 shadow-lg bg-white"></iframe>
                    </template>
                </div>
                <!-- Buttons -->
                <div class="mt-3 flex flex-wrap gap-2">
                    <a :href="resolvedUrls[selectedRecord[\'' .
            $field .
            '\']] || \'/\' + selectedRecord[\'' .
            $field .
            '\']" target="_blank"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/[0.04] px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-[#ffcf97] transition hover:border-orange-300/30 hover:text-white">
                        <i class="fa-solid fa-eye text-xs"></i> Lihat File
                    </a>
                    <a :href="resolvedUrls[selectedRecord[\'' .
            $field .
            '\']] || \'/\' + selectedRecord[\'' .
            $field .
            '\']" download
                        class="inline-flex items-center gap-1.5 rounded-xl border border-orange-500/20 bg-orange-500/10 px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-orange-400 transition hover:border-orange-300/30 hover:text-white">
                        <i class="fa-solid fa-download text-xs"></i> Download
                    </a>
                </div>
            </div>
            <div class="mt-2 text-xs text-white/35 italic" x-show="selectedRecord && !selectedRecord[\'' .
            $field .
            '\']">Tidak ada file.</div>
        </div>
        ';
    };
@endphp

<div x-show="showDetailModal" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-0 md:p-4"
    @keydown.escape.window="showDetailModal = false">

    <!-- Backdrop Click -->
    <div class="absolute inset-0" @click="showDetailModal = false"></div>

    <!-- Modal Shell -->
    <div class="relative z-10 w-full md:max-w-4xl h-full md:h-auto max-h-screen max-h-[100dvh] md:max-h-[90vh] flex flex-col overflow-hidden border border-white/10 bg-[#0c0c0c] shadow-[0_24px_80px_rgba(0,0,0,0.6)] backdrop-blur-xl md:rounded-[28px] transition-all"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-12 md:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 md:scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 md:scale-100"
        x-transition:leave-end="opacity-0 translate-y-12 md:scale-95">

        <!-- Modal Header -->
        <div
            class="flex items-center justify-between border-b border-white/10 px-6 py-5 bg-[linear-gradient(135deg,rgba(249,115,22,0.1),transparent)]">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#ffcf97]">Detail Record</p>
                <h4 class="mt-1 font-['Barlow_Condensed'] text-2xl font-black uppercase text-white">
                    #<span x-text="selectedRecord ? selectedRecord.id : ''"></span> - {{ $title }}
                </h4>
            </div>
            <button type="button" @click="showDetailModal = false"
                class="rounded-full border border-white/10 bg-white/[0.04] px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-white/70 transition hover:border-orange-500/30 hover:text-white hover:bg-orange-500/10">
                Tutup
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6">

            <template x-if="selectedRecord">
                <div class="space-y-6">

                    <!-- DAFTAR REGULER MODULE SPECIFIC LAYOUT -->
                    @if ($entity === 'daftar-reguler')
                        <!-- SECTION 1: DATA CALON SISWA -->
                        <div class="space-y-4">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                DATA CALON SISWA</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Kode
                                        Pendaftaran</span>
                                    <span class="block mt-1 text-sm text-orange-500 font-bold"
                                        x-text="selectedRecord.kode_pendaftaran || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Calon Siswa</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nama_lengkap || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Tempat
                                        Lahir</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.tempat_lahir || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Tanggal
                                        Lahir</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="formatValue('tanggal_lahir', selectedRecord.tanggal_lahir)"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Jenis
                                        Kelamin</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.jenis_kelamin === 'L' ? 'Laki-laki' : (selectedRecord.jenis_kelamin === 'P' ? 'Perempuan' : '-')"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">No.
                                        WhatsApp Calon Siswa</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nomor_hp || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Asal
                                        Sekolah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.asal_sekolah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Kelompok
                                        Kelas</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.kelompok_kelas_label || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4 sm:col-span-2">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Alamat
                                        Rumah Lengkap</span>
                                    <span class="block mt-1 text-sm text-white/80 whitespace-pre-wrap"
                                        x-text="selectedRecord.alamat || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: DATA ORANG TUA / WALI -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                DATA ORANG TUA / WALI</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nama_ayah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">No.
                                        WhatsApp Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nomor_hp_ayah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Pekerjaan
                                        Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.pekerjaan_ayah || '-'"></span>
                                </div>
                                <div class="hidden sm:block"></div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nama_ibu || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">No.
                                        WhatsApp Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nomor_hp_ibu || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Pekerjaan
                                        Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.pekerjaan_ibu || '-'"></span>
                                </div>
                                <div class="hidden sm:block"></div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Email Orang Tua</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.email_ortu || selectedRecord.email || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Email Siswa</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.email_siswa || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: UNGGAH DOKUMEN -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                UNGGAH DOKUMEN</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                {!! $filePreviewBlock('upload_akte', 'Akte Kelahiran Calon Siswa') !!}
                                {!! $filePreviewBlock('upload_kk', 'Kartu Keluarga') !!}
                            </div>
                        </div>

                        <!-- SECTION 4: STATUS PENDAFTARAN -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                STATUS PENDAFTARAN</h4>
                            <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                <span
                                    class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Status</span>
                                <div class="mt-2">
                                    <span :class="statusBadgeClass(selectedRecord.status_pendaftaran)"
                                        class="inline-block rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider"
                                        x-text="formatValue('status_pendaftaran', selectedRecord.status_pendaftaran)">
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- DAFTAR BEASISWA MODULE SPECIFIC LAYOUT -->
                    @if ($entity === 'daftar-beasiswa')
                        <!-- SECTION 1: DATA CALON SISWA -->
                        <div class="space-y-4">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                DATA CALON SISWA</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Kode
                                        Pendaftaran</span>
                                    <span class="block mt-1 text-sm text-orange-500 font-bold"
                                        x-text="selectedRecord.kode_pendaftaran || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Calon Siswa</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nama_lengkap || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Tempat
                                        Lahir</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.tempat_lahir || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Tanggal
                                        Lahir</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="formatValue('tanggal_lahir', selectedRecord.tanggal_lahir)"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Jenis
                                        Kelamin</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.jenis_kelamin === 'L' ? 'Laki-laki' : (selectedRecord.jenis_kelamin === 'P' ? 'Perempuan' : '-')"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">No.
                                        WhatsApp Calon Siswa</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nomor_hp || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Asal
                                        Sekolah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.asal_sekolah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Kelompok
                                        Kelas</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.kelompok_kelas_label || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4 sm:col-span-2">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Alamat
                                        Rumah Lengkap</span>
                                    <span class="block mt-1 text-sm text-white/80 whitespace-pre-wrap"
                                        x-text="selectedRecord.alamat || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: DATA ORANG TUA / WALI -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                DATA ORANG TUA / WALI</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nama_ayah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">No.
                                        WhatsApp Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nomor_hp_ayah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Pekerjaan
                                        Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.pekerjaan_ayah || '-'"></span>
                                </div>
                                <div class="hidden sm:block"></div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nama_ibu || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">No.
                                        WhatsApp Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nomor_hp_ibu || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Pekerjaan
                                        Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.pekerjaan_ibu || '-'"></span>
                                </div>
                                <div class="hidden sm:block"></div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Email Orang Tua</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.email_ortu || selectedRecord.email || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Email Siswa</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.email_siswa || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: KATEGORI BEASISWA -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                KATEGORI BEASISWA</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4 sm:col-span-2">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Jenis
                                        Beasiswa</span>
                                    <span class="block mt-1 text-sm text-orange-500 font-bold"
                                        x-text="selectedRecord.jenis_beasiswa_label || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: UNGGAH DOKUMEN PRESTASI (OPSIONAL) -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                DOKUMEN PRESTASI (OPSIONAL)</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                {!! $filePreviewBlock('sertifikat_1', 'Sertifikat Prestasi 1') !!}
                                {!! $filePreviewBlock('sertifikat_2', 'Sertifikat Prestasi 2') !!}
                                {!! $filePreviewBlock('sertifikat_3', 'Sertifikat Prestasi 3') !!}
                                {!! $filePreviewBlock('video', 'Video Prestasi') !!}
                            </div>
                        </div>

                        <!-- SECTION 5: METADATA & STATUS -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                STATUS PENDAFTARAN & METADATA</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Status
                                        Pendaftaran</span>
                                    <div class="mt-2">
                                        <span :class="statusBadgeClass(selectedRecord.status_pendaftaran)"
                                            class="inline-block rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider"
                                            x-text="formatValue('status_pendaftaran', selectedRecord.status_pendaftaran)">
                                        </span>
                                    </div>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Tanggal
                                        Pendaftaran</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.created_at ? formatDateTime(selectedRecord.created_at) : '-'"></span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- SISWA MODULE SPECIFIC LAYOUT -->
                    @if ($entity === 'siswa')
                        <!-- SECTION 1: DATA SISWA -->
                        <div class="space-y-4">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                DATA SISWA</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Lengkap</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nama_lengkap || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nomor
                                        HP</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.nomor_hp || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Status
                                        Aktif</span>
                                    <div class="mt-1">
                                        <span :class="statusBadgeClass(selectedRecord.status_aktif)"
                                            class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider"
                                            x-text="formatValue('status_aktif', selectedRecord.status_aktif)">
                                        </span>
                                    </div>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Tempat
                                        Lahir</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.tempat_lahir || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Tanggal
                                        Lahir</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="formatValue('tanggal_lahir', selectedRecord.tanggal_lahir)"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Jenis
                                        Kelamin</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.jenis_kelamin === 'L' ? 'Laki-laki' : (selectedRecord.jenis_kelamin === 'P' ? 'Perempuan' : '-')"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Asal
                                        Sekolah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.asal_sekolah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4 sm:col-span-2">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Alamat</span>
                                    <span class="block mt-1 text-sm text-white/80 whitespace-pre-wrap"
                                        x-text="selectedRecord.alamat || '-'"></span>
                                </div>
                            </div>

                            <!-- FILE PREVIEWS FOR SISWA -->
                            <div class="mt-4 grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                                {!! $filePreviewBlock('upload_foto', 'Foto Siswa') !!}
                                {!! $filePreviewBlock('upload_akte', 'Akte Kelahiran') !!}
                                {!! $filePreviewBlock('upload_kk', 'Kartu Keluarga') !!}
                                {!! $filePreviewBlock('upload_ijazah', 'Ijazah') !!}
                                {!! $filePreviewBlock('beasiswa_sertifikat_1', 'Beasiswa Sertifikat 1') !!}
                                {!! $filePreviewBlock('beasiswa_sertifikat_2', 'Beasiswa Sertifikat 2') !!}
                                {!! $filePreviewBlock('beasiswa_sertifikat_3', 'Beasiswa Sertifikat 3') !!}
                                {!! $filePreviewBlock('beasiswa_video', 'Beasiswa Video') !!}
                            </div>
                        </div>

                        <!-- SECTION 2: AKUN LOGIN -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                AKUN LOGIN</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Kode
                                        User (kd_users)</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.kd_users || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Email</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.user_email || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Lengkap Akun</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.user_name || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Role</span>
                                    <span class="block mt-1 text-sm text-white/80 capitalize"
                                        x-text="selectedRecord.user_role || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Status
                                        Aktif Akun</span>
                                    <div class="mt-1">
                                        <span
                                            :class="selectedRecord.user_status_aktif ?
                                                'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' :
                                                'bg-red-500/10 text-red-400 border border-red-500/20'"
                                            class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider"
                                            x-text="selectedRecord.user_status_aktif ? 'Aktif' : 'Nonaktif'">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: DATA ORANG TUA -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                DATA ORANG TUA</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.ortu_nama_ayah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Pekerjaan
                                        Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.ortu_pekerjaan_ayah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nomor
                                        HP Ayah</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.ortu_nomor_hp_ayah || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.ortu_nama_ibu || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Pekerjaan
                                        Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.ortu_pekerjaan_ibu || '-'"></span>
                                </div>
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nomor
                                        HP Ibu</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.ortu_nomor_hp_ibu || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: KELOMPOK KELAS -->
                        <div class="space-y-4 pt-4 border-t border-white/10">
                            <h4
                                class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97] border-b border-white/10 pb-2">
                                KELOMPOK KELAS</h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4 sm:col-span-2">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">Nama
                                        Kelompok & Rentang Tahun Kelahiran</span>
                                    <span class="block mt-1 text-sm text-white/80"
                                        x-text="selectedRecord.kelompok_kelas_label || '-'"></span>
                                </div>
                            </div>
                        </div>
                    @endif


                    <!-- GENERAL MODULES LAYOUT -->
                    @if ($entity !== 'siswa' && $entity !== 'daftar-reguler' && $entity !== 'daftar-beasiswa')
                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach ($displayColumns as $field => $label)
                                <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                    <span
                                        class="block text-[10px] font-semibold uppercase tracking-wider text-white/40">{{ $label }}</span>
                                    <div class="mt-1.5">
                                        <!-- Check for file / upload paths -->
                                        <template
                                            x-if="selectedRecord['{{ $field }}'] !== null && selectedRecord['{{ $field }}'] !== undefined && String(selectedRecord['{{ $field }}']).startsWith('uploads/')">
                                            <div>
                                                <div class="text-xs text-white/30 mb-2 break-all"
                                                    x-text="getFileName(selectedRecord['{{ $field }}'])"></div>

                                                <!-- File Existence Warning -->
                                                <div class="mt-1 mb-2 text-xs text-red-400 font-semibold flex items-center gap-1.5"
                                                    x-show="fileExistence[selectedRecord['{{ $field }}']] === false">
                                                    <svg class="h-4 w-4 text-red-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                        </path>
                                                    </svg>
                                                    <span>File tidak ditemukan di server</span>
                                                </div>

                                                <!-- Preview -->
                                                <div class="mt-1"
                                                    x-show="fileExistence[selectedRecord['{{ $field }}']] !== false">
                                                    <template
                                                        x-if="fileKindFromPath(selectedRecord['{{ $field }}']) === 'image'">
                                                        <img :src="resolvedUrls[selectedRecord['{{ $field }}']] || '/' +
                                                            selectedRecord['{{ $field }}']"
                                                            class="max-h-48 rounded-xl border border-white/10 object-contain shadow-lg">
                                                    </template>
                                                    <template
                                                        x-if="fileKindFromPath(selectedRecord['{{ $field }}']) === 'video'">
                                                        <video
                                                            :src="resolvedUrls[selectedRecord['{{ $field }}']] ||
                                                                '/' + selectedRecord['{{ $field }}']"
                                                            controls
                                                            class="max-h-48 rounded-xl border border-white/10 bg-black w-full"></video>
                                                    </template>
                                                    <template
                                                        x-if="fileKindFromPath(selectedRecord['{{ $field }}']) === 'pdf'">
                                                        <iframe
                                                            :src="resolvedUrls[selectedRecord['{{ $field }}']] ||
                                                                '/' + selectedRecord['{{ $field }}']"
                                                            class="w-full h-80 rounded-xl border border-white/10 shadow-lg bg-white"></iframe>
                                                    </template>
                                                </div>
                                                <div class="mt-3 flex flex-wrap gap-2">
                                                    <a :href="resolvedUrls[selectedRecord['{{ $field }}']] || '/' +
                                                        selectedRecord['{{ $field }}']"
                                                        target="_blank"
                                                        class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/[0.04] px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-[#ffcf97] transition hover:border-orange-300/30 hover:text-white">
                                                        <i class="fa-solid fa-eye text-xs"></i> Lihat File
                                                    </a>
                                                    <a :href="resolvedUrls[selectedRecord['{{ $field }}']] || '/' +
                                                        selectedRecord['{{ $field }}']"
                                                        download
                                                        class="inline-flex items-center gap-1.5 rounded-xl border border-orange-500/20 bg-orange-500/10 px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-orange-400 transition hover:border-orange-300/30 hover:text-white">
                                                        <i class="fa-solid fa-download text-xs"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Render normal values -->
                                        <template
                                            x-if="!(selectedRecord['{{ $field }}'] !== null && selectedRecord['{{ $field }}'] !== undefined && String(selectedRecord['{{ $field }}']).startsWith('uploads/'))">
                                            <div>
                                                @if (in_array($field, [
                                                        'status',
                                                        'status_aktif',
                                                        'status_pendaftaran',
                                                        'status_label',
                                                        'status_aktif_label',
                                                        'status_pendaftaran_label',
                                                    ]))
                                                    <span
                                                        :class="statusBadgeClass(selectedRecord['{{ $field }}'])"
                                                        class="inline-block rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider"
                                                        x-text="formatValue('{{ $field }}', selectedRecord['{{ $field }}'])">
                                                    </span>
                                                @else
                                                    <span class="text-sm text-white/80 whitespace-pre-wrap break-words"
                                                        x-text="formatValue('{{ $field }}', selectedRecord['{{ $field }}'])"></span>
                                                @endif
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                    <!-- TIMESTAMPS SECTION (ALL MODULES) -->
                    <div class="pt-4 border-t border-white/10">
                        <h5
                            class="font-['Barlow_Condensed'] text-lg font-bold uppercase tracking-wider text-white/40 mb-3">
                            Informasi Sistem</h5>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-xl border border-white/5 bg-black/20 p-3">
                                <span class="block text-[9px] font-bold uppercase tracking-wider text-white/30">Dibuat
                                    Pada</span>
                                <span class="block mt-1 text-xs text-white/60"
                                    x-text="selectedRecord.created_at ? formatDateTime(selectedRecord.created_at) : '-'"></span>
                            </div>
                            <div class="rounded-xl border border-white/5 bg-black/20 p-3">
                                <span
                                    class="block text-[9px] font-bold uppercase tracking-wider text-white/30">Terakhir
                                    Diubah</span>
                                <span class="block mt-1 text-xs text-white/60"
                                    x-text="selectedRecord.updated_at ? formatDateTime(selectedRecord.updated_at) : '-'"></span>
                            </div>
                            <template x-if="hasSoftDelete && selectedRecord.deleted_at">
                                <div class="rounded-xl border border-red-500/10 bg-red-500/5 p-3">
                                    <span
                                        class="block text-[9px] font-bold uppercase tracking-wider text-red-400/50">Dihapus
                                        Pada</span>
                                    <span class="block mt-1 text-xs text-red-300/60"
                                        x-text="formatDateTime(selectedRecord.deleted_at)"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </template>

        </div>

        <!-- Modal Footer -->
        <div class="border-t border-white/10 px-6 py-4 bg-black/40 flex flex-wrap gap-3 items-center justify-between">
            <div>
                @if ($entity === 'daftar-reguler')
                    <template x-if="selectedRecord && selectedRecord.status_pendaftaran === 'pending'">
                        <div class="flex gap-2.5">
                            <form method="POST"
                                :action="'{{ route('admin.forms.daftar-reguler.approve', ['id' => '__ID__']) }}'.replace(
                                    '__ID__', selectedRecord.id)"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="rounded-full bg-emerald-600 hover:bg-emerald-700 border border-emerald-500/30 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition">
                                    <i class="fa-solid fa-check mr-1.5"></i>
                                    Terima Pendaftaran
                                </button>
                            </form>

                            <form method="POST"
                                :action="'{{ route('admin.forms.daftar-reguler.reject', ['id' => '__ID__']) }}'.replace(
                                    '__ID__', selectedRecord.id)"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="rounded-full bg-red-600 hover:bg-red-700 border border-red-500/30 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition">
                                    <i class="fa-solid fa-xmark mr-1.5"></i>
                                    Tolak Pendaftaran
                                </button>
                            </form>
                        </div>
                    </template>
                @endif

                @if ($entity === 'daftar-beasiswa')
                    <template x-if="selectedRecord && selectedRecord.status_pendaftaran === 'pending'">
                        <div class="flex gap-2.5">
                            <form method="POST"
                                :action="'{{ route('admin.forms.daftar-beasiswa.approve', ['id' => '__ID__']) }}'.replace(
                                    '__ID__', selectedRecord.id)"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="rounded-full bg-emerald-600 hover:bg-emerald-700 border border-emerald-500/30 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition">
                                    <i class="fa-solid fa-check mr-1.5"></i>
                                    Terima Pendaftaran
                                </button>
                            </form>

                            <form method="POST"
                                :action="'{{ route('admin.forms.daftar-beasiswa.reject', ['id' => '__ID__']) }}'.replace(
                                    '__ID__', selectedRecord.id)"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="rounded-full bg-red-600 hover:bg-red-700 border border-red-500/30 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition">
                                    <i class="fa-solid fa-xmark mr-1.5"></i>
                                    Tolak Pendaftaran
                                </button>
                            </form>
                        </div>
                    </template>
                @endif
            </div>
            <button type="button" @click="showDetailModal = false"
                class="rounded-full bg-white/[0.06] border border-white/10 px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-white hover:bg-white/10 transition">
                Tutup Detail
            </button>
        </div>

    </div>
</div>
