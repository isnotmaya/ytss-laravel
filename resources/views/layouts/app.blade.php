<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* HERO ENTRY ANIMATION */
        @keyframes chevronGlow {

            0% {
                opacity: .72;
                filter: brightness(1);
            }

            50% {
                opacity: 1;
                filter: brightness(1.2);
            }

            100% {
                opacity: .72;
                filter: brightness(1);
            }
        }

        .animate-chevron-glow {
            animation:
                chevronGlow 1.8s ease-in-out infinite;
        }



        .animate-chevron-glow {
            animation:
                chevronGlow 1.8s ease-in-out infinite;
        }

        @keyframes ctaFlow {

            0% {
                transform: translateX(0);
                opacity: .72;
            }

            50% {
                transform: translateX(2px);
                opacity: 1;
            }

            100% {
                transform: translateX(0);
                opacity: .72;
            }
        }

        .animate-cta-flow {
            animation:
                ctaFlow 1.8s ease-in-out infinite;
        }

        .micro-smooth {
            transition: transform .45s cubic-bezier(.22, 1, .36, 1), box-shadow .45s cubic-bezier(.22, 1, .36, 1), opacity .35s ease;
            will-change: transform, opacity, box-shadow;
        }

        .hero-depth-glow {
            transition: opacity .45s ease, transform .45s cubic-bezier(.22, 1, .36, 1);
            will-change: opacity, transform;
        }

        @keyframes heroReveal {

            0% {
                opacity: 0;
                transform: translateY(38px) scale(0.96);
                filter: blur(12px);
            }

            60% {
                opacity: 1;
                filter: blur(0px);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0px);
            }
        }

        @keyframes heroFade {

            from {
                opacity: 0;
                transform: translateY(18px);
                filter: blur(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        /* HEADLINE */
        .animate-hero-title {
            opacity: 0;
            animation:
                heroReveal 1.2s cubic-bezier(.22, 1, .36, 1) forwards;
            animation-delay: .15s;
        }

        /* SEASON */
        .animate-hero-season {
            opacity: 0;
            animation:
                heroFade .8s ease forwards;
        }

        /* SUBTITLE */
        .animate-hero-subtitle {
            opacity: 0;
            animation:
                heroFade 1s ease forwards;
            animation-delay: .45s;
        }

        /* CTA */
        .animate-hero-cta {
            opacity: 0;
            animation:
                heroFade 1s ease forwards;
            animation-delay: .7s;
        }

        .animate-hero-accent {
            display: inline-block;
            opacity: 0;

            animation:
                heroReveal 1s cubic-bezier(.22, 1, .36, 1) forwards;

            animation-delay: .35s;
        }

        /*sidebar*/
        @keyframes slideInLeft {

            from {
                opacity: 0;
                transform: translateX(-12px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* =========================
   LUCIDE MICRO ANIMATIONS
========================= */

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                filter: drop-shadow(0 0 0px rgba(249, 115, 22, 0));
            }

            50% {
                filter: drop-shadow(0 0 10px rgba(249, 115, 22, .45));
            }
        }

        .float-icon {
            animation: float 4s ease-in-out infinite;
        }

        .glow-icon {
            animation: pulseGlow 3s ease-in-out infinite;
        }

        .icon-hover {
            transition:
                transform .35s cubic-bezier(.22, 1, .36, 1),
                color .35s ease,
                filter .35s ease;
        }

        .icon-hover:hover {
            transform: translateY(-4px) scale(1.08);
        }

        .icon-card:hover .icon-hover {
            transform: translateY(-4px) scale(1.08);
        }

        .icon-card:hover .glow-icon {
            filter: drop-shadow(0 0 12px rgba(249, 115, 22, .5));
        }

        /* SCROLL REVEAL ANIMATIONS */
        .reveal-on-scroll {
            opacity: 0;
            visibility: hidden;
            transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }

        .reveal-on-scroll.revealed {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* ACCESSIBILITY: REDUCED MOTION */
        @media (prefers-reduced-motion: reduce) {
            .reveal-on-scroll {
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
                transition: none !important;
                will-change: auto !important;
            }
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @include('partials.seo')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- LUCIDE ICONS -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="{
    mobileMenu: false,
    profileMenu: false,
    activeMenu: 'profile',
    authTab: 'login'
}" :class="mobileMenu ? 'overflow-hidden' : 'overflow-x-hidden'"
    class="bg-[#0c0c0c] text-white">

    @yield('content')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            // Accessibility: Respect prefers-reduced-motion
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReducedMotion) {
                document.querySelectorAll('.reveal-on-scroll').forEach(el => {
                    el.classList.add('revealed');
                });
                return;
            }

            // IntersectionObserver for Scroll Reveal
            const revealElements = document.querySelectorAll('.reveal-on-scroll');
            const observerOptions = {
                root: null,
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            revealElements.forEach(element => {
                revealObserver.observe(element);
            });
        });
    </script>
</body>

</html>
