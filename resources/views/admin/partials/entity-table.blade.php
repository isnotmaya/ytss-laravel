@php
    $records = $entityTables[$entity]['records'] ?? collect();
    $primaryColumns = $entityTables[$entity]['primaryColumns'] ?? [];
    $detailColumns = $entityTables[$entity]['detailColumns'] ?? [];

    // Fallback if primaryColumns is empty
    if (empty($primaryColumns)) {
        $excludedKeys = ['id', 'created_at', 'updated_at', 'deleted_at', 'password', 'remember_token'];
        $firstRecord = $records->first();
        if ($firstRecord) {
            $recordKeys = array_keys((array) $firstRecord);
            $fallbackKeys = [];
            foreach ($recordKeys as $k) {
                if (count($fallbackKeys) >= 4) {
                    break;
                }
                if (in_array($k, $excludedKeys)) {
                    continue;
                }
                $val = $firstRecord->$k ?? null;
                if ($val && is_string($val) && (strpos($val, 'uploads/') === 0 || str_starts_with($val, 'uploads/'))) {
                    continue;
                }
                if (strpos($k, '_label') !== false || strpos($k, 'ortu_') !== false || strpos($k, 'user_') !== false) {
                    continue;
                }
                $fallbackKeys[] = $k;
            }
            foreach ($fallbackKeys as $k) {
                $primaryColumns[$k] = ucwords(str_replace('_', ' ', $k));
            }
        }
    }

    $displayColumns = $primaryColumns + $detailColumns;
    $statusField = collect(array_keys($displayColumns))->first(
        fn($field) => in_array($field, [
            'status',
            'status_aktif',
            'status_pendaftaran',
            'status_label',
            'status_aktif_label',
            'status_pendaftaran_label',
        ]),
    );

    $hasSoftDelete = $entityTables[$entity]['hasSoftDelete'] ?? false;
@endphp

