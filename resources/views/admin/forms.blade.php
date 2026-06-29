@extends('layouts.app')

@php
    $currentForm = old('entity_key', $activeForm ?? 'profil-sekolah');
    $editingEntity = data_get($editing, 'entity');
    $editingRecord = data_get($editing, 'record');
    $isEditing = fn(string $entity) => $editingEntity === $entity && $editingRecord;
    $formAction = fn(string $entity) => $isEditing($entity)
        ? route('admin.forms.update', ['entity' => $entity, 'id' => $editingRecord->id])
        : route('admin.forms.store', $entity);
    $formValue = fn(string $entity, string $field, $default = '') => old(
        $field,
        $isEditing($entity) ? data_get($editingRecord, $field, $default) : $default,
    );
    $inputClass =
        'w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-orange-300/45 focus:bg-black/30';
    $fileClass =
        'w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-orange-500/20 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#ffcf97] focus:border-orange-300/45 focus:bg-black/30';
    $textareaClass =
        'w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-orange-300/45 focus:bg-black/30';
    $labelClass = 'mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/62';
    $helperClass = 'mt-2 text-xs leading-6 text-white/38';
    $submitClass =
        'rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_24px_rgba(249,115,22,0.18)] transition hover:brightness-105';
@endphp

@section('content')
    <main x-data="{ activeForm: '{{ $currentForm }}', mobileDrawer: false }"
        class="admin-form-page min-h-screen bg-[radial-gradient(circle_at_top,rgba(249,115,22,0.15),transparent_22%),linear-gradient(180deg,#090909_0%,#130d08_38%,#0a0a0a_100%)] font-['Sora'] text-white">
        <style>
            .admin-form-page [x-cloak] {
                display: none !important;
            }

            .admin-form-page .admin-form-layout {
                display: grid;
                gap: 1.5rem;
            }

            .admin-form-page .admin-form-layout {
                display: grid;
                gap: 1.5rem;
                grid-template-columns: 1fr;
            }

            .admin-form-page .admin-form-card {
                border: 1px solid rgba(255, 255, 255, 0.08);
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.035) 0%, rgba(255, 255, 255, 0.015) 100%);
                border-radius: 24px;
                padding: 1.25rem;
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
            }

            .admin-form-page .admin-form-card label {
                letter-spacing: 0.16em;
            }

            .admin-form-page .admin-form-card input,
            .admin-form-page .admin-form-card select,
            .admin-form-page .admin-form-card textarea {
                min-height: 52px;
            }

            .admin-form-page .admin-section-nav {
                position: static;
            }

            .admin-form-page .admin-module-shell {
                scroll-margin-top: 1.5rem;
            }

            .admin-form-page .admin-module-heading {
                display: flex;
                flex-wrap: wrap;
                align-items: flex-start;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1.25rem;
            }

            .admin-form-page .admin-module-kicker {
                font-size: 11px;
                letter-spacing: 0.24em;
                text-transform: uppercase;
                color: rgba(255, 207, 151, 0.8);
            }

            .admin-form-page .admin-module-title {
                margin-top: 0.55rem;
                font-family: "Barlow Condensed", sans-serif;
                font-size: clamp(2rem, 3vw, 2.6rem);
                font-weight: 900;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                color: #fff;
            }

            .admin-form-page .admin-module-copy {
                margin-top: 0.6rem;
                max-width: 52rem;
                font-size: 0.92rem;
                line-height: 1.8;
                color: rgba(255, 255, 255, 0.58);
            }

            .admin-form-page .admin-module-badge {
                border: 1px solid rgba(255, 255, 255, 0.1);
                background: rgba(255, 255, 255, 0.04);
                border-radius: 9999px;
                padding: 0.75rem 1rem;
                font-size: 0.72rem;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.7);
            }

            @media (min-width: 1280px) {
                .admin-form-page .admin-section-nav {
                    position: sticky;
                    top: 1.5rem;
                }
            }
        </style>
        <script>
            window.adminTableState = (records, searchableFields, statusField = null, hasSoftDelete = false) => ({
                records,
                searchableFields,
                statusField,
                hasSoftDelete,
                search: '',
                status: 'all',
                trashFilter: 'active',
                page: 1,
                perPage: 5,
                selectedRecord: null,
                showDetailModal: false,
                get statusOptions() {
                    if (!this.statusField) {
                        return [];
                    }

                    return [...new Set(this.records
                        .map(record => record[this.statusField])
                        .filter(value => value !== null && value !== undefined && value !== ''))];
                },
                get filteredRecords() {
                    const keyword = this.search.trim().toLowerCase();

                    return this.records.filter((record) => {
                        const matchesKeyword = !keyword || this.searchableFields.some((field) => {
                            const value = record[field];
                            return value !== null && value !== undefined && String(value)
                                .toLowerCase().includes(keyword);
                        });

                        const matchesStatus = this.status === 'all' || !this.statusField || String(record[
                            this.statusField]) === this.status;

                        let matchesTrash = true;
                        if (this.hasSoftDelete) {
                            if (this.trashFilter === 'active') {
                                matchesTrash = !record.deleted_at;
                            } else if (this.trashFilter === 'trash') {
                                matchesTrash = !!record.deleted_at;
                            }
                        }

                        return matchesKeyword && matchesStatus && matchesTrash;
                    });
                },
                get totalPages() {
                    return Math.max(1, Math.ceil(this.filteredRecords.length / this.perPage));
                },
                get paginatedRecords() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filteredRecords.slice(start, start + this.perPage);
                },
                formatValue(field, value) {
                    if (value === null || value === undefined || value === '') {
                        return '-';
                    }

                    if (String(value).startsWith('uploads/')) {
                        return 'File tersimpan';
                    }

                    if (['status_label', 'status_aktif_label', 'status_pendaftaran_label', 'kelompok_kelas_label',
                            'jenis_beasiswa_label'
                        ].includes(field)) {
                        return value;
                    }

                    if (['status', 'status_aktif'].includes(field)) {
                        return String(value) === '1' || value === 1 ? 'Aktif' : 'Nonaktif';
                    }

                    if (typeof value === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(value)) {
                        return new Date(value + 'T00:00:00').toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                        });
                    }

                    if (typeof value === 'string' && /^\d{2}:\d{2}(:\d{2})?$/.test(value)) {
                        return value.slice(0, 5);
                    }

                    return String(value);
                },
                formatDateTime(value) {
                    if (!value) return '-';
                    const date = new Date(value);
                    if (isNaN(date.getTime())) return value;

                    const months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];

                    const day = date.getDate();
                    const month = months[date.getMonth()];
                    const year = date.getFullYear();

                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');

                    return `${day} ${month} ${year} ${hours}:${minutes} WIB`;
                },
                statusBadgeClass(value) {
                    const val = String(value).toLowerCase().trim();
                    if (['pending', 'daftar-reguler', 'daftar-beasiswa'].includes(val)) {
                        return 'bg-amber-500/10 text-amber-400 border border-amber-500/20';
                    }
                    if (['diterima', 'aktif', '1', 'true', 'yes'].includes(val)) {
                        return 'bg-green-500/10 text-green-400 border border-green-500/20';
                    }
                    if (['ditolak', 'daftar-tolak', 'tidak-aktif', '0', 'false', 'no'].includes(val)) {
                        return 'bg-red-500/10 text-red-400 border border-red-500/20';
                    }
                    if (['cuti'].includes(val)) {
                        return 'bg-sky-500/10 text-sky-400 border border-sky-500/20';
                    }
                    return 'bg-neutral-500/10 text-neutral-400 border border-white/5';
                },
                resolvedUrls: {},
                fileExistence: {},
                init() {
                    this.$watch('selectedRecord', record => {
                        if (record) {
                            this.checkFilesForRecord(record);
                        }
                    });
                },
                async checkFilesForRecord(record) {
                    if (!record) return;
                    for (const key in record) {
                        const val = record[key];
                        if (val && typeof val === 'string' && (val.startsWith('uploads/') || val.includes('.'))) {
                            await this.resolveFileUrl(val);
                        }
                    }
                },
                async resolveFileUrl(path) {
                    if (!path) return;
                    if (this.resolvedUrls[path] !== undefined) return;

                    const directUrl = '/' + path;

                    try {
                        const resDirect = await fetch(directUrl, {
                            method: 'HEAD'
                        });
                        if (resDirect.ok) {
                            this.resolvedUrls[path] = directUrl;
                            this.fileExistence[path] = true;
                            return;
                        }
                    } catch (e) {}

                    this.resolvedUrls[path] = directUrl;
                    this.fileExistence[path] = false;
                },
                fileKindFromPath(path) {
                    if (!path) {
                        return '';
                    }

                    const extension = String(path).split('.').pop().toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(extension)) {
                        return 'image';
                    }

                    if (['mp4', 'webm', 'mov', 'mkv', 'avi'].includes(extension)) {
                        return 'video';
                    }

                    if (extension === 'pdf') {
                        return 'pdf';
                    }

                    return 'file';
                },
                getFileName(path) {
                    if (!path) return '';
                    return String(path).split('/').pop();
                },
                updatePage(value) {
                    this.page = Math.min(this.totalPages, Math.max(1, value));
                },
                refresh() {
                    this.updatePage(1);
                    this.selectedRecord = null;
                    this.showDetailModal = false;
                }
            });
        </script>
        <div class="mx-auto max-w-7xl px-4 py-6 md:px-8 lg:px-10">
            <header
                class="mb-6 overflow-hidden rounded-[24px] border border-white/10 bg-white/[0.04] shadow-[0_16px_50px_rgba(0,0,0,0.25)] backdrop-blur-xl">
                <div
                    class="relative bg-[linear-gradient(135deg,rgba(249,115,22,0.15),rgba(255,255,255,0.01),rgba(217,138,58,0.08))] px-4 py-4 md:px-6">
                    <div class="absolute right-[-50px] top-[-40px] h-40 w-40 rounded-full bg-orange-400/20 blur-3xl"></div>
                    <div class="relative flex items-start justify-between">

                        <div class="flex items-center gap-3">
                            <button type="button" @click="mobileDrawer = !mobileDrawer"
                                class="flex items-center justify-center rounded-2xl border border-white/10 bg-white/[0.04] p-3 text-white transition hover:bg-white/[0.08]">
                                <i data-lucide="menu" class="h-5 w-5"></i>
                            </button>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#ffcf97]">
                                    Admin Input Center
                                </p>

                                <h1
                                    class="font-['Barlow_Condensed'] text-2xl font-black uppercase tracking-wider text-white">
                                    Manajemen Data
                                </h1>
                            </div>
                        </div>

                        <a href="{{ route('admin.dashboard') }}"
                            class="flex h-11 w-11 items-center justify-center rounded-full border border-orange-400/20 bg-orange-500/10 text-[#ffcf97] transition hover:bg-orange-500/20">
                            <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                        </a>

                    </div>
                </div>
            </header>

            @if (session('success'))
                <div
                    class="mb-6 overflow-hidden rounded-[24px] border border-emerald-400/20 bg-[linear-gradient(135deg,rgba(16,185,129,0.16),rgba(255,255,255,0.03))] shadow-[0_18px_50px_rgba(0,0,0,0.22)]">
                    <div class="flex items-start gap-4 px-5 py-4 md:px-6">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-400/15 text-emerald-200">
                            <i class="fa-solid fa-circle-check text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-emerald-200/80">Berhasil
                            </p>
                            <h3 class="mt-1 font-['Barlow_Condensed'] text-2xl font-black uppercase text-white">Perubahan
                                Tersimpan</h3>
                            <p class="mt-2 text-sm leading-7 text-emerald-50/80">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($editingEntity && $editingRecord)
                <div class="mb-6 rounded-[22px] border border-orange-300/20 bg-orange-500/10 px-5 py-4 text-[#ffd7b0]">
                    Mode edit aktif untuk modul <span
                        class="font-semibold text-white">{{ str_replace('-', ' ', $editingEntity) }}</span>.
                    Simpan perubahan atau klik <span class="font-semibold text-white">Batal Edit</span> untuk kembali ke
                    mode input baru.
                </div>
            @endif

            <div class="w-full">
                <aside class="hidden">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-[#ffcf97]/80">Navigasi Cepat</p>
                    <h2 class="mt-3 font-['Barlow_Condensed'] text-3xl font-black uppercase text-white">Pilih Modul
                    </h2>
                    <p class="mt-2 text-sm leading-7 text-white/55">
                        Buka modul yang ingin dikelola. Saat edit aktif, form terkait otomatis tetap terbuka.
                    </p>
                    <div class="mt-5 space-y-2">
                        @foreach ([
            'profil-sekolah' => 'Profil Sekolah',
            'info-promo' => 'Info Promo',
            'users' => 'Akun Pengguna',
            'jenis-beasiswa' => 'Jenis Beasiswa',
            'kelompok-kelas' => 'Kelompok Kelas',
            'siswa-ortu' => 'Data Orang Tua',
            'siswa' => 'Data Siswa',
            'achievement' => 'Prestasi',
            'agenda' => 'Agenda',
            'jadwal-latihan' => 'Jadwal Latihan',
            'tournament' => 'Turnamen',
            'daftar-reguler' => 'Daftar Reguler',
            'daftar-beasiswa' => 'Daftar Beasiswa',
        ] as $slug => $label)
                            <a href="#{{ $slug }}" @click="activeForm = '{{ $slug }}'"
                                class="flex items-center justify-between rounded-[18px] border px-4 py-3 text-sm font-semibold transition"
                                :class="activeForm === '{{ $slug }}'
                                    ?
                                    'border-orange-300/45 bg-orange-500/10 text-white' :
                                    'border-white/10 bg-white/[0.02] text-white/70 hover:border-orange-300/30 hover:text-white'">
                                <span>{{ $label }}</span>
                                <span class="text-[10px] uppercase tracking-[0.18em] text-white/35">Open</span>
                            </a>
                        @endforeach
                    </div>
                </aside>

                <!-- Mobile Sidebar Left Drawer -->
                <div x-show="mobileDrawer" x-cloak class="relative z-50" aria-modal="true">
                    <!-- Backdrop Overlay -->
                    <div x-show="mobileDrawer" x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 backdrop-blur-sm"
                        @click="mobileDrawer = false"></div>

                    <div class="fixed inset-y-0 left-0 flex max-w-full">
                        <!-- Drawer Panel -->
                        <div x-show="mobileDrawer" x-transition:enter="transform transition ease-in-out duration-300"
                            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-200"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                            class="w-screen max-w-xs transform bg-[#0d0d0d] border-r border-white/10 p-6 shadow-2xl flex flex-col justify-between">

                            <div>
                                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                                    <div>
                                        <p class="text-[9px] font-semibold uppercase tracking-[0.24em] text-[#ffcf97]">Menu
                                            Modul</p>
                                        <h2 class="mt-1 font-['Barlow_Condensed'] text-2xl font-black uppercase text-white">
                                            YTSS Admin</h2>
                                    </div>
                                    <button type="button" @click="mobileDrawer = false"
                                        class="text-white/40 hover:text-white">
                                        <i class="fa-solid fa-xmark text-lg"></i>
                                    </button>
                                </div>

                                <div class="mt-6 space-y-2 overflow-y-auto max-h-[70vh] no-scrollbar">
                                    @foreach ([
            'profil-sekolah' => 'Profil Sekolah',
            'info-promo' => 'Info Promo',
            'users' => 'Akun Pengguna',
            'jenis-beasiswa' => 'Jenis Beasiswa',
            'kelompok-kelas' => 'Kelompok Kelas',
            'siswa-ortu' => 'Data Orang Tua',
            'siswa' => 'Data Siswa',
            'achievement' => 'Prestasi',
            'agenda' => 'Agenda',
            'jadwal-latihan' => 'Jadwal Latihan',
            'tournament' => 'Turnamen',
            'daftar-reguler' => 'Daftar Reguler',
            'daftar-beasiswa' => 'Daftar Beasiswa',
        ] as $slug => $label)
                                        <a href="#{{ $slug }}"
                                            @click="activeForm = '{{ $slug }}'; mobileDrawer = false"
                                            class="flex items-center justify-between rounded-[18px] border px-4 py-3 text-sm font-semibold transition"
                                            :class="activeForm === '{{ $slug }}'
                                                ?
                                                'border-orange-300/45 bg-orange-500/10 text-white' :
                                                'border-white/10 bg-white/[0.02] text-white/70 hover:border-orange-300/30 hover:text-white'">
                                            <span>{{ $label }}</span>
                                            <span class="text-[10px] uppercase tracking-[0.18em] text-white/35">Open</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-t border-white/10 pt-4 mt-6">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex w-full items-center justify-center gap-2 rounded-full border border-white/15 bg-white/[0.04] py-3 text-xs font-semibold uppercase tracking-[0.18em] text-white/80 transition hover:border-white/30 hover:bg-white/[0.08]">
                                    <i class="fa-solid fa-house text-[10px]"></i> Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <section id="profil-sekolah" x-show="activeForm === 'profil-sekolah'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'profil-sekolah'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">profil_sekolah</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Profil Sekolah
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'profil-sekolah'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('profil-sekolah')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('profil-sekolah')->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ $formAction('profil-sekolah') }}" enctype="multipart/form-data"
                                class="admin-form-card grid gap-4">
                                @csrf
                                @if ($isEditing('profil-sekolah'))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="entity_key" value="profil-sekolah">
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Judul profile sekolah</label>
                                    <input type="text" name="judul_profile_sekolah"
                                        value="{{ $formValue('profil-sekolah', 'judul_profile_sekolah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Konten profile sekolah</label>
                                    <textarea name="konten_profile_sekolah" rows="5"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>{{ $formValue('profil-sekolah', 'konten_profile_sekolah') }}</textarea>
                                </div>
                                @include('admin.partials.media-input', [
                                    'name' => 'upload_photo_profile_sekolah',
                                    'label' => 'Upload photo profile sekolah',
                                    'accept' => '.jpg,.jpeg,.png,.webp',
                                    'existingPath' => $isEditing('profil-sekolah')
                                        ? data_get($editingRecord, 'upload_photo_profile_sekolah')
                                        : null,
                                    'previewKind' => 'image',
                                    'help' => 'Preview gambar muncul langsung di bawah input sebelum disimpan.',
                                ])
                                <div>
                                    <button type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">
                                        {{ $isEditing('profil-sekolah') ? 'Update Profil Sekolah' : 'Simpan Profil Sekolah' }}
                                    </button>
                                    @if ($isEditing('profil-sekolah'))
                                        <a href="{{ route('admin.forms.index', ['section' => 'profil-sekolah']) }}#profil-sekolah"
                                            class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">
                                            Batal Edit
                                        </a>
                                    @endif
                                </div>
                            </form>
                            @include('admin.partials.entity-table', [
                                'entity' => 'profil-sekolah',
                                'title' => 'Profil Sekolah',
                            ])
                        </div>
                    </section>

                    <section id="info-promo" x-show="activeForm === 'info-promo'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'info-promo'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">info_promo</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Info Promo
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'info-promo'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('info-promo')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('info-promo')->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ $formAction('info-promo') }}" enctype="multipart/form-data"
                                class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                @csrf
                                @if ($isEditing('info-promo'))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="entity_key" value="info-promo">
                                <div class="xl:col-span-2">
                                    <label class="mb-2 block text-sm text-white/70">Judul</label>
                                    <input type="text" name="judul" value="{{ $formValue('info-promo', 'judul') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div class="xl:col-span-2">
                                    <label class="mb-2 block text-sm text-white/70">Deskripsi</label>
                                    <textarea name="deskripsi" rows="4"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>{{ $formValue('info-promo', 'deskripsi') }}</textarea>
                                </div>
                                @include('admin.partials.media-input', [
                                    'name' => 'gambar',
                                    'label' => 'Gambar',
                                    'accept' => '.jpg,.jpeg,.png,.webp',
                                    'existingPath' => $isEditing('info-promo')
                                        ? data_get($editingRecord, 'gambar')
                                        : null,
                                    'previewKind' => 'image',
                                    'help' =>
                                        'Gunakan gambar yang jelas supaya promo tetap enak dilihat di layar kecil.',
                                ])
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Status</label>
                                    <select name="status"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                        <option value="1" @selected($formValue('info-promo', 'status', '1') == '1')>Aktif</option>
                                        <option value="0" @selected($formValue('info-promo', 'status') == '0')>Nonaktif</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Tanggal mulai</label>
                                    <input type="date" name="tanggal_mulai"
                                        value="{{ $formValue('info-promo', 'tanggal_mulai') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Tanggal selesai</label>
                                    <input type="date" name="tanggal_selesai"
                                        value="{{ $formValue('info-promo', 'tanggal_selesai') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div class="xl:col-span-2">
                                    <button type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">
                                        {{ $isEditing('info-promo') ? 'Update Info Promo' : 'Simpan Info Promo' }}
                                    </button>
                                    @if ($isEditing('info-promo'))
                                        <a href="{{ route('admin.forms.index', ['section' => 'info-promo']) }}#info-promo"
                                            class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">
                                            Batal Edit
                                        </a>
                                    @endif
                                </div>
                            </form>
                            @include('admin.partials.entity-table', [
                                'entity' => 'info-promo',
                                'title' => 'Info Promo',
                            ])
                        </div>
                    </section>

                    <section id="users" x-show="activeForm === 'users'" x-cloak x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'users'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">users</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Akun Pengguna
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'users'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('users')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('users')->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ $formAction('users') }}"
                                class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                @csrf
                                @if ($isEditing('users'))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="entity_key" value="users">
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Kode user</label>
                                    <input type="text" name="kd_users" value="{{ $formValue('users', 'kd_users') }}"
                                        maxlength="6"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 uppercase outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nama</label>
                                    <input type="text" name="name" value="{{ $formValue('users', 'name') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Email</label>
                                    <input type="email" name="email" value="{{ $formValue('users', 'email') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Role</label>
                                    <select name="role"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                        @foreach (['manajemen', 'ortu', 'siswa', 'coach'] as $role)
                                            <option value="{{ $role }}" @selected($formValue('users', 'role') === $role)>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Status aktif</label>
                                    <select name="status_aktif"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                        <option value="1" @selected($formValue('users', 'status_aktif', '1') == '1')>Aktif</option>
                                        <option value="0" @selected($formValue('users', 'status_aktif') == '0')>Nonaktif</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Password</label>
                                    <input type="password" name="password"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        @required(!$isEditing('users'))>
                                </div>
                                <div class="xl:col-span-2">
                                    <button type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">
                                        {{ $isEditing('users') ? 'Update Akun Pengguna' : 'Simpan Akun Pengguna' }}
                                    </button>
                                    @if ($isEditing('users'))
                                        <a href="{{ route('admin.forms.index', ['section' => 'users']) }}#users"
                                            class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">
                                            Batal Edit
                                        </a>
                                    @endif
                                </div>
                            </form>
                            @include('admin.partials.entity-table', [
                                'entity' => 'users',
                                'title' => 'Akun Pengguna',
                            ])
                        </div>
                    </section>

                    <section id="jenis-beasiswa" x-show="activeForm === 'jenis-beasiswa'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'jenis-beasiswa'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">jenis_beasiswa</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Jenis
                                    Beasiswa
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'jenis-beasiswa'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('jenis-beasiswa')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('jenis-beasiswa')->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ $formAction('jenis-beasiswa') }}"
                                class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                @csrf
                                @if ($isEditing('jenis-beasiswa'))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="entity_key" value="jenis-beasiswa">
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nama beasiswa</label>
                                    <input type="text" name="nama_beasiswa"
                                        value="{{ $formValue('jenis-beasiswa', 'nama_beasiswa') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Potongan SPP</label>
                                    <input type="number" min="0" name="potongan_spp"
                                        value="{{ $formValue('jenis-beasiswa', 'potongan_spp') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div class="xl:col-span-2">
                                    <label class="mb-2 block text-sm text-white/70">Keterangan</label>
                                    <textarea name="keterangan" rows="4"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">{{ $formValue('jenis-beasiswa', 'keterangan') }}</textarea>
                                </div>
                                <div class="xl:col-span-2">
                                    <button type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">
                                        {{ $isEditing('jenis-beasiswa') ? 'Update Jenis Beasiswa' : 'Simpan Jenis Beasiswa' }}
                                    </button>
                                    @if ($isEditing('jenis-beasiswa'))
                                        <a href="{{ route('admin.forms.index', ['section' => 'jenis-beasiswa']) }}#jenis-beasiswa"
                                            class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">
                                            Batal Edit
                                        </a>
                                    @endif
                                </div>
                            </form>
                            @include('admin.partials.entity-table', [
                                'entity' => 'jenis-beasiswa',
                                'title' => 'Jenis Beasiswa',
                            ])
                        </div>
                    </section>

                    <section id="kelompok-kelas" x-show="activeForm === 'kelompok-kelas'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'kelompok-kelas'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">kelompok_kelas</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Kelompok
                                    Kelas
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'kelompok-kelas'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('kelompok-kelas')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('kelompok-kelas')->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ $formAction('kelompok-kelas') }}"
                                enctype="multipart/form-data"
                                class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                @csrf
                                @if ($isEditing('kelompok-kelas'))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="entity_key" value="kelompok-kelas">
                                <div class="xl:col-span-2">
                                    <label class="mb-2 block text-sm text-white/70">Nama kelompok</label>
                                    <input type="text" name="nama_kelompok"
                                        value="{{ $formValue('kelompok-kelas', 'nama_kelompok') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Dari tahun kelahiran</label>
                                    <input type="number" name="dari_tahun_kelahiran"
                                        value="{{ $formValue('kelompok-kelas', 'dari_tahun_kelahiran') }}" min="2000"
                                        max="2100"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Sampai tahun kelahiran</label>
                                    <input type="number" name="sampai_tahun_kelahiran"
                                        value="{{ $formValue('kelompok-kelas', 'sampai_tahun_kelahiran') }}"
                                        min="2000" max="2100"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                @include('admin.partials.media-input', [
                                    'name' => 'upload_kelompok_kelas',
                                    'label' => 'Upload kelompok kelas',
                                    'accept' => '.jpg,.jpeg,.png,.webp',
                                    'existingPath' => $isEditing('kelompok-kelas')
                                        ? data_get($editingRecord, 'upload_kelompok_kelas')
                                        : null,
                                    'previewKind' => 'image',
                                    'help' =>
                                        'Banner kelompok kelas akan tampil preview agar admin bisa cek sebelum simpan.',
                                ])
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Keterangan kelompok kelas</label>
                                    <textarea name="keterangan_kelompok_kelas" rows="3"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">{{ $formValue('kelompok-kelas', 'keterangan_kelompok_kelas') }}</textarea>
                                </div>
                                <div class="xl:col-span-2">
                                    <button type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">
                                        {{ $isEditing('kelompok-kelas') ? 'Update Kelompok Kelas' : 'Simpan Kelompok Kelas' }}
                                    </button>
                                    @if ($isEditing('kelompok-kelas'))
                                        <a href="{{ route('admin.forms.index', ['section' => 'kelompok-kelas']) }}#kelompok-kelas"
                                            class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">
                                            Batal Edit
                                        </a>
                                    @endif
                                </div>
                            </form>
                            @include('admin.partials.entity-table', [
                                'entity' => 'kelompok-kelas',
                                'title' => 'Kelompok Kelas',
                            ])
                        </div>
                    </section>

                    <section id="siswa-ortu" x-show="activeForm === 'siswa-ortu'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'siswa-ortu'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">siswa_ortu</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Data Orang
                                    Tua
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'siswa-ortu'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('siswa-ortu')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('siswa-ortu')->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ $formAction('siswa-ortu') }}"
                                class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                @csrf
                                @if ($isEditing('siswa-ortu'))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="entity_key" value="siswa-ortu">
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Siswa terkait</label>
                                    <select name="id_siswa"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                        <option value="">-- Belum Terhubung --</option>
                                        @foreach ($siswaList as $sw)
                                            <option value="{{ $sw->id }}" @selected($formValue('siswa-ortu', 'id_siswa') == $sw->id)>
                                                {{ $sw->nama_lengkap }} ({{ $sw->kd_users }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Kode user (Orang Tua)</label>
                                    <input type="text" name="kd_users"
                                        value="{{ $formValue('siswa-ortu', 'kd_users') }}" maxlength="6"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 uppercase outline-none focus:border-orange-300/40">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nama ayah</label>
                                    <input type="text" name="nama_ayah"
                                        value="{{ $formValue('siswa-ortu', 'nama_ayah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Pekerjaan ayah</label>
                                    <input type="text" name="pekerjaan_ayah"
                                        value="{{ $formValue('siswa-ortu', 'pekerjaan_ayah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nomor HP ayah</label>
                                    <input type="text" name="nomor_hp_ayah"
                                        value="{{ $formValue('siswa-ortu', 'nomor_hp_ayah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nama ibu</label>
                                    <input type="text" name="nama_ibu"
                                        value="{{ $formValue('siswa-ortu', 'nama_ibu') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Pekerjaan ibu</label>
                                    <input type="text" name="pekerjaan_ibu"
                                        value="{{ $formValue('siswa-ortu', 'pekerjaan_ibu') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nomor HP ibu</label>
                                    <input type="text" name="nomor_hp_ibu"
                                        value="{{ $formValue('siswa-ortu', 'nomor_hp_ibu') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div class="xl:col-span-2">
                                    <button type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">
                                        {{ $isEditing('siswa-ortu') ? 'Update Data Orang Tua' : 'Simpan Data Orang Tua' }}
                                    </button>
                                    @if ($isEditing('siswa-ortu'))
                                        <a href="{{ route('admin.forms.index', ['section' => 'siswa-ortu']) }}#siswa-ortu"
                                            class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">
                                            Batal Edit
                                        </a>
                                    @endif
                                </div>
                            </form>
                            @include('admin.partials.entity-table', [
                                'entity' => 'siswa-ortu',
                                'title' => 'Data Orang Tua',
                            ])
                        </div>
                    </section>

                    <section id="siswa" x-show="activeForm === 'siswa'" x-cloak x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'siswa'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">siswa</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Data Siswa
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'siswa'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('siswa')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('siswa')->first() }}
                                </div>
                            @endif
                            @if ($kelompokKelas->isEmpty())
                                <div
                                    class="rounded-2xl border border-yellow-400/20 bg-yellow-500/10 px-4 py-3 text-sm text-yellow-100">
                                    Tambahkan data `kelompok_kelas` terlebih dahulu sebelum input siswa.
                                </div>
                            @else
                                <form method="POST" action="{{ $formAction('siswa') }}" enctype="multipart/form-data"
                                    class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                    @csrf
                                    @if ($isEditing('siswa'))
                                        @method('PUT')
                                    @endif
                                    <input type="hidden" name="entity_key" value="siswa">
                                    <div class="xl:col-span-2">
                                        <label class="mb-2 block text-sm text-white/70">Kelompok kelas</label>
                                        <select name="id_kelompok_kelas"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach ($kelompokKelas as $kelompok)
                                                <option value="{{ $kelompok->id }}" @selected($formValue('siswa', 'id_kelompok_kelas') == $kelompok->id)>
                                                    {{ $kelompok->nama_kelompok }} ({{ $kelompok->dari_tahun_kelahiran }}
                                                    -
                                                    {{ $kelompok->sampai_tahun_kelahiran }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Kode user</label>
                                        <input type="text" name="kd_users"
                                            value="{{ $formValue('siswa', 'kd_users') }}" maxlength="6"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 uppercase outline-none focus:border-orange-300/40"
                                            required>
                                    </div>

                                    <div class="xl:col-span-2">
                                        <label class="mb-2 block text-sm text-white/70">Nama lengkap</label>
                                        <input type="text" name="nama_lengkap"
                                            value="{{ $formValue('siswa', 'nama_lengkap') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Tempat lahir</label>
                                        <input type="text" name="tempat_lahir"
                                            value="{{ $formValue('siswa', 'tempat_lahir') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Tanggal lahir</label>
                                        <input type="date" name="tanggal_lahir"
                                            value="{{ $formValue('siswa', 'tanggal_lahir') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Jenis kelamin</label>
                                        <select name="jenis_kelamin"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            <option value="L" @selected($formValue('siswa', 'jenis_kelamin') === 'L')>Laki-laki</option>
                                            <option value="P" @selected($formValue('siswa', 'jenis_kelamin') === 'P')>Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Nomor HP</label>
                                        <input type="text" name="nomor_hp"
                                            value="{{ $formValue('siswa', 'nomor_hp') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <label class="mb-2 block text-sm text-white/70">Alamat</label>
                                        <textarea name="alamat" rows="3"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>{{ $formValue('siswa', 'alamat') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Asal sekolah</label>
                                        <input type="text" name="asal_sekolah"
                                            value="{{ $formValue('siswa', 'asal_sekolah') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Status aktif</label>
                                        <select name="status_aktif"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach (['daftar-reguler', 'daftar-beasiswa', 'daftar-tolak', 'aktif', 'cuti', 'tidak-aktif'] as $status)
                                                <option value="{{ $status }}" @selected($formValue('siswa', 'status_aktif') === $status)>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @include('admin.partials.media-input', [
                                        'name' => 'upload_akte',
                                        'label' => 'Upload akte',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'upload_akte')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'Preview aktif untuk dokumen maupun gambar hasil scan.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'upload_kk',
                                        'label' => 'Upload KK',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'upload_kk')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'File KK bisa dicek dulu sebelum tersimpan ke database.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'upload_ijazah',
                                        'label' => 'Upload ijazah',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'upload_ijazah')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'Gunakan file yang paling jelas agar verifikasi lebih cepat.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'upload_foto',
                                        'label' => 'Upload foto',
                                        'accept' => '.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'upload_foto')
                                            : null,
                                        'previewKind' => 'image',
                                        'help' => 'Foto siswa muncul preview langsung di form.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'beasiswa_sertifikat_1',
                                        'label' => 'Beasiswa sertifikat 1',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'beasiswa_sertifikat_1')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'Lampiran pertama untuk jalur beasiswa.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'beasiswa_sertifikat_2',
                                        'label' => 'Beasiswa sertifikat 2',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'beasiswa_sertifikat_2')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'Lampiran kedua akan tampil rapi di bawah input.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'beasiswa_sertifikat_3',
                                        'label' => 'Beasiswa sertifikat 3',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'beasiswa_sertifikat_3')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'Lampiran ketiga membantu admin melihat kelengkapan data.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'beasiswa_video',
                                        'label' => 'Beasiswa video',
                                        'accept' => '.mp4,.mov,.avi,.webm,.mkv',
                                        'existingPath' => $isEditing('siswa')
                                            ? data_get($editingRecord, 'beasiswa_video')
                                            : null,
                                        'previewKind' => 'video',
                                        'help' => 'Video bisa diputar langsung sebelum disimpan.',
                                    ])
                                    <div class="xl:col-span-2">
                                        <button type="submit"
                                            class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">
                                            {{ $isEditing('siswa') ? 'Update Data Siswa' : 'Simpan Data Siswa' }}
                                        </button>
                                        @if ($isEditing('siswa'))
                                            <a href="{{ route('admin.forms.index', ['section' => 'siswa']) }}#siswa"
                                                class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">
                                                Batal Edit
                                            </a>
                                        @endif
                                    </div>
                                </form>
                                @include('admin.partials.entity-table', [
                                    'entity' => 'siswa',
                                    'title' => 'Data Siswa',
                                ])
                            @endif
                        </div>
                    </section>

                    <section id="achievement" x-show="activeForm === 'achievement'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'achievement'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">achievement</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Prestasi</h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'achievement'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('achievement')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('achievement')->first() }}
                                </div>
                            @endif
                            @if ($kelompokKelas->isEmpty())
                                <div
                                    class="rounded-2xl border border-yellow-400/20 bg-yellow-500/10 px-4 py-3 text-sm text-yellow-100">
                                    Tambahkan data `kelompok_kelas` terlebih dahulu sebelum input prestasi.
                                </div>
                            @else
                                <form method="POST" action="{{ $formAction('achievement') }}"
                                    enctype="multipart/form-data"
                                    class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                    @csrf
                                    @if ($isEditing('achievement'))
                                        @method('PUT')
                                    @endif
                                    <input type="hidden" name="entity_key" value="achievement">
                                    <div class="xl:col-span-2">
                                        <label class="mb-2 block text-sm text-white/70">Kelompok kelas</label>
                                        <select name="id_kelompok_kelas"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach ($kelompokKelas as $kelompok)
                                                <option value="{{ $kelompok->id }}" @selected($formValue('achievement', 'id_kelompok_kelas') == $kelompok->id)>
                                                    {{ $kelompok->nama_kelompok }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Judul</label><input type="text"
                                            name="judul" value="{{ $formValue('achievement', 'judul') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Tropi</label><select
                                            name="tropi"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            <option value="regional" @selected($formValue('achievement', 'tropi') === 'regional')>Regional</option>
                                            <option value="nasional" @selected($formValue('achievement', 'tropi') === 'nasional')>Nasional</option>
                                            <option value="internasional" @selected($formValue('achievement', 'tropi') === 'internasional')>Internasional
                                            </option>
                                        </select></div>
                                    @include('admin.partials.media-input', [
                                        'name' => 'gambar',
                                        'label' => 'Gambar',
                                        'accept' => '.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('achievement')
                                            ? data_get($editingRecord, 'gambar')
                                            : null,
                                        'previewKind' => 'image',
                                        'help' => 'Preview gambar membuat data prestasi lebih cepat divalidasi.',
                                    ])
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Deskripsi</label>
                                        <textarea name="deskripsi" rows="4"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">{{ $formValue('achievement', 'deskripsi') }}</textarea>
                                    </div>
                                    <div class="xl:col-span-2"><button type="submit"
                                            class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">{{ $isEditing('achievement') ? 'Update Prestasi' : 'Simpan Prestasi' }}</button>
                                        @if ($isEditing('achievement'))
                                            <a href="{{ route('admin.forms.index', ['section' => 'achievement']) }}#achievement"
                                                class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">Batal
                                                Edit</a>
                                        @endif
                                    </div>
                                </form>
                                @include('admin.partials.entity-table', [
                                    'entity' => 'achievement',
                                    'title' => 'Prestasi',
                                ])
                            @endif
                        </div>
                    </section>

                    <section id="agenda" x-show="activeForm === 'agenda'" x-cloak x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'agenda'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">agenda</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Agenda</h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'agenda'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('agenda')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('agenda')->first() }}
                                </div>
                            @endif
                            @if ($kelompokKelas->isEmpty())
                                <div
                                    class="rounded-2xl border border-yellow-400/20 bg-yellow-500/10 px-4 py-3 text-sm text-yellow-100">
                                    Tambahkan data `kelompok_kelas` terlebih dahulu sebelum input agenda.
                                </div>
                            @else
                                <form method="POST" action="{{ $formAction('agenda') }}"
                                    class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                    @csrf
                                    @if ($isEditing('agenda'))
                                        @method('PUT')
                                    @endif
                                    <input type="hidden" name="entity_key" value="agenda">
                                    <div class="xl:col-span-2"><label class="mb-2 block text-sm text-white/70">Kelompok
                                            kelas</label><select name="id_kelompok_kelas"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach ($kelompokKelas as $kelompok)
                                                <option value="{{ $kelompok->id }}" @selected($formValue('agenda', 'id_kelompok_kelas') == $kelompok->id)>
                                                    {{ $kelompok->nama_kelompok }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Judul</label><input type="text"
                                            name="judul" value="{{ $formValue('agenda', 'judul') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Tanggal</label><input
                                            type="date" name="tanggal" value="{{ $formValue('agenda', 'tanggal') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Lokasi</label><input
                                            type="text" name="lokasi" value="{{ $formValue('agenda', 'lokasi') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Jam mulai</label><input
                                            type="time" name="jam_mulai"
                                            value="{{ $formValue('agenda', 'jam_mulai') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Jam selesai</label><input
                                            type="time" name="jam_selesai"
                                            value="{{ $formValue('agenda', 'jam_selesai') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Deskripsi</label>
                                        <textarea name="deskripsi" rows="4"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">{{ $formValue('agenda', 'deskripsi') }}</textarea>
                                    </div>
                                    <div class="xl:col-span-2"><button type="submit"
                                            class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">{{ $isEditing('agenda') ? 'Update Agenda' : 'Simpan Agenda' }}</button>
                                        @if ($isEditing('agenda'))
                                            <a href="{{ route('admin.forms.index', ['section' => 'agenda']) }}#agenda"
                                                class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">Batal
                                                Edit</a>
                                        @endif
                                    </div>
                                </form>
                                @include('admin.partials.entity-table', [
                                    'entity' => 'agenda',
                                    'title' => 'Agenda',
                                ])
                            @endif
                        </div>
                    </section>

                    <section id="jadwal-latihan" x-show="activeForm === 'jadwal-latihan'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'jadwal-latihan'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">jadwal_latihan</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Jadwal
                                    Latihan
                                </h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'jadwal-latihan'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('jadwal-latihan')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('jadwal-latihan')->first() }}
                                </div>
                            @endif
                            @if ($kelompokKelas->isEmpty())
                                <div
                                    class="rounded-2xl border border-yellow-400/20 bg-yellow-500/10 px-4 py-3 text-sm text-yellow-100">
                                    Tambahkan data `kelompok_kelas` terlebih dahulu sebelum input jadwal latihan.
                                </div>
                            @else
                                <form method="POST" action="{{ $formAction('jadwal-latihan') }}"
                                    class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                    @csrf
                                    @if ($isEditing('jadwal-latihan'))
                                        @method('PUT')
                                    @endif
                                    <input type="hidden" name="entity_key" value="jadwal-latihan">
                                    <div class="xl:col-span-2"><label class="mb-2 block text-sm text-white/70">Kelompok
                                            kelas</label><select name="id_kelompok_kelas"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach ($kelompokKelas as $kelompok)
                                                <option value="{{ $kelompok->id }}" @selected($formValue('jadwal-latihan', 'id_kelompok_kelas') == $kelompok->id)>
                                                    {{ $kelompok->nama_kelompok }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Judul</label><input type="text"
                                            name="judul" value="{{ $formValue('jadwal-latihan', 'judul') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Tanggal</label><input
                                            type="date" name="tanggal"
                                            value="{{ $formValue('jadwal-latihan', 'tanggal') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Lokasi</label><input
                                            type="text" name="lokasi"
                                            value="{{ $formValue('jadwal-latihan', 'lokasi') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Jam mulai</label><input
                                            type="time" name="jam_mulai"
                                            value="{{ $formValue('jadwal-latihan', 'jam_mulai') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Jam selesai</label><input
                                            type="time" name="jam_selesai"
                                            value="{{ $formValue('jadwal-latihan', 'jam_selesai') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Deskripsi</label>
                                        <textarea name="deskripsi" rows="4"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">{{ $formValue('jadwal-latihan', 'deskripsi') }}</textarea>
                                    </div>
                                    <div class="xl:col-span-2"><button type="submit"
                                            class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">{{ $isEditing('jadwal-latihan') ? 'Update Jadwal Latihan' : 'Simpan Jadwal Latihan' }}</button>
                                        @if ($isEditing('jadwal-latihan'))
                                            <a href="{{ route('admin.forms.index', ['section' => 'jadwal-latihan']) }}#jadwal-latihan"
                                                class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">Batal
                                                Edit</a>
                                        @endif
                                    </div>
                                </form>
                                @include('admin.partials.entity-table', [
                                    'entity' => 'jadwal-latihan',
                                    'title' => 'Jadwal Latihan',
                                ])
                            @endif
                        </div>
                    </section>

                    <section id="tournament" x-show="activeForm === 'tournament'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'tournament'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">tournament</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Turnamen</h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'tournament'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('tournament')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('tournament')->first() }}
                                </div>
                            @endif
                            @if ($kelompokKelas->isEmpty())
                                <div
                                    class="rounded-2xl border border-yellow-400/20 bg-yellow-500/10 px-4 py-3 text-sm text-yellow-100">
                                    Tambahkan data `kelompok_kelas` terlebih dahulu sebelum input turnamen.
                                </div>
                            @else
                                <form method="POST" action="{{ $formAction('tournament') }}"
                                    class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                    @csrf
                                    @if ($isEditing('tournament'))
                                        @method('PUT')
                                    @endif
                                    <input type="hidden" name="entity_key" value="tournament">
                                    <div class="xl:col-span-2"><label class="mb-2 block text-sm text-white/70">Kelompok
                                            kelas</label><select name="id_kelompok_kelas"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach ($kelompokKelas as $kelompok)
                                                <option value="{{ $kelompok->id }}" @selected($formValue('tournament', 'id_kelompok_kelas') == $kelompok->id)>
                                                    {{ $kelompok->nama_kelompok }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Judul</label><input type="text"
                                            name="judul" value="{{ $formValue('tournament', 'judul') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Tanggal</label><input
                                            type="date" name="tanggal"
                                            value="{{ $formValue('tournament', 'tanggal') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Lokasi</label><input
                                            type="text" name="lokasi"
                                            value="{{ $formValue('tournament', 'lokasi') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Jam mulai</label><input
                                            type="time" name="jam_mulai"
                                            value="{{ $formValue('tournament', 'jam_mulai') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div><label class="mb-2 block text-sm text-white/70">Jam selesai</label><input
                                            type="time" name="jam_selesai"
                                            value="{{ $formValue('tournament', 'jam_selesai') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required></div>
                                    <div class="xl:col-span-2"><label
                                            class="mb-2 block text-sm text-white/70">Deskripsi</label>
                                        <textarea name="deskripsi" rows="4"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">{{ $formValue('tournament', 'deskripsi') }}</textarea>
                                    </div>
                                    <div class="xl:col-span-2"><button type="submit"
                                            class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">{{ $isEditing('tournament') ? 'Update Turnamen' : 'Simpan Turnamen' }}</button>
                                        @if ($isEditing('tournament'))
                                            <a href="{{ route('admin.forms.index', ['section' => 'tournament']) }}#tournament"
                                                class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">Batal
                                                Edit</a>
                                        @endif
                                    </div>
                                </form>
                                @include('admin.partials.entity-table', [
                                    'entity' => 'tournament',
                                    'title' => 'Turnamen',
                                ])
                            @endif
                        </div>
                    </section>

                    <section id="daftar-reguler" x-show="activeForm === 'daftar-reguler'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'daftar-reguler'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">daftar_reguler</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Pendaftaran
                                    Reguler</h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'daftar-reguler'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('daftar-reguler')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('daftar-reguler')->first() }}
                                </div>
                            @endif
                            <form method="POST" action="{{ $formAction('daftar-reguler') }}"
                                class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                @csrf
                                @if ($isEditing('daftar-reguler'))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="entity_key" value="daftar-reguler">
                                <div class="xl:col-span-2">
                                    <h4
                                        class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                        Data Calon Siswa</h4>
                                </div>
                                <div class="xl:col-span-2">
                                    <label class="mb-2 block text-sm text-white/70">Nama lengkap</label>
                                    <input type="text" name="nama_lengkap"
                                        value="{{ $formValue('daftar-reguler', 'nama_lengkap') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Kelompok kelas</label>
                                    <select name="id_kelompok_kelas"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                        @foreach ($kelompokKelas as $kelompok)
                                            <option value="{{ $kelompok->id }}" @selected($formValue('daftar-reguler', 'id_kelompok_kelas') == $kelompok->id)>
                                                {{ $kelompok->nama_kelompok }} ({{ $kelompok->dari_tahun_kelahiran }} -
                                                {{ $kelompok->sampai_tahun_kelahiran }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Asal sekolah</label>
                                    <input type="text" name="asal_sekolah"
                                        value="{{ $formValue('daftar-reguler', 'asal_sekolah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Tempat lahir</label>
                                    <input type="text" name="tempat_lahir"
                                        value="{{ $formValue('daftar-reguler', 'tempat_lahir') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Tanggal lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ $formValue('daftar-reguler', 'tanggal_lahir') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Jenis kelamin</label>
                                    <select name="jenis_kelamin"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                        <option value="L" @selected($formValue('daftar-reguler', 'jenis_kelamin') === 'L')>Laki-laki</option>
                                        <option value="P" @selected($formValue('daftar-reguler', 'jenis_kelamin') === 'P')>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nomor HP</label>
                                    <input type="text" name="nomor_hp"
                                        value="{{ $formValue('daftar-reguler', 'nomor_hp') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div class="xl:col-span-2">
                                    <label class="mb-2 block text-sm text-white/70">Alamat</label>
                                    <textarea name="alamat" rows="3"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>{{ $formValue('daftar-reguler', 'alamat') }}</textarea>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Email Pendaftaran</label>
                                    <input type="email" name="email"
                                        value="{{ $formValue('daftar-reguler', 'email') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Status pendaftaran</label>
                                    <select name="status_pendaftaran"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                        <option value="pending" @selected($formValue('daftar-reguler', 'status_pendaftaran') === 'pending')>Pending</option>
                                        <option value="diterima" @selected($formValue('daftar-reguler', 'status_pendaftaran') === 'diterima')>Diterima</option>
                                        <option value="ditolak" @selected($formValue('daftar-reguler', 'status_pendaftaran') === 'ditolak')>Ditolak</option>
                                    </select>
                                </div>

                                <div class="xl:col-span-2 border-t border-white/10 pt-4 mt-2">
                                    <h4
                                        class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                        Data Orang Tua</h4>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nama Ayah</label>
                                    <input type="text" name="nama_ayah"
                                        value="{{ $formValue('daftar-reguler', 'nama_ayah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah"
                                        value="{{ $formValue('daftar-reguler', 'pekerjaan_ayah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nomor HP Ayah</label>
                                    <input type="text" name="nomor_hp_ayah"
                                        value="{{ $formValue('daftar-reguler', 'nomor_hp_ayah') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div class="hidden sm:block"></div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nama Ibu</label>
                                    <input type="text" name="nama_ibu"
                                        value="{{ $formValue('daftar-reguler', 'nama_ibu') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu"
                                        value="{{ $formValue('daftar-reguler', 'pekerjaan_ibu') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Nomor HP Ibu</label>
                                    <input type="text" name="nomor_hp_ibu"
                                        value="{{ $formValue('daftar-reguler', 'nomor_hp_ibu') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                        required>
                                </div>
                                <div class="hidden sm:block"></div>

                                <div class="xl:col-span-2 border-t border-white/10 pt-4 mt-2">
                                    <h4
                                        class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                        Akun Login & Kredensial</h4>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Email Orang Tua</label>
                                    <input type="email" name="email_ortu"
                                        value="{{ $formValue('daftar-reguler', 'email_ortu') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Password Orang Tua</label>
                                    <input type="password" name="password_ortu" placeholder="Kosongkan jika tidak diubah"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Email Siswa</label>
                                    <input type="email" name="email_siswa"
                                        value="{{ $formValue('daftar-reguler', 'email_siswa') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm text-white/70">Password Siswa</label>
                                    <input type="password" name="password_siswa"
                                        placeholder="Kosongkan jika tidak diubah"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                </div>

                                <div class="xl:col-span-2 border-t border-white/10 pt-4 mt-2">
                                    <h4
                                        class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                        Unggah Dokumen</h4>
                                </div>
                                @include('admin.partials.media-input', [
                                    'name' => 'upload_akte',
                                    'label' => 'Upload akte',
                                    'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                    'existingPath' => $isEditing('daftar-reguler')
                                        ? data_get($editingRecord, 'upload_akte')
                                        : null,
                                    'previewKind' => 'file',
                                    'help' => 'Preview aktif untuk scan Akte Kelahiran.',
                                ])
                                @include('admin.partials.media-input', [
                                    'name' => 'upload_kk',
                                    'label' => 'Upload KK',
                                    'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                    'existingPath' => $isEditing('daftar-reguler')
                                        ? data_get($editingRecord, 'upload_kk')
                                        : null,
                                    'previewKind' => 'file',
                                    'help' => 'Preview aktif untuk scan Kartu Keluarga.',
                                ])
                                <div class="xl:col-span-2"><button type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">{{ $isEditing('daftar-reguler') ? 'Update Pendaftaran Reguler' : 'Simpan Pendaftaran Reguler' }}</button>
                                    @if ($isEditing('daftar-reguler'))
                                        <a href="{{ route('admin.forms.index', ['section' => 'daftar-reguler']) }}#daftar-reguler"
                                            class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">Batal
                                            Edit</a>
                                    @endif
                                </div>
                            </form>
                            @include('admin.partials.entity-table', [
                                'entity' => 'daftar-reguler',
                                'title' => 'Pendaftaran Reguler',
                            ])
                        </div>
                    </section>

                    <section id="daftar-beasiswa" x-show="activeForm === 'daftar-beasiswa'" x-cloak
                        x-transition.opacity.duration.200ms
                        class="admin-module-shell rounded-[26px] border border-white/10 bg-white/[0.03]">
                        <button type="button" @click="activeForm = 'daftar-beasiswa'"
                            class="flex w-full items-center justify-between px-5 py-5 text-left md:px-6">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.24em] text-[#ffcf97]/80">daftar_beasiswa</p>
                                <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Form Pendaftaran
                                    Beasiswa</h2>
                            </div>
                            <span class="admin-module-badge">Modul Aktif</span>
                        </button>
                        <div x-show="activeForm === 'daftar-beasiswa'"
                            class="admin-form-layout border-t border-white/10 px-5 py-5 md:px-6">
                            @if ($errors->getBag('daftar-beasiswa')->any())
                                <div
                                    class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                    {{ $errors->getBag('daftar-beasiswa')->first() }}
                                </div>
                            @endif
                            @if ($jenisBeasiswa->isEmpty())
                                <div
                                    class="rounded-2xl border border-yellow-400/20 bg-yellow-500/10 px-4 py-3 text-sm text-yellow-100">
                                    Tambahkan data `jenis_beasiswa` terlebih dahulu sebelum input pendaftaran beasiswa.
                                </div>
                            @else
                                <form method="POST" action="{{ $formAction('daftar-beasiswa') }}"
                                    enctype="multipart/form-data"
                                    class="admin-form-card grid gap-4 grid-cols-1 xl:grid-cols-2">
                                    @csrf
                                    @if ($isEditing('daftar-beasiswa'))
                                        @method('PUT')
                                    @endif
                                    <input type="hidden" name="entity_key" value="daftar-beasiswa">
                                    <div class="xl:col-span-2">
                                        <label class="mb-2 block text-sm text-white/70">Jenis beasiswa</label>
                                        <select name="id_jenis_beasiswa"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach ($jenisBeasiswa as $jenis)
                                                <option value="{{ $jenis->id }}" @selected($formValue('daftar-beasiswa', 'id_jenis_beasiswa') == $jenis->id)>
                                                    {{ $jenis->nama_beasiswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <h4
                                            class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                            Data Calon Siswa</h4>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <label class="mb-2 block text-sm text-white/70">Nama lengkap</label>
                                        <input type="text" name="nama_lengkap"
                                            value="{{ $formValue('daftar-beasiswa', 'nama_lengkap') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Kelompok kelas</label>
                                        <select name="id_kelompok_kelas"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            @foreach ($kelompokKelas as $kelompok)
                                                <option value="{{ $kelompok->id }}" @selected($formValue('daftar-beasiswa', 'id_kelompok_kelas') == $kelompok->id)>
                                                    {{ $kelompok->nama_kelompok }}
                                                    ({{ $kelompok->dari_tahun_kelahiran }} -
                                                    {{ $kelompok->sampai_tahun_kelahiran }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Asal sekolah</label>
                                        <input type="text" name="asal_sekolah"
                                            value="{{ $formValue('daftar-beasiswa', 'asal_sekolah') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Tempat lahir</label>
                                        <input type="text" name="tempat_lahir"
                                            value="{{ $formValue('daftar-beasiswa', 'tempat_lahir') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Tanggal lahir</label>
                                        <input type="date" name="tanggal_lahir"
                                            value="{{ $formValue('daftar-beasiswa', 'tanggal_lahir') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Jenis kelamin</label>
                                        <select name="jenis_kelamin"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            <option value="L" @selected($formValue('daftar-beasiswa', 'jenis_kelamin') === 'L')>Laki-laki</option>
                                            <option value="P" @selected($formValue('daftar-beasiswa', 'jenis_kelamin') === 'P')>Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Nomor HP</label>
                                        <input type="text" name="nomor_hp"
                                            value="{{ $formValue('daftar-beasiswa', 'nomor_hp') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <label class="mb-2 block text-sm text-white/70">Alamat</label>
                                        <textarea name="alamat" rows="3"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>{{ $formValue('daftar-beasiswa', 'alamat') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Email Pendaftaran</label>
                                        <input type="email" name="email"
                                            value="{{ $formValue('daftar-beasiswa', 'email') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Status pendaftaran</label>
                                        <select name="status_pendaftaran"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                            <option value="pending" @selected($formValue('daftar-beasiswa', 'status_pendaftaran') === 'pending')>Pending</option>
                                            <option value="diterima" @selected($formValue('daftar-beasiswa', 'status_pendaftaran') === 'diterima')>Diterima</option>
                                            <option value="ditolak" @selected($formValue('daftar-beasiswa', 'status_pendaftaran') === 'ditolak')>Ditolak</option>
                                        </select>
                                    </div>

                                    <div class="xl:col-span-2 border-t border-white/10 pt-4 mt-2">
                                        <h4
                                            class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                            Data Orang Tua</h4>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Nama Ayah</label>
                                        <input type="text" name="nama_ayah"
                                            value="{{ $formValue('daftar-beasiswa', 'nama_ayah') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Pekerjaan Ayah</label>
                                        <input type="text" name="pekerjaan_ayah"
                                            value="{{ $formValue('daftar-beasiswa', 'pekerjaan_ayah') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Nomor HP Ayah</label>
                                        <input type="text" name="nomor_hp_ayah"
                                            value="{{ $formValue('daftar-beasiswa', 'nomor_hp_ayah') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div class="hidden sm:block"></div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Nama Ibu</label>
                                        <input type="text" name="nama_ibu"
                                            value="{{ $formValue('daftar-beasiswa', 'nama_ibu') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Pekerjaan Ibu</label>
                                        <input type="text" name="pekerjaan_ibu"
                                            value="{{ $formValue('daftar-beasiswa', 'pekerjaan_ibu') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Nomor HP Ibu</label>
                                        <input type="text" name="nomor_hp_ibu"
                                            value="{{ $formValue('daftar-beasiswa', 'nomor_hp_ibu') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40"
                                            required>
                                    </div>
                                    <div class="hidden sm:block"></div>

                                    <div class="xl:col-span-2 border-t border-white/10 pt-4 mt-2">
                                        <h4
                                            class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                            Akun Login & Kredensial</h4>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Email Orang Tua</label>
                                        <input type="email" name="email_ortu"
                                            value="{{ $formValue('daftar-beasiswa', 'email_ortu') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Password Orang Tua</label>
                                        <input type="password" name="password_ortu"
                                            placeholder="Kosongkan jika tidak diubah"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Email Siswa</label>
                                        <input type="email" name="email_siswa"
                                            value="{{ $formValue('daftar-beasiswa', 'email_siswa') }}"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-white/70">Password Siswa</label>
                                        <input type="password" name="password_siswa"
                                            placeholder="Kosongkan jika tidak diubah"
                                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-orange-300/40">
                                    </div>

                                    <div class="xl:col-span-2 border-t border-white/10 pt-4 mt-2">
                                        <h4
                                            class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wider text-[#ffcf97]">
                                            Unggah Dokumen Prestasi</h4>
                                    </div>
                                    @include('admin.partials.media-input', [
                                        'name' => 'sertifikat_1',
                                        'label' => 'Sertifikat 1',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('daftar-beasiswa')
                                            ? data_get($editingRecord, 'sertifikat_1')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' =>
                                            'Lampiran pertama bisa dilihat dulu tanpa membuka file terpisah.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'sertifikat_2',
                                        'label' => 'Sertifikat 2',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('daftar-beasiswa')
                                            ? data_get($editingRecord, 'sertifikat_2')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'Lampiran kedua tampil dengan preview yang konsisten.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'sertifikat_3',
                                        'label' => 'Sertifikat 3',
                                        'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                                        'existingPath' => $isEditing('daftar-beasiswa')
                                            ? data_get($editingRecord, 'sertifikat_3')
                                            : null,
                                        'previewKind' => 'file',
                                        'help' => 'Lampiran ketiga tetap tampil rapi di layout mobile.',
                                    ])
                                    @include('admin.partials.media-input', [
                                        'name' => 'video',
                                        'label' => 'Video',
                                        'accept' => '.mp4,.mov,.avi,.webm,.mkv',
                                        'existingPath' => $isEditing('daftar-beasiswa')
                                            ? data_get($editingRecord, 'video')
                                            : null,
                                        'previewKind' => 'video',
                                        'help' => 'Video dapat diputar langsung di dalam form.',
                                    ])
                                    <div class="xl:col-span-2"><button type="submit"
                                            class="rounded-full bg-[linear-gradient(90deg,#ff8a1f_0%,#f97316_100%)] px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em]">{{ $isEditing('daftar-beasiswa') ? 'Update Pendaftaran Beasiswa' : 'Simpan Pendaftaran Beasiswa' }}</button>
                                        @if ($isEditing('daftar-beasiswa'))
                                            <a href="{{ route('admin.forms.index', ['section' => 'daftar-beasiswa']) }}#daftar-beasiswa"
                                                class="ml-2 inline-flex rounded-full border border-white/15 px-5 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white/70 transition hover:text-white">Batal
                                                Edit</a>
                                        @endif
                                    </div>
                                </form>
                                @include('admin.partials.entity-table', [
                                    'entity' => 'daftar-beasiswa',
                                    'title' => 'Pendaftaran Beasiswa',
                                ])
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection
