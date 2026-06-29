<template x-if="record['{{ $field }}'] !== null && record['{{ $field }}'] !== undefined && String(record['{{ $field }}']).startsWith('uploads/')">
    <div class="space-y-2">
        <template x-if="['jpg','jpeg','png','webp','gif'].includes(String(record['{{ $field }}']).split('.').pop().toLowerCase())">
            <button type="button" @click="openPreview(record['{{ $field }}'], '{{ $label }}')"
                class="block text-left">
                <img :src="'/' + record['{{ $field }}']" alt="Preview"
                    class="h-24 w-36 rounded-[14px] border border-white/10 object-cover shadow-lg transition hover:scale-[1.02]">
            </button>
        </template>
        <template x-if="['mp4','webm','mov','mkv','avi'].includes(String(record['{{ $field }}']).split('.').pop().toLowerCase())">
            <button type="button" @click="openPreview(record['{{ $field }}'], '{{ $label }}')"
                class="block text-left">
                <video :src="'/' + record['{{ $field }}']" class="h-24 w-36 rounded-[14px] border border-white/10 bg-black object-cover shadow-lg"></video>
            </button>
        </template>
        <template x-if="!['jpg','jpeg','png','webp','gif','mp4','webm','mov','mkv','avi'].includes(String(record['{{ $field }}']).split('.').pop().toLowerCase())">
            <a :href="'/' + record['{{ $field }}']" target="_blank"
                class="inline-flex rounded-full border border-white/10 bg-white/[0.04] px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-[#ffcf97] transition hover:text-white">
                Buka File
            </a>
        </template>
        <p class="text-xs leading-5 text-white/42 break-all" x-text="record['{{ $field }}']"></p>
    </div>
</template>

<template x-if="!(record['{{ $field }}'] !== null && record['{{ $field }}'] !== undefined && String(record['{{ $field }}']).startsWith('uploads/'))">
    <span
        class="block whitespace-pre-wrap break-words text-sm leading-6 text-white/75"
        x-text="record['{{ $field }}'] ?? '-'">
    </span>
</template>