<div x-data="adminTableState(@js($records->values()), @js(array_keys($displayColumns)), @js($statusField), @js($hasSoftDelete))"
    class="rounded-[24px] border border-white/10 bg-[linear-gradient(180deg,rgba(255,255,255,0.035)_0%,rgba(255,255,255,0.015)_100%)] p-4 shadow-[inset_0_1px_0_rgba(255,255,255,0.02)] md:p-5">
    
    <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
        <div>
            <p class="text-[11px] uppercase tracking-[0.22em] text-[#ffcf97]/75">Data Tersimpan</p>
            <h3 class="mt-1 font-['Barlow_Condensed'] text-2xl font-black uppercase text-white">
                Kelola {{ $title }}
            </h3>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <!-- Trash Filter for Soft Deletes -->
            <template x-if="hasSoftDelete">
                <div class="flex items-center gap-1.5 rounded-full border border-white/10 bg-black/20 p-1">
                    <button type="button" @click="trashFilter = 'active'; refresh()"
                        :class="trashFilter === 'active' ? 'bg-orange-500 text-white' : 'text-white/60 hover:text-white'"
                        class="rounded-full px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider transition">
                        Aktif
                    </button>
                    <button type="button" @click="trashFilter = 'trash'; refresh()"
                        :class="trashFilter === 'trash' ? 'bg-orange-500 text-white' : 'text-white/60 hover:text-white'"
                        class="rounded-full px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider transition">
                        Trash
                    </button>
                    <button type="button" @click="trashFilter = 'all'; refresh()"
                        :class="trashFilter === 'all' ? 'bg-orange-500 text-white' : 'text-white/60 hover:text-white'"
                        class="rounded-full px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider transition">
                        Semua
                    </button>
                </div>
            </template>

            <span class="inline-flex w-fit rounded-full border border-white/10 bg-white/[0.04] px-3 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-white/70">
                <span x-text="filteredRecords.length"></span> data
            </span>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="mb-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_220px_140px]">
        <div>
            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/55">Pencarian</label>
            <input type="text" x-model.debounce.250ms="search" @input="refresh()"
                placeholder="Cari dari data {{ strtolower($title) }}..."
                class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-orange-300/45 focus:bg-black/30">
        </div>

        <div>
            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/55">Filter Status</label>
            @if ($statusField)
                <select x-model="status" @change="refresh()"
                    class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition focus:border-orange-300/45 focus:bg-black/30">
                    <option value="all">Semua status</option>
                    <template x-for="option in statusOptions" :key="option">
                        <option :value="String(option)" x-text="option"></option>
                    </template>
                </select>
            @else
                <div class="flex h-[52px] items-center rounded-2xl border border-dashed border-white/10 bg-black/10 px-4 text-sm text-white/35">
                    Tidak tersedia
                </div>
            @endif
        </div>

        <div>
            <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/55">Per Halaman</label>
            <select x-model.number="perPage" @change="refresh()"
                class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition focus:border-orange-300/45 focus:bg-black/30">
                <option value="5">5 data</option>
                <option value="10">10 data</option>
                <option value="20">20 data</option>
            </select>
        </div>
    </div>

    <!-- Mobile view: cards -->
    <div class="md:hidden">
        @include('admin.partials.entity-card')
    </div>

    <!-- Desktop view: tables -->
    <div class="hidden overflow-x-auto rounded-[18px] border border-white/10 md:block">
        <table class="min-w-[900px] w-full divide-y divide-white/10 text-sm">
            <thead class="bg-white/[0.04] text-left text-white/52">
                <tr>
                    @foreach ($primaryColumns as $label)
                        <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider">{{ $label }}</th>
                    @endforeach
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider text-center">Detail</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                <template x-if="paginatedRecords.length === 0">
                    <tr>
                        <td colspan="{{ count($primaryColumns) + 2 }}" class="px-5 py-8 text-center text-white/45">
                            Tidak ada data yang cocok dengan filter saat ini.
                        </td>
                    </tr>
                </template>

                <template x-for="record in paginatedRecords" :key="record.id">
                    <tr class="hover:bg-white/[0.02] transition" :class="record.deleted_at ? 'opacity-60 bg-red-950/5' : ''">
                        @foreach ($primaryColumns as $field => $label)
                            <td class="px-5 py-4 align-middle text-white/85">
                                @if (in_array($field, ['status', 'status_aktif', 'status_pendaftaran', 'status_label', 'status_aktif_label', 'status_pendaftaran_label']))
                                    <span :class="statusBadgeClass(record['{{ $field }}'])"
                                        class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider"
                                        x-text="formatValue('{{ $field }}', record['{{ $field }}'])">
                                    </span>
                                @else
                                    <span x-text="formatValue('{{ $field }}', record['{{ $field }}'])"></span>
                                @endif
                            </td>
                        @endforeach

                        <!-- Detail Button -->
                        <td class="px-5 py-4 align-middle text-center">
                            <button type="button" @click="selectedRecord = record; showDetailModal = true"
                                class="inline-flex items-center gap-1 rounded-lg border border-white/10 bg-white/[0.04] px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.12em] text-white/85 transition hover:border-orange-500/30 hover:text-white">
                                <i class="fa-solid fa-circle-info text-xs"></i>
                                Detail
                            </button>
                        </td>

                        <!-- Action Buttons -->
                        <td class="px-5 py-4 align-middle text-right">
                            <div class="flex gap-2 justify-end">
                                <template x-if="!record.deleted_at">
                                    <div class="flex gap-2">
                                        @if($entity === 'daftar-reguler')
                                            <template x-if="record.status_pendaftaran === 'pending'">
                                                <div class="flex gap-1.5">
                                                    <form method="POST" :action="'{{ route('admin.forms.daftar-reguler.approve', ['id' => '__ID__']) }}'.replace('__ID__', record.id)" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-emerald-400 transition hover:border-emerald-500/50 hover:bg-emerald-500/20">
                                                            <i class="fa-solid fa-check text-[10px]"></i> Terima
                                                        </button>
                                                    </form>
                                                    <form method="POST" :action="'{{ route('admin.forms.daftar-reguler.reject', ['id' => '__ID__']) }}'.replace('__ID__', record.id)" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-red-500/25 bg-red-500/10 px-2.5 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-red-400 transition hover:border-red-500/50 hover:bg-red-500/20">
                                                            <i class="fa-solid fa-xmark text-[10px]"></i> Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </template>
                                        @elseif($entity === 'daftar-beasiswa')
                                            <template x-if="record.status_pendaftaran === 'pending'">
                                                <div class="flex gap-1.5">
                                                    <form method="POST" :action="'{{ route('admin.forms.daftar-beasiswa.approve', ['id' => '__ID__']) }}'.replace('__ID__', record.id)" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-emerald-400 transition hover:border-emerald-500/50 hover:bg-emerald-500/20">
                                                            <i class="fa-solid fa-check text-[10px]"></i> Terima
                                                        </button>
                                                    </form>
                                                    <form method="POST" :action="'{{ route('admin.forms.daftar-beasiswa.reject', ['id' => '__ID__']) }}'.replace('__ID__', record.id)" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-red-500/25 bg-red-500/10 px-2.5 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-red-400 transition hover:border-red-500/50 hover:bg-red-500/20">
                                                            <i class="fa-solid fa-xmark text-[10px]"></i> Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </template>
                                        @endif
                                        <a :href="'{{ route('admin.forms.index') }}?section={{ $entity }}&edit_entity={{ $entity }}&edit_id=' + record.id + '#{{ $entity }}'"
                                            class="inline-flex items-center gap-1 rounded-lg border border-orange-300/30 bg-orange-500/10 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.12em] text-[#ffcf97] transition hover:border-orange-300/60 hover:bg-orange-500/20">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            Edit
                                        </a>

                                        <form method="POST"
                                            :action="'{{ route('admin.forms.destroy', ['entity' => $entity, 'id' => '__ID__']) }}'.replace('__ID__', record.id)"
                                            onsubmit="return confirm('Hapus data ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-red-400/25 bg-red-500/10 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.12em] text-red-200 transition hover:border-red-400/50 hover:bg-red-500/20">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </template>

                                <!-- Restore/Force Delete for Trashed Records -->
                                <template x-if="record.deleted_at">
                                    <div class="flex gap-2">
                                        <button type="button" @click="alert('Fitur Restore akan aktif di Phase 3')"
                                            class="inline-flex items-center gap-1 rounded-lg border border-emerald-500/25 bg-emerald-500/10 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.12em] text-emerald-400 transition hover:border-emerald-500/50 hover:bg-emerald-500/20">
                                            <i class="fa-solid fa-rotate-left"></i> Restore
                                        </button>
                                        <button type="button" @click="alert('Fitur Force Delete akan aktif di Phase 3')"
                                            class="inline-flex items-center gap-1 rounded-lg border border-red-500/25 bg-red-500/10 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.12em] text-red-200 transition hover:border-red-500/50 hover:bg-red-500/20">
                                            <i class="fa-solid fa-trash-can"></i> Force
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Pagination Section -->
    <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <p class="text-sm text-white/45">
            Menampilkan <span class="font-semibold text-white/75" x-text="paginatedRecords.length"></span> dari
            <span class="font-semibold text-white/75" x-text="filteredRecords.length"></span> data yang cocok.
        </p>

        <div class="flex items-center gap-2">
            <button type="button" @click="updatePage(page - 1)" :disabled="page === 1"
                class="rounded-full border border-white/10 bg-white/[0.04] px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-white/70 transition disabled:cursor-not-allowed disabled:opacity-40 hover:border-orange-300/30 hover:text-white">
                Prev
            </button>
            <div class="rounded-full border border-white/10 bg-black/20 px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-white/70">
                <span x-text="page"></span> / <span x-text="totalPages"></span>
            </div>
            <button type="button" @click="updatePage(page + 1)" :disabled="page >= totalPages"
                class="rounded-full border border-white/10 bg-white/[0.04] px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-white/70 transition disabled:cursor-not-allowed disabled:opacity-40 hover:border-orange-300/30 hover:text-white">
                Next
            </button>
        </div>
    </div>

    <!-- Include Detail Modal Inside Alpine Scope -->
    @include('admin.partials.detail-modal')

</div>
