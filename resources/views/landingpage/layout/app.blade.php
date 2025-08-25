<!DOCTYPE html>
<html lang="ms-MY">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Primary Meta Tags -->
    @if ($global_brand)
        <title>{{ $global_brand->name_brand }} - {{ $global_brand->description }} </title>
        @else
        <title>Coedev - formerly known as Idolegacy Sdn Bhd</title>
    @endif
    <meta name="title" content="Coedev - formerly known as Idolegacy Sdn Bhd">
    <meta name="description" content="Unit Saudara Islam (USIA) Sabah - Organisasi dakwah Islam terkemuka di Sabah. Menyediakan program pembangunan ummah, pendidikan Islam, bantuan mualaf, dan khidmat sosial untuk masyarakat Islam di seluruh Sabah.">
    <meta name="keywords" content="USIA, Unit Saudara Islam, Islam Sabah, dakwah Sabah, mualaf Sabah, pendidikan Islam, bantuan kebajikan Islam, organisasi Islam Sabah, khidmat sosial Islam, pembangunan ummah Sabah">
    <meta name="author" content="Unit Saudara Islam (USIA) Sabah">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Malay">
    <meta name="revisit-after" content="7 days">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://usia.sabah.org.my/">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://usia.sabah.org.my/">
    <meta property="og:title" content="Coedev - formerly known as Idolegacy Sdn Bhd">
    <meta property="og:description" content="Unit Saudara Islam (USIA) Sabah - Organisasi dakwah Islam terkemuka di Sabah. Menyediakan program pembangunan ummah, pendidikan Islam, bantuan mualaf, dan khidmat sosial.">
    <meta property="og:image" content="{{ asset('landingpage/images/usia-og-image.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="ms_MY">
    <meta property="og:site_name" content="Coedev">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://usia.sabah.org.my/">
    <meta property="twitter:title" content="Coedev - formerly known as Idolegacy Sdn Bhd">
    <meta property="twitter:description" content="Unit Saudara Islam (USIA) Sabah - Organisasi dakwah Islam terkemuka di Sabah. Menyediakan program pembangunan ummah, pendidikan Islam, dan khidmat sosial.">
    <meta property="twitter:image" content="{{ asset('landingpage/images/usia-og-image.jpg') }}">
    
    <!-- Geo Meta Tags -->
    <meta name="geo.region" content="MY-12">
    <meta name="geo.placename" content="Sabah">
    <meta name="geo.position" content="5.9804;116.0735">
    <meta name="ICBM" content="5.9804, 116.0735">
    
    <!-- Organization Schema Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "IslamicOrganization",
        "name": "Unit Saudara Islam (USIA) Sabah",
        "alternateName": "USIA",
        "url": "https://usia.sabah.org.my",
        "logo": "https://usia.sabah.org.my/images/logo-usia.png",
        "description": "Organisasi dakwah Islam terkemuka di Sabah yang menyediakan program pembangunan ummah, pendidikan Islam, bantuan mualaf, dan khidmat sosial",
        "address": {
            "@type": "PostalAddress",
            "addressRegion": "Sabah",
            "addressCountry": "MY"
        },
        "areaServed": {
            "@type": "State",
            "name": "Sabah",
            "containedIn": {
                "@type": "Country",
                "name": "Malaysia"
            }
        },
        "keywords": "dakwah islam, pendidikan islam, bantuan mualaf, khidmat sosial islam, pembangunan ummah",
        "sameAs": [
            "https://www.facebook.com/usiasabah",
            "https://www.instagram.com/usiasabah"
        ]
    }
    </script>
    
    <!-- Breadcrumb Schema for Homepage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Laman Utama",
            "item": "https://usia.sabah.org.my"
        }]
    }
    </script>

    <!-- Favicons -->
    @if ($global_brand)
        <link href="{{ $global_brand->logo_url }}" rel="icon">
        @else
        <link href="{{ asset('images/coedev-logo.png') }}" rel="icon">
    @endif
    <link href="{{ asset('landingpage/images/logo-usia.png') }}" rel="apple-touch-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('landingpage/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landingpage/images/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    <!-- DNS Prefetch for Performance -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//code.jquery.com">
    
    <!-- Preconnect for Critical Resources -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    
    <!-- Google Fonts - Optimized Loading -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="{{ asset('temp/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('temp/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('temp/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('temp/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('temp/assets/css/main.css') }}" rel="stylesheet">
    
    <!-- Google Tag Manager (Optional - ganti dengan ID anda) -->
    <script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-XXXXXX');
    </script>
    
    @stack('style')
</head>

<body class="index-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXX"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    @include('landingpage.components.navbar')

    <main class="main" role="main">
        @yield('content')
    </main>

    @include('landingpage.components.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Kembali ke atas">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader" aria-hidden="true"></div>
    
    <!-- jQuery - Optimized Loading -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous"></script>
        
    <!-- Vendor JS Files -->
    <script src="{{ asset('temp/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('temp/assets/vendor/php-email-form/validate.js') }}" defer></script>
    <script src="{{ asset('temp/assets/vendor/aos/aos.js') }}" defer></script>
    <script src="{{ asset('temp/assets/vendor/swiper/swiper-bundle.min.js') }}" defer></script>

    <!-- Main JS File -->
    <script src="{{ asset('temp/assets/js/main.js') }}" defer></script>
    
    @stack('script')

</body>

</html>