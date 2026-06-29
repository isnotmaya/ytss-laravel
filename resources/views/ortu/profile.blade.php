@extends('layouts.ortu')

@section('content')
<div class="space-y-10">
    <!-- PAGE TITLE -->
    <div>
        <h1 class="heading-font text-4xl lg:text-5xl font-black uppercase tracking-wider text-white">
            PROFIL ORANG TUA
        </h1>
        <p class="text-sm text-white/50 mt-1">
            Kelola data pribadi orang tua/wali serta informasi akun login Anda.
        </p>
    </div>

    <!-- NOTIFICATION ALERTS -->
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-emerald-400 text-sm flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-red-500/20 bg-red-500/10 p-4 text-red-400 text-sm flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT COLUMN: DATA ORANG TUA -->
        <div class="lg:col-span-2 space-y-8">
            <form method="POST" action="{{ route('ortu.profile.update') }}" enctype="multipart/form-data" 
                  x-data="{
                      upload_fotoPreviewUrl: '', upload_fotoFileName: '', upload_fotoFileSize: '', upload_fotoFileType: '', upload_fotoHasFile: false,
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
                          } else {
                              this[field + 'FileType'] = 'other';
                              this[field + 'PreviewUrl'] = '';
                          }
                      }
                  }" class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6">
                @csrf
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="users" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Data Orang Tua</h2>
                </div>

                @if($ortu)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- FATHER DETAILS -->
                        <div class="md:col-span-2">
                            <h3 class="heading-font text-lg font-bold uppercase text-orange-400 tracking-wide mb-1 border-l-2 border-orange-500 pl-2">Data Ayah</h3>
                        </div>

                        <div>
                            <label for="nama_ayah" class="text-xs uppercase font-bold text-white/60 tracking-wider">Nama Ayah <span class="text-orange-500">*</span></label>
                            <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $ortu->nama_ayah) }}" required
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>

                        <div>
                            <label for="pekerjaan_ayah" class="text-xs uppercase font-bold text-white/60 tracking-wider">Pekerjaan Ayah <span class="text-orange-500">*</span></label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $ortu->pekerjaan_ayah) }}" required
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>

                        <div class="md:col-span-2">
                            <label for="nomor_hp_ayah" class="text-xs uppercase font-bold text-white/60 tracking-wider">Nomor HP Ayah <span class="text-orange-500">*</span></label>
                            <input type="text" name="nomor_hp_ayah" id="nomor_hp_ayah" value="{{ old('nomor_hp_ayah', $ortu->nomor_hp_ayah) }}" required
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>

                        <!-- MOTHER DETAILS -->
                        <div class="md:col-span-2 mt-4">
                            <h3 class="heading-font text-lg font-bold uppercase text-orange-400 tracking-wide mb-1 border-l-2 border-orange-500 pl-2">Data Ibu</h3>
                        </div>

                        <div>
                            <label for="nama_ibu" class="text-xs uppercase font-bold text-white/60 tracking-wider">Nama Ibu <span class="text-orange-500">*</span></label>
                            <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $ortu->nama_ibu) }}" required
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>

                        <div>
                            <label for="pekerjaan_ibu" class="text-xs uppercase font-bold text-white/60 tracking-wider">Pekerjaan Ibu <span class="text-orange-500">*</span></label>
                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $ortu->pekerjaan_ibu) }}" required
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>

                        <div class="md:col-span-2">
                            <label for="nomor_hp_ibu" class="text-xs uppercase font-bold text-white/60 tracking-wider">Nomor HP Ibu <span class="text-orange-500">*</span></label>
                            <input type="text" name="nomor_hp_ibu" id="nomor_hp_ibu" value="{{ old('nomor_hp_ibu', $ortu->nomor_hp_ibu) }}" required
                                   class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                        </div>

                        <!-- UPLOAD FOTO PROFIL -->
                        <div class="md:col-span-2 border-t border-white/5 pt-6 mt-4 space-y-4">
                            <h3 class="heading-font text-lg font-bold uppercase text-orange-400 tracking-wide mb-1 border-l-2 border-orange-500 pl-2">Foto Profil</h3>
                            <div class="flex flex-col sm:flex-row items-center gap-5 bg-white/[0.01] border border-white/5 rounded-2xl p-4">
                                <div class="flex-shrink-0">
                                    <!-- Dynamic or static photo view -->
                                    <div x-show="!upload_fotoHasFile">
                                        @if($ortu && $ortu->upload_foto && file_exists(public_path($ortu->upload_foto)))
                                            <img src="{{ asset($ortu->upload_foto) }}" class="w-16 h-16 rounded-full object-cover border border-white/10 bg-neutral-900 shadow-md">
                                        @else
                                            <div class="w-16 h-16 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-500 flex items-center justify-center font-bold text-xl uppercase heading-font shadow-md">
                                                {{ Auth::user()->getInitials() }}
                                            </div>
                                        @endif
                                    </div>
                                    <div x-show="upload_fotoHasFile" style="display:none;">
                                        <img :src="upload_fotoPreviewUrl" class="w-16 h-16 rounded-full object-cover border-2 border-orange-500 shadow-xl bg-neutral-900">
                                    </div>
                                </div>
                                <div class="flex-1 w-full sm:w-auto">
                                    <label for="upload_foto" class="text-[10px] uppercase font-bold text-white/65 tracking-wider block">
                                        {{ ($ortu && $ortu->upload_foto) ? 'Ganti Foto Profil' : 'Unggah Foto Baru' }} (Max 5MB)
                                    </label>
                                    <input type="file" name="upload_foto" id="upload_foto" accept=".jpg,.jpeg,.png,.webp,.gif"
                                           @change="handleFileChange($event, 'upload_foto')"
                                           class="w-full mt-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-orange-500/10 file:text-orange-400 hover:file:bg-orange-500/20 file:transition text-white/50 text-xs">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 rounded-xl font-bold uppercase tracking-wider text-black text-sm shadow-lg shadow-orange-500/15 hover:shadow-orange-500/25 transition duration-300">
                            Simpan Profil Orang Tua
                        </button>
                    </div>
                @else
                    <div class="text-center py-6 text-white/50">
                        Data orang tua tidak ditemukan. Silakan hubungi admin.
                    </div>
                @endif
            </form>
        </div>

        <!-- RIGHT COLUMN: LOGIN ACCOUNT -->
        <div class="lg:col-span-1 space-y-8">
            <!-- ACCOUNT AVATAR -->
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 text-center space-y-4">
                @if($ortu && $ortu->upload_foto && file_exists(public_path($ortu->upload_foto)))
                    <img src="{{ asset($ortu->upload_foto) }}" class="w-24 h-24 rounded-full object-cover border-2 border-orange-500/20 shadow-lg mx-auto bg-neutral-900" alt="{{ Auth::user()->name }}">
                @else
                    <div class="w-24 h-24 rounded-full bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-500 text-4xl font-black heading-font shadow-lg mx-auto">
                        {{ Auth::user()->getInitials() }}
                    </div>
                @endif
                <div>
                    <h3 class="heading-font text-xl font-bold uppercase text-white">{{ Auth::user()->name }}</h3>
                    <p class="text-xs text-orange-500 uppercase font-bold tracking-wider mt-1">Orang Tua / Wali</p>
                </div>
            </div>

            <!-- LOGIN ACCOUNT UPDATE -->
            <form method="POST" action="{{ route('ortu.account.update') }}" class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 space-y-6">
                @csrf
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="key" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-xl font-black uppercase tracking-wider text-white">Akun Login</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="email" class="text-xs uppercase font-bold text-white/60 tracking-wider">Email Akun <span class="text-orange-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                               class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                    </div>

                    <div>
                        <label for="password" class="text-xs uppercase font-bold text-white/60 tracking-wider">Password Baru</label>
                        <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diubah"
                               class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-xs uppercase font-bold text-white/60 tracking-wider">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Tulis ulang password baru"
                               class="w-full mt-2 rounded-xl bg-black/40 border border-white/10 text-white p-3.5 text-sm focus:border-orange-500/50 outline-none transition duration-200">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-orange-500 hover:bg-orange-600 rounded-xl font-bold uppercase tracking-wider text-black text-xs shadow-lg shadow-orange-500/15 hover:shadow-orange-500/25 transition duration-300">
                        Simpan Pengaturan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
