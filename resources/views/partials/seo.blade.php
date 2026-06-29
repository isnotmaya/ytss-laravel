@php
    // Get title, description, keywords, canonical with defaults
    $seoTitle = View::hasSection('seo_title')
        ? trim(View::yieldContent('seo_title'))
        : 'SSB Bogor & Sekolah Sepak Bola Bogor Terbaik | YTSS Soccer School';

    $seoDescription = View::hasSection('seo_description')
        ? trim(View::yieldContent('seo_description'))
        : 'YTSS Soccer School (SSB Bogor) adalah sekolah sepak bola anak terbaik di Bogor. Kami menawarkan pembinaan sepak bola usia dini Bogor secara profesional, terjangkau & murah.';

    $seoKeywords = View::hasSection('seo_keywords')
        ? trim(View::yieldContent('seo_keywords'))
        : 'sekolah sepak bola bogor, ssb bogor, sekolah sepak bola murah di bogor, ssb murah di bogor, akademi sepak bola bogor, akademi sepak bola murah di bogor, soccer school bogor, latihan sepak bola anak bogor, kursus sepak bola anak bogor, beasiswa sepak bola bogor, sekolah sepak bola terjangkau di bogor, sekolah sepak bola anak terbaik di bogor, tempat latihan sepak bola anak bogor, pembinaan sepak bola usia dini bogor';

    // Canonical URL: use yields if defined, else construct from config('app.url') and path
    if (View::hasSection('seo_canonical')) {
        $canonicalUrl = trim(View::yieldContent('seo_canonical'));
    } else {
        $baseUrl = rtrim(config('app.url', 'https://ytss.com'), '/');
        if (str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '127.0.0.1')) {
            $baseUrl = 'https://ytss.com';
        }
        $path = request()->getPathInfo();
        $canonicalUrl = $baseUrl . ($path === '/' ? '' : $path);
    }

    $ogImage = asset('images/ytss_logo.png');
@endphp

<!-- Basic Meta Tags -->
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta name="robots" content="index, follow">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:image" content="{{ $ogImage }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $canonicalUrl }}">
<meta property="twitter:title" content="{{ $seoTitle }}">
<meta property="twitter:description" content="{{ $seoDescription }}">
<meta property="twitter:image" content="{{ $ogImage }}">

<!-- Favicon & Touch Icons -->
<link rel="shortcut icon" href="{{ asset('images/ytss_logo.png') }}" type="image/png">
<link rel="apple-touch-icon" href="{{ asset('images/ytss_logo.png') }}">

<!-- Theme Color -->
<meta name="theme-color" content="#f97316">

<!-- JSON-LD Schema.org for Homepage only -->
@if(request()->is('/') || request()->is('home'))
@php
$jsonLd = [
  "@context" => "https://schema.org",
  "@graph" => [
    [
      "@type" => "SportsOrganization",
      "@id" => "https://ytss.com/#organization",
      "name" => "YTSS Soccer School",
      "url" => "https://ytss.com/",
      "logo" => [
        "@type" => "ImageObject",
        "@id" => "https://ytss.com/#logo",
        "url" => "https://ytss.com/images/ytss_logo.png",
        "caption" => "YTSS Soccer School"
      ],
      "image" => [
        "@id" => "https://ytss.com/images/ytss_logo.png"
      ],
      "description" => "Sekolah sepak bola anak terbaik di Bogor (SSB Bogor) dengan program pembinaan sepak bola usia dini bogor secara profesional dan terjangkau.",
      "address" => [
        "@type" => "PostalAddress",
        "addressLocality" => "Bogor",
        "addressRegion" => "Jawa Barat",
        "addressCountry" => "ID"
      ]
    ],
    [
      "@type" => "EducationalOrganization",
      "@id" => "https://ytss.com/#educational_organization",
      "name" => "YTSS Soccer School",
      "url" => "https://ytss.com/",
      "description" => "Akademi sepak bola murah di Bogor yang menawarkan kurikulum pembinaan sepak bola usia dini Bogor secara terstruktur.",
      "parentOrganization" => [
        "@id" => "https://ytss.com/#organization"
      ]
    ],
    [
      "@type" => "LocalBusiness",
      "@id" => "https://ytss.com/#local_business",
      "name" => "YTSS Soccer School",
      "image" => "https://ytss.com/images/ytss_logo.png",
      "url" => "https://ytss.com/",
      "telephone" => "+6281234567890",
      "priceRange" => "Rp",
      "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "Jl. Kolonel Ahmad Syam, Baranangsiang",
        "addressLocality" => "Bogor",
        "addressRegion" => "Jawa Barat",
        "postalCode" => "16143",
        "addressCountry" => "ID"
      ],
      "geo" => [
        "@type" => "GeoCoordinates",
        "latitude" => -6.6000,
        "longitude" => 106.8000
      ],
      "openingHoursSpecification" => [
        "@type" => "OpeningHoursSpecification",
        "dayOfWeek" => [
          "Tuesday",
          "Thursday",
          "Saturday",
          "Sunday"
        ],
        "opens" => "07:00",
        "closes" => "17:00"
      ]
    ],
    [
      "@type" => "FAQPage",
      "@context" => "https://schema.org",
      "mainEntity" => [
        [
          "@type" => "Question",
          "name" => "Di mana lokasi tempat latihan sepak bola anak Bogor di YTSS Soccer School?",
          "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Tempat latihan sepak bola anak Bogor YTSS Soccer School berlokasi di Bogor, Jawa Barat. Kami menyediakan fasilitas lapangan berkualitas tinggi untuk mendukung perkembangan sepak bola anak secara optimal."
          ]
        ],
        [
          "@type" => "Question",
          "name" => "Mengapa YTSS dianggap sebagai sekolah sepak bola anak terbaik di Bogor?",
          "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "YTSS Soccer School adalah sekolah sepak bola anak terbaik di Bogor yang mengusung metode pembinaan sepak bola usia dini Bogor secara komprehensif. Kami fokus pada teknik, karakter, disiplin, dan didukung oleh pelatih berlisensi profesional."
          ]
        ],
        [
          "@type" => "Question",
          "name" => "Apakah YTSS merupakan sekolah sepak bola murah di Bogor dengan kualitas profesional?",
          "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Ya, YTSS adalah sekolah sepak bola terjangkau di Bogor (SSB murah di Bogor) yang tetap berkomitmen menyajikan program latihan standar tinggi. Kami percaya pembinaan sepak bola berkualitas harus bisa diakses oleh seluruh kalangan masyarakat."
          ]
        ],
        [
          "@type" => "Question",
          "name" => "Bagaimana cara mendaftar program beasiswa sepak bola Bogor di YTSS Academy?",
          "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "Kami menyediakan beasiswa sepak bola Bogor bagi anak-anak berbakat. Orang tua dapat mengajukan berkas secara online melalui portal resmi YTSS Academy dengan menyertakan piagam prestasi atau video rekaman latihan anak."
          ]
        ],
        [
          "@type" => "Question",
          "name" => "Apa perbedaan antara SSB Bogor biasa dengan akademi sepak bola Bogor YTSS?",
          "acceptedAnswer" => [
            "@type" => "Answer",
            "text" => "YTSS sebagai akademi sepak bola murah di Bogor tidak hanya sekadar SSB Bogor biasa. Kami memiliki kurikulum terstruktur (Youth Tiger Soccer School), kelompok usia pembinaan dari 2010 hingga 2019, serta jaringan kompetisi regional dan nasional."
          ]
        ]
      ]
    ]
  ]
];
@endphp
<script type="application/ld+json">
{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif

