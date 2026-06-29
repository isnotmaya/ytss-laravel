@extends('layouts.app')

@section('seo_title', 'Profil YTSS Soccer School | Akademi Sepak Bola Anak Terbaik di Bogor')
@section('seo_description', 'Profil lengkap YTSS Soccer School Bogor. Visi, misi, dan nilai-nilai kami dalam pembinaan karakter serta keterampilan sepak bola anak usia dini.')
@section('seo_keywords', 'profil ytss soccer school, ssb bogor, sekolah sepak bola bogor, akademi sepak bola bogor, pembinaan sepak bola anak')

@section('content')
    @include('partials.sidebar')

    <main class="ml-0 md:ml-[96px]">

        @include('partials.navbar')
        @include('partials.mobile-menu')

        {{-- HERO SECTION --}}
        <section
            class="relative overflow-hidden bg-gradient-to-b from-black via-[#0a0a0a] to-black px-6 md:px-16 pt-24 pb-20">
            {{-- WATERMARK LOGO --}}
            <div
                class="hidden lg:block
               absolute
               right-[-80px]
               top-[-20px]
               z-0
               pointer-events-none">

                <img src="{{ asset('images/ytss_logo.png') }}" alt="Logo Watermark YTSS Soccer School - Sekolah Sepak Bola Bogor"
                    class="
            w-[520px]
            opacity-[0.06]
            logo-watermark">
            </div>
            {{-- Background Effects --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-500/20 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-20 -left-40 w-80 h-80 bg-orange-600/10 blur-3xl rounded-full"></div>

                <div class="absolute inset-0 opacity-[0.02]"
                    style="background-image:repeating-linear-gradient(-45deg,rgba(255,255,255,0.08)_0,rgba(255,255,255,0.08)_1px,transparent_1px,transparent_30px);">
                </div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto">

                {{-- Breadcrumb --}}
                <div class="flex items-center gap-2 mb-8">
                    <a href="{{ url('/') }}" class="text-white/40 hover:text-white/60 text-sm transition">
                        Home
                    </a>

                    <span class="text-white/20">/</span>

                    <span class="text-orange-400 text-sm font-semibold">
                        Profile Sekolah
                    </span>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    {{-- Left --}}
                    <div>

                        <div class="flex items-center gap-3 mb-4">

                            <i data-lucide="building-2" class="w-5 h-5 text-orange-400 float-icon">
                            </i>

                            <p class="uppercase font-bold tracking-[4px] text-orange-400 text-sm">

                                About YTSS Academy

                            </p>

                        </div>

                        <h1 class="text-5xl md:text-7xl font-black uppercase leading-[0.95] mb-6">
                            Shaping
                            <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                                Future
                            </span>
                            Champions
                        </h1>

                        <p class="text-lg text-white/60 leading-relaxed max-w-xl">
                            Mengenal lebih dekat YTSS Academy sebagai tempat pembinaan
                            sepak bola yang berfokus pada karakter, disiplin,
                            prestasi, dan pengembangan potensi atlet muda.
                        </p>

                    </div>

                    {{-- Right --}}
                    <div class="grid grid-cols-2 gap-5">
                        <div class="bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm">
                            <div
                                class="w-14 h-14
           rounded-2xl
           bg-orange-500/10
           border border-orange-500/20
           flex items-center justify-center
           mb-4
           group-hover:scale-110
           transition-all duration-500">

                                <i data-lucide="goal" class="w-7 h-7 text-orange-400 float-icon">
                                </i>

                            </div>

                            <p class="text-sm text-white/60">
                                Football Development
                            </p>
                        </div>

                        <div class="bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm">
                            <div
                                class="
w-14 h-14
rounded-2xl
bg-orange-500/10
border border-orange-500/20
flex items-center justify-center
mb-4">
                                <i data-lucide="trophy" class="w-7 h-7 text-orange-400 float-icon">
                                </i>
                            </div>

                            <p class="text-sm text-white/60">
                                Achievement Oriented
                            </p>
                        </div>

                        <div class="bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm">
                            <div
                                class="
w-14 h-14
rounded-2xl
bg-orange-500/10
border border-orange-500/20
flex items-center justify-center
mb-4">
                                <i data-lucide="flame" class="w-7 h-7 text-orange-400 float-icon">
                                </i>
                            </div>
                            <p class="text-sm text-white/60">
                                Character Building
                            </p>
                        </div>

                        <div class="bg-white/[0.05] border border-orange-500/20 rounded-2xl p-6 backdrop-blur-sm">
                            <div
                                class="
w-14 h-14
rounded-2xl
bg-orange-500/10
border border-orange-500/20
flex items-center justify-center
mb-4">
                                <i data-lucide="handshake" class="w-7 h-7 text-orange-400 float-icon">
                                </i>
                            </div>
                            <p class="text-sm text-white/60">
                                Teamwork Culture
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        {{-- PROFILE CONTENT --}}
        <section class="relative bg-black px-6 md:px-16 py-20">

            <div class="max-w-7xl mx-auto">

                <div class="grid lg:grid-cols-12 gap-10 items-start">

                    {{-- IMAGE --}}
                    <div class="lg:col-span-5">

                        <div
                            class="
sticky top-28
bg-white/[0.03]
border border-white/10
rounded-3xl
overflow-hidden

group

transition-all
duration-500

hover:border-orange-500/40
hover:shadow-[0_0_35px_rgba(249,115,22,0.15)]
">
                            @if ($profileSekolah && $profileSekolah->photo_exists)
                                <img src="{{ asset($profileSekolah->upload_photo_profile_sekolah) }}"
                                    alt="Profil YTSS Soccer School Bogor - {{ $profileSekolah->judul_profile_sekolah ?? 'Sekolah Sepak Bola Bogor' }}"
                                    loading="lazy"
                                    class="
w-full
h-full
object-cover

transition-all
duration-700

group-hover:scale-105
">
                            @endif

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="lg:col-span-7">

                        <div class="mb-8">

                            <p class="uppercase tracking-[4px] text-orange-400 text-sm font-bold mb-3">
                                Profile Sekolah
                            </p>

                            <h2 class="text-4xl md:text-5xl font-black uppercase text-white">
                                {{ $profileSekolah->judul_profile_sekolah ?? 'YTSS Academy' }}
                            </h2>

                        </div>

                        <div class="profile-content text-white/75">
                            {!! $profileSekolah->konten_profile_sekolah !!}
                        </div>
                    </div>

                </div>

            </div>

        </section>

        {{-- VALUES SECTION --}}
        <section class="bg-black px-6 md:px-16 pb-24">

            <div class="max-w-7xl mx-auto">

                <div class="text-center mb-12">

                    <p class="uppercase tracking-[4px] text-orange-400 text-sm font-bold mb-4">
                        Our Values
                    </p>

                    <h2 class="text-4xl md:text-5xl font-black uppercase text-white">
                        Beyond Football
                    </h2>

                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
<div
class="
group
bg-white/[0.05]
border
border-orange-500/20
rounded-2xl
p-6
backdrop-blur-sm
transition-all
duration-500
hover:-translate-y-2
hover:border-orange-500/40
hover:bg-white/[0.08]
hover:shadow-[0_0_30px_rgba(249,115,22,0.18)]
">

    <div
    class="
    w-16 h-16
    rounded-2xl
    bg-orange-500/10
    border border-orange-500/20
    flex items-center justify-center
    mb-5">

        <i data-lucide="shield-check"
           class="w-8 h-8 text-orange-400 float-icon glow-icon">
        </i>

    </div>

    <h3 class="text-white font-black uppercase mb-3">
        Discipline
    </h3>

    <p class="text-white/60 text-sm">
        Membentuk kebiasaan disiplin dalam latihan dan kehidupan.
    </p>

</div>                    <div
                        class="
group
bg-white/[0.05]
border
border-orange-500/20
rounded-2xl
p-6
backdrop-blur-sm

transition-all
duration-500

hover:-translate-y-2
hover:border-orange-500/40
hover:bg-white/[0.08]
hover:shadow-[0_0_30px_rgba(249,115,22,0.18)]
">
                        <div
                            class="
w-16 h-16
rounded-2xl
bg-orange-500/10
border border-orange-500/20
flex items-center justify-center
mb-5">

                            <i data-lucide="trophy" class="w-8 h-8 text-orange-400 float-icon glow-icon">
                            </i>

                        </div>
                        <h3 class="text-white font-black uppercase mb-3">
                            Excellence
                        </h3>
                        <p class="text-white/60 text-sm">
                            Mendorong atlet untuk mencapai performa terbaik.
                        </p>
                    </div>

                    <div
                        class="
group
bg-white/[0.05]
border
border-orange-500/20
rounded-2xl
p-6
backdrop-blur-sm

transition-all
duration-500

hover:-translate-y-2
hover:border-orange-500/40
hover:bg-white/[0.08]
hover:shadow-[0_0_30px_rgba(249,115,22,0.18)]
">
                        <div
                            class="
w-16 h-16
rounded-2xl
bg-orange-500/10
border border-orange-500/20
flex items-center justify-center
mb-5">

                            <i data-lucide="handshake" class="w-8 h-8 text-orange-400 float-icon glow-icon">
                            </i>

                        </div>
                        <h3 class="text-white font-black uppercase mb-3">
                            Teamwork
                        </h3>
                        <p class="text-white/60 text-sm">
                            Menanamkan kerja sama dan rasa saling menghargai.
                        </p>
                    </div>

                    <div
                        class="
group
bg-white/[0.05]
border
border-orange-500/20
rounded-2xl
p-6
backdrop-blur-sm

transition-all
duration-500

hover:-translate-y-2
hover:border-orange-500/40
hover:bg-white/[0.08]
hover:shadow-[0_0_30px_rgba(249,115,22,0.18)]
">
                        <div
                            class="
w-16 h-16
rounded-2xl
bg-orange-500/10
border border-orange-500/20
flex items-center justify-center
mb-5">

                            <i data-lucide="flame" class="w-8 h-8 text-orange-400 float-icon glow-icon">
                            </i>

                        </div>
                        <h3 class="text-white font-black uppercase mb-3">
                            Character
                        </h3>
                        <p class="text-white/60 text-sm">
                            Membangun mental juara dan karakter positif.
                        </p>
                    </div>

                </div>

            </div>

        </section>

        @include('partials.footer')

    </main>
@endsection
