@extends('layouts.app')

@section('seo_title', 'Sekolah Sepak Bola Bogor Terbaik & Murah | YTSS Soccer School')
@section('seo_description', 'Bergabunglah dengan YTSS Soccer School (SSB Bogor), akademi sepak bola terbaik & terjangkau di Bogor. Program latihan profesional, pembinaan usia dini, & beasiswa sepak bola anak.')
@section('seo_keywords', 'sekolah sepak bola bogor, ssb bogor, akademi sepak bola bogor, sekolah bola bogor, beasiswa sepak bola bogor, kursus sepak bola anak bogor, pelatihan sepak bola anak bogor, sekolah sepak bola murah bogor, ssb murah bogor, akademi sepak bola terjangkau bogor')

@section('content')
    @include('partials.sidebar')

    <main class="ml-0 md:ml-[96px]">
        @include('partials.navbar')

        @include('partials.mobile-menu')

        @include('sections.hero')

        @include('sections.categories')

        @include('sections.achievement')

        @include('sections.stats')

        @include('sections.faq')

        @include('partials.footer')

    </main>
@endsection
