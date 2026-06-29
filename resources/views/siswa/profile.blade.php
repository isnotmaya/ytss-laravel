@extends('layouts.siswa')

@section('content')
<div class="space-y-10" 
     x-data="{
         activeDoc: null,
         modalOpen: false,
         openPreview(label, path) {
             if (!path) return;
             const ext = path.split('.').pop().toLowerCase();
             this.activeDoc = {
                 label: label,
                 url: '/' + path,
                 ext: ext
             };
             this.modalOpen = true;
         }
     }">
    <!-- PAGE TITLE -->
    <div>
        <h1 class="heading-font text-4xl lg:text-5xl font-black uppercase tracking-wider text-white">
            PROFIL SAYA
        </h1>
        <p class="text-sm text-white/50 mt-1">
            Kelola informasi data pribadi, file berkas dokumen, dan pengaturan akun login Anda.
        </p>
    </div>

    <!-- NOTIFICATION ALERTS -->
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-emerald-400 text-sm flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-500/20 bg-red-500/10 p-4 text-red-400 text-sm flex flex-col gap-2">
            <div class="flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-bold">Terjadi Kesalahan:</span>
            </div>
            <ul class="list-disc list-inside pl-8 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- PROFILE COMPLETION CARD -->
    <div class="relative overflow-hidden bg-gradient-to-r from-orange-600/20 via-orange-500/5 to-transparent border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-orange-500/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 flex-1">
                <div class="flex items-center gap-3">
                    <h3 class="heading-font text-2xl font-black uppercase text-white tracking-wider">
                        Kelengkapan Profil
                    </h3>
                    @if($completionPercentage < 100)
                        <span class="px-2.5 py-0.5 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-[10px] font-bold uppercase tracking-wider">
                            Belum Lengkap
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase tracking-wider">
                            Lengkap
                        </span>
                    @endif
                </div>
                
                @if($completionPercentage < 100)
                    <p class="text-xs text-white/50">
                        Lengkapi dokumen Anda untuk kebutuhan administrasi YTSS.
                    </p>
                @else
                    <p class="text-xs text-white/50">
                        Terima kasih, seluruh dokumen wajib Anda telah berhasil diunggah.
                    </p>
                @endif
                
                <!-- Progress Bar -->
                <div class="space-y-2 pt-3">
                    <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-orange-500 rounded-full transition-all duration-500" style="width: {{ $completionPercentage }}%;"></div>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-orange-400 font-bold">{{ $completionPercentage }}% Lengkap</span>
                        <span class="text-white/40">{{ count(array_filter($completionFields)) }} dari {{ count($completionFields) }} dokumen wajib terunggah</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Badges Grid -->
        <div class="relative z-10 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 pt-4 border-t border-white/5">
            @php
                $badgeDocs = [
                    'upload_foto' => 'Foto Profil',
                    'upload_akte' => 'Akte Lahir',
                    'upload_kk' => 'Kartu Keluarga',
                    'upload_ijazah' => 'Ijazah',
                    'upload_nisn' => 'NISN',
                ];
            @endphp
            @foreach($badgeDocs as $field => $label)
                @php
                    $isUploaded = !empty($siswa->$field) && file_exists(public_path($siswa->$field));
                @endphp
                <div class="flex items-center gap-2 px-3 py-2.5 rounded-xl border {{ $isUploaded ? 'bg-emerald-500/5 border-emerald-500/20 text-emerald-400' : 'bg-red-500/5 border-red-500/20 text-red-400' }} text-xs">
                    <i data-lucide="{{ $isUploaded ? 'check-circle' : 'x-circle' }}" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="font-medium truncate">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT COLUMN: PROGRESS, DATA DIRI, LOGIN -->
        <div class="lg:col-span-2 space-y-8">

            <!-- DATA SISWA FORM -->
            <form method="POST" action="{{ route('siswa.profile.update') }}" enctype="multipart/form-data" 
                  x-data="{
                      upload_fotoPreviewUrl: '', upload_fotoFileName: '', upload_fotoFileSize: '', upload_fotoFileType: '', upload_fotoHasFile: false,
                      upload_aktePreviewUrl: '', upload_akteFileName: '', upload_akteFileSize: '', upload_akteFileType: '', upload_akteHasFile: false,
                      upload_kkPreviewUrl: '', upload_kkFileName: '', upload_kkFileSize: '', upload_kkFileType: '', upload_kkHasFile: false,
                      upload_ijazahPreviewUrl: '', upload_ijazahFileName: '', upload_ijazahFileSize: '', upload_ijazahFileType: '', upload_ijazahHasFile: false,
                      upload_nisnPreviewUrl: '', upload_nisnFileName: '', upload_nisnFileSize: '', upload_nisnFileType: '', upload_nisnHasFile: false,
                      beasiswa_sertifikat_1PreviewUrl: '', beasiswa_sertifikat_1FileName: '', beasiswa_sertifikat_1FileSize: '', beasiswa_sertifikat_1FileType: '', beasiswa_sertifikat_1HasFile: false,
                      beasiswa_sertifikat_2PreviewUrl: '', beasiswa_sertifikat_2FileName: '', beasiswa_sertifikat_2FileSize: '', beasiswa_sertifikat_2FileType: '', beasiswa_sertifikat_2HasFile: false,
                      beasiswa_sertifikat_3PreviewUrl: '', beasiswa_sertifikat_3FileName: '', beasiswa_sertifikat_3FileSize: '', beasiswa_sertifikat_3FileType: '', beasiswa_sertifikat_3HasFile: false,
                      beasiswa_videoPreviewUrl: '', beasiswa_videoFileName: '', beasiswa_videoFileSize: '', beasiswa_videoFileType: '', beasiswa_videoHasFile: false,
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
                      }
                  }" class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6">
                @csrf
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="user" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Data Siswa</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Readonly fields -->
                    <div>
                        <label class="text-xs uppercase font-bold text-white/50 tracking-wider">Nama Lengkap</label>
                        <input value="{{ $siswa->nama_lengkap }}" disabled 
                               class="w-full mt-2 rounded-xl bg-white/[0.02] border border-white/10 text-white/40 p-3.5 text-sm outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-xs uppercase font-bold text-white/50 tracking-wider">Jenis Kelamin</label>
                        <input value="{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled 
                               class="w-full mt-2 rounded-xl bg-white/[0.02] border border-white/10 text-white/40 p-3.5 text-sm outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-xs uppercase font-bold text-white/50 tracking-wider">Tempat Lahir</label>
                        <input value="{{ $siswa->tempat_lahir ?: '-' }}" disabled 
                               class="w-full mt-2 rounded-xl bg-white/[0.02] border border-white/10 text-white/40 p-3.5 text-sm outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-xs uppercase font-bold text-white/50 tracking-wider">Tanggal Lahir</label>
                        <input value="{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d M Y') : '-' }}" disabled 
                               class="w-full mt-2 rounded-xl bg-white/[0.02] border border-white/10 text-white/40 p-3.5 text-sm outline-none cursor-not-allowed">
                    </div>

                    <!-- Editable fields -->
                    <div class="md:col-span-2">
                        <label for="nomor_hp" class="text-xs uppercase font-bold text-white/60 tracking-wider">Nomor HP / WhatsApp <span class="text-orange-500">*</span></label>
                        <input type="text" name="nomor_hp" id="nomor_hp" value="{{ old('nomor_hp', $siswa->nomor_hp) }}" 
                               class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                    </div>

                    <div class="md:col-span-2">
                        <label for="asal_sekolah" class="text-xs uppercase font-bold text-white/60 tracking-wider">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}" 
                               class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                    </div>

                    <div class="md:col-span-2">
                        <label for="alamat" class="text-xs uppercase font-bold text-white/60 tracking-wider">Alamat Lengkap <span class="text-orange-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="4" 
                                  class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200 leading-relaxed">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>

                    <!-- UPLOAD INPUTS (Document Center upload support) -->
                    <div class="md:col-span-2 border-t border-white/5 pt-6 mt-4 space-y-4">
                        <h3 class="heading-font text-xl font-bold uppercase text-white tracking-wide">Unggah Berkas Baru</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Foto Profil -->
                            <div>
                                <label for="upload_foto" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Foto Profil (Max 5MB)</label>
                                <input type="file" name="upload_foto" id="upload_foto" accept=".jpg,.jpeg,.png,.webp,.gif"
                                       @change="handleFileChange($event, 'upload_foto')"
                                       class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                
                                <!-- Preview block -->
                                <div x-show="upload_fotoHasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                    <div x-show="upload_fotoFileType === 'image'" class="flex-shrink-0">
                                        <img :src="upload_fotoPreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                    </div>
                                    <div x-show="upload_fotoFileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                        PDF
                                    </div>
                                    <div x-show="upload_fotoFileType === 'other'" class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="file" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-medium text-white truncate" x-text="upload_fotoFileName"></p>
                                        <p class="text-[9px] text-white/40" x-text="upload_fotoFileSize"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Akte Kelahiran -->
                            <div>
                                <label for="upload_akte" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Akte Kelahiran (PDF, JPG, PNG, Max 5MB)</label>
                                <input type="file" name="upload_akte" id="upload_akte" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                       @change="handleFileChange($event, 'upload_akte')"
                                       class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                
                                <!-- Preview block -->
                                <div x-show="upload_akteHasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                    <div x-show="upload_akteFileType === 'image'" class="flex-shrink-0">
                                        <img :src="upload_aktePreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                    </div>
                                    <div x-show="upload_akteFileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                        PDF
                                    </div>
                                    <div x-show="upload_akteFileType === 'other'" class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="file" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-medium text-white truncate" x-text="upload_akteFileName"></p>
                                        <p class="text-[9px] text-white/40" x-text="upload_akteFileSize"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Kartu Keluarga -->
                            <div>
                                <label for="upload_kk" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Kartu Keluarga (PDF, JPG, PNG, Max 5MB)</label>
                                <input type="file" name="upload_kk" id="upload_kk" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                       @change="handleFileChange($event, 'upload_kk')"
                                       class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                
                                <!-- Preview block -->
                                <div x-show="upload_kkHasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                    <div x-show="upload_kkFileType === 'image'" class="flex-shrink-0">
                                        <img :src="upload_kkPreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                    </div>
                                    <div x-show="upload_kkFileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                        PDF
                                    </div>
                                    <div x-show="upload_kkFileType === 'other'" class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="file" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-medium text-white truncate" x-text="upload_kkFileName"></p>
                                        <p class="text-[9px] text-white/40" x-text="upload_kkFileSize"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Ijazah -->
                            <div>
                                <label for="upload_ijazah" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Ijazah (PDF, JPG, PNG, Max 5MB)</label>
                                <input type="file" name="upload_ijazah" id="upload_ijazah" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                       @change="handleFileChange($event, 'upload_ijazah')"
                                       class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                
                                <!-- Preview block -->
                                <div x-show="upload_ijazahHasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                    <div x-show="upload_ijazahFileType === 'image'" class="flex-shrink-0">
                                        <img :src="upload_ijazahPreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                    </div>
                                    <div x-show="upload_ijazahFileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                        PDF
                                    </div>
                                    <div x-show="upload_ijazahFileType === 'other'" class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="file" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-medium text-white truncate" x-text="upload_ijazahFileName"></p>
                                        <p class="text-[9px] text-white/40" x-text="upload_ijazahFileSize"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- NISN -->
                             <div class="md:col-span-2">
                                 <label for="upload_nisn" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Kartu NISN (PDF, JPG, PNG, Max 5MB)</label>
                                 <input type="file" name="upload_nisn" id="upload_nisn" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                        @change="handleFileChange($event, 'upload_nisn')"
                                        class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                 
                                 <!-- Preview block -->
                                 <div x-show="upload_nisnHasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                     <div x-show="upload_nisnFileType === 'image'" class="flex-shrink-0">
                                         <img :src="upload_nisnPreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                     </div>
                                     <div x-show="upload_nisnFileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                         PDF
                                     </div>
                                     <div x-show="upload_nisnFileType === 'other'" class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center flex-shrink-0">
                                         <i data-lucide="file" class="w-4 h-4"></i>
                                     </div>
                                     <div class="flex-1 min-w-0">
                                         <p class="text-[11px] font-medium text-white truncate" x-text="upload_nisnFileName"></p>
                                         <p class="text-[9px] text-white/40" x-text="upload_nisnFileSize"></p>
                                     </div>
                                 </div>
                             </div>

                             @if($isBeasiswa)
                             <!-- Scholarship Documents (Penerima Beasiswa) -->
                             <div class="md:col-span-2 border-t border-white/5 pt-6 mt-4 space-y-4">
                                 <h3 class="heading-font text-xl font-bold uppercase text-white tracking-wide">Dokumen Beasiswa (Khusus Penerima Beasiswa)</h3>
                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                     <!-- Sertifikat 1 -->
                                     <div>
                                         <label for="beasiswa_sertifikat_1" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Sertifikat Prestasi 1 (Max 5MB)</label>
                                         <input type="file" name="beasiswa_sertifikat_1" id="beasiswa_sertifikat_1" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                                @change="handleFileChange($event, 'beasiswa_sertifikat_1')"
                                                class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                         
                                         <!-- Preview block -->
                                         <div x-show="beasiswa_sertifikat_1HasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                             <div x-show="beasiswa_sertifikat_1FileType === 'image'" class="flex-shrink-0">
                                                 <img :src="beasiswa_sertifikat_1PreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                             </div>
                                             <div x-show="beasiswa_sertifikat_1FileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                                 PDF
                                             </div>
                                             <div class="flex-1 min-w-0">
                                                 <p class="text-[11px] font-medium text-white truncate" x-text="beasiswa_sertifikat_1FileName"></p>
                                                 <p class="text-[9px] text-white/40" x-text="beasiswa_sertifikat_1FileSize"></p>
                                             </div>
                                         </div>
                                     </div>

                                     <!-- Sertifikat 2 -->
                                     <div>
                                         <label for="beasiswa_sertifikat_2" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Sertifikat Prestasi 2 (Max 5MB)</label>
                                         <input type="file" name="beasiswa_sertifikat_2" id="beasiswa_sertifikat_2" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                                @change="handleFileChange($event, 'beasiswa_sertifikat_2')"
                                                class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                         
                                         <!-- Preview block -->
                                         <div x-show="beasiswa_sertifikat_2HasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                             <div x-show="beasiswa_sertifikat_2FileType === 'image'" class="flex-shrink-0">
                                                 <img :src="beasiswa_sertifikat_2PreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                             </div>
                                             <div x-show="beasiswa_sertifikat_2FileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                                 PDF
                                             </div>
                                             <div class="flex-1 min-w-0">
                                                 <p class="text-[11px] font-medium text-white truncate" x-text="beasiswa_sertifikat_2FileName"></p>
                                                 <p class="text-[9px] text-white/40" x-text="beasiswa_sertifikat_2FileSize"></p>
                                             </div>
                                         </div>
                                     </div>

                                     <!-- Sertifikat 3 -->
                                     <div>
                                         <label for="beasiswa_sertifikat_3" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Sertifikat Prestasi 3 (Max 5MB)</label>
                                         <input type="file" name="beasiswa_sertifikat_3" id="beasiswa_sertifikat_3" accept=".jpg,.jpeg,.png,.webp,.pdf"
                                                @change="handleFileChange($event, 'beasiswa_sertifikat_3')"
                                                class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                         
                                         <!-- Preview block -->
                                         <div x-show="beasiswa_sertifikat_3HasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                             <div x-show="beasiswa_sertifikat_3FileType === 'image'" class="flex-shrink-0">
                                                 <img :src="beasiswa_sertifikat_3PreviewUrl" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                             </div>
                                             <div x-show="beasiswa_sertifikat_3FileType === 'pdf'" class="w-10 h-10 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0 text-[10px] font-bold heading-font">
                                                 PDF
                                             </div>
                                             <div class="flex-1 min-w-0">
                                                 <p class="text-[11px] font-medium text-white truncate" x-text="beasiswa_sertifikat_3FileName"></p>
                                                 <p class="text-[9px] text-white/40" x-text="beasiswa_sertifikat_3FileSize"></p>
                                             </div>
                                         </div>
                                     </div>

                                     <!-- Video Prestasi -->
                                     <div>
                                         <label for="beasiswa_video" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">Video Prestasi (Max 20MB)</label>
                                         <input type="file" name="beasiswa_video" id="beasiswa_video" accept=".mp4,.mov,.avi,.webm,.mkv"
                                                @change="handleFileChange($event, 'beasiswa_video')"
                                                class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                         
                                         <!-- Preview block -->
                                         <div x-show="beasiswa_videoHasFile" class="mt-2.5 p-2.5 rounded-xl bg-white/[0.02] border border-white/5 flex items-center gap-3" style="display: none;">
                                             <div class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center flex-shrink-0">
                                                 <i data-lucide="video" class="w-4 h-4"></i>
                                             </div>
                                             <div class="flex-1 min-w-0">
                                                 <p class="text-[11px] font-medium text-white truncate" x-text="beasiswa_videoFileName"></p>
                                                 <p class="text-[9px] text-white/40" x-text="beasiswa_videoFileSize"></p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             @endif
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 rounded-xl font-bold uppercase tracking-wider text-black text-sm shadow-lg shadow-orange-500/15 hover:shadow-orange-500/25 transition duration-300">
                        Simpan Profil & Berkas
                    </button>
                </div>
            </form>

            <!-- LOGIN ACCOUNT UPDATE -->
            <form method="POST" action="{{ route('siswa.account.update') }}" class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6">
                @csrf
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="key" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Akun Login</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="email" class="text-xs uppercase font-bold text-white/60 tracking-wider">Email Akun <span class="text-orange-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                               class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="text-xs uppercase font-bold text-white/60 tracking-wider">Password Baru</label>
                            <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diubah"
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>

                        <div>
                            <label for="password_confirmation" class="text-xs uppercase font-bold text-white/60 tracking-wider">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Tulis ulang password baru"
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 rounded-xl font-bold uppercase tracking-wider text-black text-sm shadow-lg shadow-orange-500/15 hover:shadow-orange-500/25 transition duration-300">
                        Simpan Pengaturan Akun
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT COLUMN: DOCUMENTS LIST (Document Center) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 space-y-6">
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="folder" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Dokumen Saya</h2>
                </div>

                @php
                    $docs = [
                        ['label' => 'Foto Profil', 'field' => 'upload_foto', 'path' => $siswa->upload_foto],
                        ['label' => 'Akte Kelahiran', 'field' => 'upload_akte', 'path' => $siswa->upload_akte],
                        ['label' => 'Kartu Keluarga (KK)', 'field' => 'upload_kk', 'path' => $siswa->upload_kk],
                        ['label' => 'Ijazah Terakhir', 'field' => 'upload_ijazah', 'path' => $siswa->upload_ijazah],
                        ['label' => 'Kartu NISN', 'field' => 'upload_nisn', 'path' => $siswa->upload_nisn],
                    ];
                @endphp

                <div class="space-y-3">
                    @foreach($docs as $doc)
                        @php
                            $path = $doc['path'];
                            $diskExists = !empty($path) && file_exists(public_path($path));
                            if (empty($path)) {
                                $status = 'belum';
                            } elseif ($diskExists) {
                                $status = 'sudah';
                            } else {
                                $status = 'missing';
                            }
                        @endphp
                        <div @if($status === 'sudah') @click="openPreview('{{ $doc['label'] }}', '{{ $doc['path'] }}')" @endif
                             class="flex items-center justify-between p-4 rounded-2xl border transition duration-200 {{ $status === 'sudah' ? 'bg-white/[0.02] hover:bg-white/[0.06] border-white/5 hover:border-white/10 cursor-pointer' : 'bg-white/[0.01] border-white/5 opacity-60 ' . ($status === 'missing' ? 'cursor-pointer hover:bg-white/[0.04]' : 'cursor-not-allowed') }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 flex-shrink-0">
                                    <i data-lucide="{{ $doc['field'] === 'upload_foto' ? 'user' : 'file-text' }}" class="w-4 h-4"></i>
                                </div>
                                <div class="truncate">
                                    <h4 class="text-xs font-semibold text-white truncate">{{ $doc['label'] }}</h4>
                                    <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider mt-0.5">Dokumen</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2 flex items-center gap-2">
                                @if($status === 'sudah')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[9px] font-bold uppercase tracking-wider">
                                        🟢 Sudah Upload
                                    </span>
                                    <i data-lucide="eye" class="w-3.5 h-3.5 text-white/30"></i>
                                @elseif($status === 'missing')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-[9px] font-bold uppercase tracking-wider">
                                        🔴 File Tidak Ditemukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 text-[9px] font-bold uppercase tracking-wider">
                                        🟡 Belum Upload
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($isBeasiswa)
            <!-- DOKUMEN BEASISWA CARD -->
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 space-y-6">
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="award" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Dokumen Beasiswa</h2>
                </div>

                @php
                    $beasiswaDocs = [
                        ['label' => 'Sertifikat Prestasi 1', 'field' => 'beasiswa_sertifikat_1', 'path' => $siswa->beasiswa_sertifikat_1],
                        ['label' => 'Sertifikat Prestasi 2', 'field' => 'beasiswa_sertifikat_2', 'path' => $siswa->beasiswa_sertifikat_2],
                        ['label' => 'Sertifikat Prestasi 3', 'field' => 'beasiswa_sertifikat_3', 'path' => $siswa->beasiswa_sertifikat_3],
                        ['label' => 'Video Prestasi', 'field' => 'beasiswa_video', 'path' => $siswa->beasiswa_video],
                    ];
                @endphp

                <div class="space-y-3">
                    @foreach($beasiswaDocs as $bdoc)
                        @php
                            $bpath = $bdoc['path'];
                            $bdiskExists = !empty($bpath) && file_exists(public_path($bpath));
                            if (empty($bpath)) {
                                $bstatus = 'belum';
                            } elseif ($bdiskExists) {
                                $bstatus = 'sudah';
                            } else {
                                $bstatus = 'missing';
                            }
                        @endphp
                        <div @if($bstatus === 'sudah') @click="openPreview('{{ $bdoc['label'] }}', '{{ $bdoc['path'] }}')" @endif
                             class="flex items-center justify-between p-4 rounded-2xl border transition duration-200 {{ $bstatus === 'sudah' ? 'bg-white/[0.02] hover:bg-white/[0.06] border-white/5 hover:border-white/10 cursor-pointer' : 'bg-white/[0.01] border-white/5 opacity-60 ' . ($bstatus === 'missing' ? 'cursor-pointer hover:bg-white/[0.04]' : 'cursor-not-allowed') }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 flex-shrink-0">
                                    <i data-lucide="{{ $bdoc['field'] === 'beasiswa_video' ? 'video' : 'award' }}" class="w-4 h-4"></i>
                                </div>
                                <div class="truncate">
                                    <h4 class="text-xs font-semibold text-white truncate">{{ $bdoc['label'] }}</h4>
                                    <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider mt-0.5">Beasiswa</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2 flex items-center gap-2">
                                @if($bstatus === 'sudah')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[9px] font-bold uppercase tracking-wider">
                                        🟢 Sudah Upload
                                    </span>
                                    <i data-lucide="eye" class="w-3.5 h-3.5 text-white/30"></i>
                                @elseif($bstatus === 'missing')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-[9px] font-bold uppercase tracking-wider">
                                        🔴 File Tidak Ditemukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 text-[9px] font-bold uppercase tracking-wider">
                                        🟡 Belum Upload
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Document Preview Modal -->
    <div x-cloak x-show="modalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
         
        <!-- Modal Dialog -->
        <div @click.away="modalOpen = false"
             class="relative w-full max-w-4xl bg-[#0c0c0c] border border-white/10 rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-95"
             x-transition:enter-end="scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="scale-100"
             x-transition:leave-end="scale-95">
             
            <!-- Header -->
            <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
                <div>
                    <h3 class="heading-font text-2xl font-black uppercase tracking-wider text-white" x-text="activeDoc ? activeDoc.label : ''"></h3>
                    <p class="text-[10px] text-white/55 uppercase font-bold tracking-wider mt-0.5">Pratinjau Dokumen Resmi</p>
                </div>
                <button @click="modalOpen = false" class="p-2 rounded-xl text-white/50 hover:text-white hover:bg-white/5 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Body / Preview Area -->
            <div class="flex-1 p-6 overflow-y-auto min-h-[350px] flex items-center justify-center bg-black/40">
                <template x-if="activeDoc">
                    <div class="w-full h-full flex items-center justify-center">
                        <!-- Image Preview -->
                        <template x-if="['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(activeDoc.ext)">
                            <img :src="activeDoc.url" class="max-w-full max-h-[60vh] object-contain rounded-xl border border-white/10 shadow-xl">
                        </template>
                        
                        <!-- PDF Preview -->
                        <template x-if="activeDoc.ext === 'pdf'">
                            <iframe :src="activeDoc.url" class="w-full h-[60vh] rounded-xl border border-white/10" frameborder="0"></iframe>
                        </template>
                        
                        <!-- Video Preview -->
                        <template x-if="['mp4', 'mov', 'avi', 'webm', 'mkv'].includes(activeDoc.ext)">
                            <video :src="activeDoc.url" controls class="max-w-full max-h-[60vh] object-contain rounded-xl border border-white/10 bg-black w-full shadow-xl"></video>
                        </template>
                        
                        <!-- Other Preview -->
                        <template x-if="!['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf', 'mp4', 'mov', 'avi', 'webm', 'mkv'].includes(activeDoc.ext)">
                            <div class="text-center py-12">
                                <i data-lucide="file" class="w-16 h-16 text-orange-500/40 mx-auto mb-4"></i>
                                <p class="text-sm text-white/60">Dokumen tidak dapat dipratinjau langsung.</p>
                                <p class="text-xs text-white/40 mt-1">Silakan unduh dokumen untuk melihatnya.</p>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-white/5 flex items-center justify-end gap-3 bg-[#090909]">
                <button @click="modalOpen = false" class="px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/5 text-xs font-bold uppercase tracking-wider text-white transition duration-200">
                    Tutup
                </button>
                <a :href="activeDoc ? activeDoc.url : '#'" download 
                   class="px-5 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-xs font-bold uppercase tracking-wider text-black transition duration-200 flex items-center gap-2">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Unduh File
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
