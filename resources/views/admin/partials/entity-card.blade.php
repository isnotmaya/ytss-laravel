<div class="grid gap-3">
    <template x-if="filteredRecords.length === 0">
        <div class="rounded-[22px] border border-white/10 bg-black/10 px-4 py-6 text-center text-white/45">
            Tidak ada data yang cocok dengan filter saat ini.
        </div>
    </template>

    <template x-for="record in paginatedRecords" :key="'mobile-' + record.id">
        <div class="rounded-[24px] border border-white/10 bg-white/[0.02] p-5 shadow-[0_12px_30px_rgba(0,0,0,0.25)] backdrop-blur-md transition hover:border-white/15">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-orange-500/90">ID RECORD</span>
                    <h4 class="font-['Barlow_Condensed'] text-xl font-black uppercase text-white">
                        #<span x-text="record.id"></span>
                    </h4>
                </div>
                <!-- Status badge if statusField exists -->
                <template x-if="statusField && record[statusField]">
                    <span :class="statusBadgeClass(record[statusField])"
                        class="rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider"
                        x-text="formatValue(statusField, record[statusField])">
                    </span>
                </template>
            </div>

            <!-- Primary columns display -->
            <div class="mt-4 grid gap-3 sm:grid-cols-2 border-t border-white/5 pt-3">
                @foreach ($primaryColumns as $field => $label)
                    <div class="flex flex-col">
                        <span class="text-[10px] font-semibold uppercase tracking-wider text-white/40">{{ $label }}</span>
                        <!-- Render status as badge if this field is statusField -->
                        @if (in_array($field, ['status', 'status_aktif', 'status_pendaftaran', 'status_label', 'status_aktif_label', 'status_pendaftaran_label']))
                            <div class="mt-1">
                                <span :class="statusBadgeClass(record['{{ $field }}'])"
                                    class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider"
                                    x-text="formatValue('{{ $field }}', record['{{ $field }}'])">
                                </span>
                            </div>
                        @else
                            <span class="mt-0.5 text-sm text-white/85" x-text="formatValue('{{ $field }}', record['{{ $field }}'])"></span>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-5 flex flex-wrap items-center justify-between gap-2 border-t border-white/5 pt-4">
                <!-- Detail button -->
                <button type="button" @click="selectedRecord = record; showDetailModal = true"
                    class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/[0.04] px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-white/85 transition hover:border-orange-500/30 hover:text-white">
                    <i class="fa-solid fa-circle-info text-xs"></i> Detail
                </button>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <template x-if="!record.deleted_at">
                        <div class="flex flex-wrap gap-2 items-center">
                            @if($entity === 'daftar-reguler')
                                <template x-if="record.status_pendaftaran === 'pending'">
                                    <div class="flex gap-1.5">
                                        <form method="POST" :action="'{{ route('admin.forms.daftar-reguler.approve', ['id' => '__ID__']) }}'.replace('__ID__', record.id)" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/25 bg-emerald-500/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.12em] text-emerald-400 transition hover:border-emerald-500/50 hover:bg-emerald-500/20">
                                                <i class="fa-solid fa-check text-[10px]"></i> Terima
                                            </button>
                                        </form>
                                        <form method="POST" :action="'{{ route('admin.forms.daftar-reguler.reject', ['id' => '__ID__']) }}'.replace('__ID__', record.id)" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-full border border-red-500/25 bg-red-500/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.12em] text-red-400 transition hover:border-red-500/50 hover:bg-red-500/20">
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
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/25 bg-emerald-500/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.12em] text-emerald-400 transition hover:border-emerald-500/50 hover:bg-emerald-500/20">
                                                <i class="fa-solid fa-check text-[10px]"></i> Terima
                                            </button>
                                        </form>
                                        <form method="POST" :action="'{{ route('admin.forms.daftar-beasiswa.reject', ['id' => '__ID__']) }}'.replace('__ID__', record.id)" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-full border border-red-500/25 bg-red-500/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.12em] text-red-400 transition hover:border-red-500/50 hover:bg-red-500/20">
                                                <i class="fa-solid fa-xmark text-[10px]"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </template>
                            @endif
                            <a :href="'{{ route('admin.forms.index') }}?section={{ $entity }}&edit_entity={{ $entity }}&edit_id=' + record.id + '#{{ $entity }}'"
                                class="inline-flex items-center gap-1.5 rounded-full border border-orange-300/30 bg-orange-500/10 px-3.5 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-[#ffcf97] transition hover:border-orange-300/60 hover:bg-orange-500/20">
                                <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                            </a>
                            <form method="POST"
                                :action="'{{ route('admin.forms.destroy', ['entity' => $entity, 'id' => '__ID__']) }}'.replace('__ID__', record.id)"
                                onsubmit="return confirm('Hapus data ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-full border border-red-400/25 bg-red-500/10 px-3.5 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-red-200 transition hover:border-red-400/50 hover:bg-red-500/20">
                                    <i class="fa-solid fa-trash text-xs"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </template>

                    <!-- Restore/Force Delete for Trashed Records -->
                    <template x-if="record.deleted_at">
                        <div class="flex gap-2">
                            <button type="button" @click="alert('Fitur Restore akan aktif di Phase 3')"
                                class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/25 bg-emerald-500/10 px-3.5 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-emerald-400 transition hover:border-emerald-500/50 hover:bg-emerald-500/20">
                                <i class="fa-solid fa-rotate-left"></i> Restore
                            </button>
                            <button type="button" @click="alert('Fitur Force Delete akan aktif di Phase 3')"
                                class="inline-flex items-center gap-1.5 rounded-full border border-red-500/25 bg-red-500/10 px-3.5 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-red-400 transition hover:border-red-500/50 hover:bg-red-500/20">
                                <i class="fa-solid fa-trash-can"></i> Force
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>
