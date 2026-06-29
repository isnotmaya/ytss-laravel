@php
    $existingPath = $existingPath ?? null;
    $previewKind = $previewKind ?? 'image';
    $help = $help ?? '';
    $valueName = $existingPath ? basename($existingPath) : '';
@endphp

<div x-data="{
    previewUrl: {{ $existingPath ? json_encode(asset($existingPath)) : 'null' }},
    previewKind: {{ json_encode($previewKind) }},
    fileName: {{ json_encode($valueName) }},
    onChange(event) {
        const file = event.target.files && event.target.files[0];
        if (!file) {
            this.previewUrl = {{ $existingPath ? json_encode(asset($existingPath)) : 'null' }};
            this.previewKind = {{ json_encode($previewKind) }};
            this.fileName = {{ json_encode($valueName) }};
            return;
        }

        this.fileName = file.name;
        const ext = file.name.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(ext)) {
            this.previewKind = 'image';
        } else if (['mp4', 'webm', 'mov', 'mkv', 'avi'].includes(ext)) {
            this.previewKind = 'video';
        } else {
            this.previewKind = 'file';
        }

        this.previewUrl = URL.createObjectURL(file);
    }
}">
    <label class="{{ $labelClass }}">{{ $label }}</label>
    <input type="file" name="{{ $name }}" accept="{{ $accept }}"
        @change="onChange($event)"
        class="{{ $fileClass }}">

    <div class="mt-3 rounded-[18px] border border-dashed border-white/10 bg-black/10 p-3">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[16px] border border-white/10 bg-white/[0.04] text-white/35">
                <template x-if="previewUrl && previewKind === 'image'">
                    <img :src="previewUrl" class="h-16 w-16 rounded-[16px] object-cover" alt="Preview">
                </template>
                <template x-if="previewUrl && previewKind === 'video'">
                    <i class="fa-solid fa-film text-lg"></i>
                </template>
                <template x-if="previewUrl && previewKind === 'file'">
                    <i class="fa-regular fa-file-lines text-lg"></i>
                </template>
                <template x-if="!previewUrl">
                    <i class="fa-regular fa-image text-lg"></i>
                </template>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-white/45">Preview Input</p>
                <p class="mt-1 truncate text-sm text-white/80" x-text="fileName || 'Belum ada file dipilih'"></p>
                <p class="mt-1 text-xs leading-6 text-white/38">
                    {{ $help }}
                </p>
            </div>
        </div>

        <template x-if="previewUrl && previewKind === 'image'">
            <a :href="previewUrl" target="_blank" class="mt-3 block">
                <img :src="previewUrl" alt="Preview"
                    class="max-h-56 w-full rounded-[16px] object-contain">
            </a>
        </template>

        <template x-if="previewUrl && previewKind === 'video'">
            <video :src="previewUrl" controls class="mt-3 max-h-56 w-full rounded-[16px] bg-black"></video>
        </template>

        <template x-if="previewUrl && previewKind === 'file'">
            <div class="mt-3 rounded-[16px] border border-white/10 bg-white/[0.04] px-4 py-3">
                <a :href="previewUrl" target="_blank" class="text-sm font-semibold text-[#ffcf97] hover:text-white">
                    Buka file yang dipilih
                </a>
            </div>
        </template>
    </div>
</div>
