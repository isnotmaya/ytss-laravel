@extends('layouts.ortu')

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
            DATA ANAK SAYA
        </h1>
        <p class="text-sm text-white/50 mt-1">
            Informasi registrasi lengkap, data pribadi, dan dokumen berkas anak Anda (Read-only).
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT COLUMN: CHILD DATA -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 lg:p-8 space-y-6">
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="user" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Data Pribadi Anak</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Nama Lengkap</span>
                        <p class="text-base font-bold text-white mt-1.5">{{ $siswa->nama_lengkap }}</p>
                    </div>

                    <div>
                        <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Jenis Kelamin</span>
                        <p class="text-base font-bold text-white mt-1.5">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>

                    <div>
                        <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Tempat Lahir</span>
                        <p class="text-base font-bold text-white mt-1.5">{{ $siswa->tempat_lahir ?: '-' }}</p>
                    </div>

                    <div>
                        <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Tanggal Lahir</span>
                        <p class="text-base font-bold text-white mt-1.5">{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d M Y') : '-' }}</p>
                    </div>

                    <div>
                        <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Nomor HP / WhatsApp</span>
                        <p class="text-base font-bold text-white mt-1.5">{{ $siswa->nomor_hp ?: '-' }}</p>
                    </div>

                    <div>
                        <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Asal Sekolah</span>
                        <p class="text-base font-bold text-white mt-1.5">{{ $siswa->asal_sekolah ?: '-' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <span class="text-xs uppercase font-bold text-white/40 tracking-wider">Alamat Lengkap</span>
                        <p class="text-base text-white/80 mt-1.5 leading-relaxed">{{ $siswa->alamat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: CHILD DOCUMENTS -->
        <div class="lg:col-span-1">
            <div class="bg-white/[0.03] border border-white/5 rounded-[32px] p-6 space-y-6">
                <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                    <i data-lucide="folder" class="w-5 h-5 text-orange-500"></i>
                    <h2 class="heading-font text-2xl font-black uppercase tracking-wider text-white">Dokumen Anak</h2>
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
                            $hasFile = !empty($doc['path']) && file_exists(public_path($doc['path']));
                        @endphp
                        <div @if($hasFile) @click="openPreview('{{ $doc['label'] }}', '{{ $doc['path'] }}')" @endif
                             class="flex items-center justify-between p-4 rounded-2xl border transition duration-200 {{ $hasFile ? 'bg-white/[0.02] hover:bg-white/[0.06] border-white/5 hover:border-white/10 cursor-pointer' : 'bg-white/[0.01] border-white/5 opacity-60 cursor-not-allowed' }}">
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
                                @if($hasFile)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[9px] font-bold uppercase tracking-wider">
                                        Terupload
                                    </span>
                                    <i data-lucide="eye" class="w-3.5 h-3.5 text-white/30"></i>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-[9px] font-bold uppercase tracking-wider">
                                        Belum Upload
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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
                    <p class="text-[10px] text-white/55 uppercase font-bold tracking-wider mt-0.5">Pratinjau Dokumen Calon Siswa</p>
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
                        
                        <!-- Other Preview -->
                        <template x-if="!['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf'].includes(activeDoc.ext)">
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
                    Download File
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
