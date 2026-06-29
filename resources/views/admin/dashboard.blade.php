@extends('layouts.app')

@section('content')
    <main
        class="min-h-screen bg-[radial-gradient(circle_at_top,rgba(249,115,22,0.18),transparent_24%),linear-gradient(180deg,#090909_0%,#140d07_38%,#0a0a0a_100%)] text-white">
        <div class="mx-auto max-w-7xl px-4 py-6 md:px-8 lg:px-10">
            <header
                class="mb-8 overflow-hidden rounded-[28px] border border-white/10 bg-white/[0.04] shadow-[0_24px_80px_rgba(0,0,0,0.34)] backdrop-blur-xl">
                <div
                    class="relative border-b border-white/10 bg-[linear-gradient(135deg,rgba(249,115,22,0.22),rgba(255,255,255,0.02),rgba(217,138,58,0.12))] px-5 py-6 md:px-8 md:py-7">
                    <div class="absolute right-[-40px] top-[-30px] h-36 w-36 rounded-full bg-orange-400/20 blur-3xl">
                    </div>
                    <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-[#ffcf97]">Dashboard
                                Admin</p>
<div class="mt-3 inline-flex items-center gap-2 rounded-full border border-orange-300/20 bg-orange-500/10 px-3 py-1">
    <span class="h-2 w-2 rounded-full bg-green-400"></span>

    <span class="text-[10px] uppercase tracking-[0.18em] text-[#ffcf97]">
        Admin Online
    </span>

</div>

                            <h1
                                class="mt-3 font-['Barlow_Condensed'] text-4xl font-black uppercase tracking-[0.04em] text-white md:text-5xl">
                                Panel Manajemen Data
                            </h1>
                            <p class="mt-3 max-w-3xl text-sm leading-7 text-white/70 md:text-base">
                                Role <span class="font-semibold text-white">manajemen</span> sekarang diarahkan ke area
                                admin untuk memantau, mengelola, dan meninjau semua data yang diinput ke sistem.
                            </p>
                        </div>

                        <div class="flex flex-col gap-3 sm:w-auto sm:min-w-[240px]">

                            <a href="{{ route('admin.forms.index') }}"
                                class="group flex items-center justify-between rounded-2xl border border-orange-300/20 bg-orange-500/10 px-5 py-4 transition hover:border-orange-300/40 hover:bg-orange-500/15">

                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/50">
                                        Admin
                                    </p>

                                    <p class="text-sm font-semibold text-[#ffcf97]">
                                        Form Input
                                    </p>
                                </div>

                                <i data-lucide="layout-dashboard" class="h-5 w-5 text-[#ffcf97]"></i>
                            </a>

                            <div class="grid grid-cols-2 gap-2">

                                <a href="{{ url('/') }}"
                                    class="flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.04] py-3 text-xs font-semibold uppercase tracking-[0.15em] text-white/70 transition hover:bg-white/[0.08]">
                                    <i data-lucide="globe" class="h-4 w-4"></i>
                                    Website
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit"
                                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 py-3 text-xs font-semibold uppercase tracking-[0.15em] text-white">
                                        <i data-lucide="log-out" class="h-4 w-4"></i>
                                        Logout
                                    </button>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </header>

            <section class="mb-8">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#ffcf97]/80">Ringkasan</p>
                        <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Statistik Pengelolaan
                        </h2>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($summaryCards as $card)
                        <article
                            class="overflow-hidden rounded-[24px] border border-white/10 bg-[linear-gradient(180deg,rgba(255,255,255,0.04)_0%,rgba(255,255,255,0.02)_100%)]">
                            <div class="h-1.5 bg-gradient-to-r {{ $card['accent'] }}"></div>
                            <div class="p-5">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-white/50">
                                    {{ $card['label'] }}
                                </p>
                                <p class="mt-4 font-['Barlow_Condensed'] text-5xl font-black uppercase text-white">
                                    {{ $card['count'] }}
                                </p>
                                <p class="mt-3 text-sm leading-7 text-white/62">
                                    {{ $card['description'] }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="mb-8">
                <div class="mb-4">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#ffcf97]/80">Modul Admin</p>
                    <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Area Pengelolaan Data</h2>
                    <p class="mt-2 max-w-3xl text-sm leading-7 text-white/62">
                        Setiap kartu mewakili kelompok data yang menjadi tanggung jawab admin/manajemen di dalam dashboard.
                    </p>
                </div>

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($managementModules as $module)
                        <article
                            class="rounded-[24px] border border-white/10 bg-[linear-gradient(180deg,rgba(255,255,255,0.04)_0%,rgba(255,255,255,0.02)_100%)] p-5 transition hover:border-orange-300/35 hover:bg-white/[0.06]">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-[#ffcf97]/80">
                                        {{ $module['status'] }}
                                    </p>
                                    <h3 class="mt-2 font-['Barlow_Condensed'] text-2xl font-black uppercase text-white">
                                        {{ $module['title'] }}
                                    </h3>
                                </div>
                                <span
                                    class="inline-flex min-w-14 items-center justify-center rounded-full border border-white/10 bg-black/20 px-3 py-2 font-['Barlow_Condensed'] text-xl font-black text-white">
                                    {{ $module['count'] }}
                                </span>
                            </div>
                            <p class="mt-4 text-sm leading-7 text-white/62">
                                {{ $module['description'] }}
                            </p>
                            <div class="mt-4 rounded-2xl border border-dashed border-white/10 bg-black/10 px-4 py-3">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-white/38">
                                    Sumber data
                                </p>
                                <p class="mt-1 text-sm text-white/72">{{ $module['table'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.1fr_1.1fr_0.8fr]">
                <article class="rounded-[26px] border border-white/10 bg-white/[0.03] p-5">
                    <div class="mb-4">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#ffcf97]/80">Input Terbaru
                        </p>
                        <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Pendaftaran Reguler
                        </h2>
                    </div>

                    <div class="overflow-x-auto rounded-[20px] border border-white/10">
                        <table class="min-w-full divide-y divide-white/10 text-sm">
                            <thead class="bg-white/[0.04] text-left text-white/52">
                                <tr>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse ($recentRegularRegistrations as $item)
                                    <tr class="bg-black/10">
                                        <td class="px-4 py-3 font-medium text-white break-words">{{ $item->nama_lengkap }}
                                        </td>
                                        <td class="px-4 py-3 text-white/65 break-all">{{ $item->email }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="rounded-full border border-white/10 bg-white/[0.04] px-3 py-1 text-xs uppercase tracking-[0.16em] text-[#ffcf97]">
                                                {{ $item->status_pendaftaran }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-5 text-center text-white/45">
                                            Belum ada data pendaftaran reguler.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="rounded-[26px] border border-white/10 bg-white/[0.03] p-5">
                    <div class="mb-4">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#ffcf97]/80">Input Terbaru
                        </p>
                        <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Pendaftaran Beasiswa
                        </h2>
                    </div>

                    <div class="overflow-x-auto rounded-[20px] border border-white/10">
                        <table class="min-w-full divide-y divide-white/10 text-sm">
                            <thead class="bg-white/[0.04] text-left text-white/52">
                                <tr>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse ($recentScholarshipRegistrations as $item)
                                    <tr class="bg-black/10">
                                        <td class="px-4 py-3 font-medium text-white break-words">{{ $item->nama_lengkap }}
                                        </td>
                                        <td class="px-4 py-3 text-white/65 break-all">{{ $item->email }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="rounded-full border border-white/10 bg-white/[0.04] px-3 py-1 text-xs uppercase tracking-[0.16em] text-[#8be5ff]">
                                                {{ $item->status_pendaftaran }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-5 text-center text-white/45">
                                            Belum ada data pendaftaran beasiswa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="rounded-[26px] border border-white/10 bg-white/[0.03] p-5">
                    <div class="mb-4">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#ffcf97]/80">Update Konten
                        </p>
                        <h2 class="mt-2 font-['Barlow_Condensed'] text-3xl font-black uppercase">Aktivitas Terbaru</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="space-y-3">
                            @forelse ($recentContentUpdates as $item)
                                <article class="rounded-[20px] border border-white/10 bg-black/15 p-4">
                                    <p class="text-[11px] uppercase tracking-[0.22em] text-[#ffcf97]/75">
                                        {{ $item['type'] }}
                                    </p>
                                    <h3
                                        class="mt-2 font-['Barlow_Condensed'] text-sm font-bold uppercase tracking-wider text-white">
                                        {{ \Illuminate\Support\Str::limit($item['title'], 52) }}
                                    </h3>
                                    <p class="mt-2 text-xs text-white/45">
                                        {{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('d M Y H:i') }}
                                    </p>
                                </article>
                            @empty
                                <div
                                    class="rounded-[20px] border border-dashed border-white/10 bg-black/10 p-5 text-sm text-white/45">
                                    Belum ada aktivitas konten yang tercatat.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </article>
            </section>
        </div>
    </main>
@endsection
