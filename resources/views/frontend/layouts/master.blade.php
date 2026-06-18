<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    @php
        $company = App\Models\CompanyDetails::select(
            'company_name', 'fav_icon', 'google_site_verification',
            'footer_content', 'facebook',
            'twitter', 'linkedin', 'instagram', 'youtube', 'website', 'phone1', 'phone2', 'email1',
            'address1', 'company_logo', 'footer_logo', 'copyright',
            'google_map', 'meta_title', 'meta_description', 'meta_keywords',
        )->first();

        // Fallback chain: page-specific → company OG image → hardcoded default
        if (isset($pageImage) && $pageImage) {
            // Page-specific image already set (e.g., service details)
        }else {
            $pageImage = asset('images/og-image.jpg');
        }

        // Default fallbacks specific to NYC Sidewalk Pros
        $pageTitle       = $pageTitle       ?? $company->meta_title       ?? 'NYC Sidewalk Pros | Licensed Sidewalk & Concrete Contractors in New York';
        $pageDescription = $pageDescription ?? $company->meta_description ?? 'NYC\'s most trusted sidewalk and concrete contractors since 1998. DOT violation removal, sidewalk repair, concrete installation. Licensed, insured & serving all 5 boroughs. Call (212) 555-1234 for a free estimate.';
        $pageKeywords    = $pageKeywords    ?? $company->meta_keywords    ?? 'NYC sidewalk repair, DOT violation removal, concrete contractor New York, sidewalk violation NYC, concrete installation Brooklyn, Manhattan sidewalk repair';
        $robotsIndex     = $robotsIndex     ?? $company->robots_index     ?? 'index';
        $robotsFollow    = $robotsFollow    ?? $company->robots_follow    ?? 'follow';
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- ===== PRIMARY META TAGS ===== -->
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    @if($pageDescription)
        <meta name="description" content="{{ Str::limit($pageDescription, 160) }}">
    @endif
    @if($pageKeywords)
        <meta name="keywords" content="{{ $pageKeywords }}">
    @endif
    <meta name="author" content="{{ $company->company_name }}">
    <meta name="robots" content="{{ $robotsIndex }}, {{ $robotsFollow }}, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- ===== FAVICON ===== -->
    @if($company->fav_icon)
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/company/' . $company->fav_icon) }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('uploads/company/' . $company->fav_icon) }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('uploads/company/' . $company->fav_icon) }}">
    @else
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    @endif

    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">

    <!-- ===== OPEN GRAPH / FACEBOOK ===== -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    @if($pageDescription)
        <meta property="og:description" content="{{ Str::limit($pageDescription, 200) }}">
    @endif
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $company->company_name }}">
    <meta property="og:site_name" content="{{ $company->company_name }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- ===== TWITTER CARD ===== -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    @if($pageDescription)
        <meta name="twitter:description" content="{{ Str::limit($pageDescription, 200) }}">
    @endif
    <meta name="twitter:image" content="{{ $pageImage }}">
    <meta name="twitter:image:alt" content="{{ $company->company_name }}">
    @if($company->twitter)
        <meta name="twitter:site" content="@{{ str_replace(['https://twitter.com/', 'https://x.com/', '@'], '', $company->twitter) }}">
    @endif

    <!-- ===== SITE VERIFICATION ===== -->
    @if($company->google_site_verification)
        <meta name="google-site-verification" content="{{ $company->google_site_verification }}">
    @endif

    <!-- ===== GEO TAGS ===== -->
    @if($company->address1)
        <meta name="geo.region" content="US-NY">
        <meta name="geo.placename" content="{{ $company->address1 }}">
    @endif

    <!-- ===== PRECONNECT ===== -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">

    <!-- ===== STYLESHEETS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="{{ asset('resources/frontend/css/style.css') }}" rel="stylesheet" type="text/css" />

    <!-- ===== PAGE-SPECIFIC CSS ===== -->
    @yield('page-css')

    <!-- ===== GOOGLE TAG MANAGER (HEAD) ===== -->
    @if($company->google_tag_manager_id)
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $company->google_tag_manager_id }}');
        </script>
    @endif

    <!-- ===== PAGE-SPECIFIC STRUCTURED DATA ===== -->
    @yield('structured-data')

</head>
<body>

    <!-- ===== GOOGLE TAG MANAGER (BODY) ===== -->
    @if($company->google_tag_manager_id)
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ $company->google_tag_manager_id }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endif

    @include('frontend.inc.header')

    @yield('content')

    @include('frontend.cookies')

    @include('frontend.inc.footer')

    <!-- ===== Back to Top Button ===== -->
    <button id="backToTop" class="back-to-top" title="Back to Top" aria-label="Back to top">
        <i class="bi bi-chevron-up"></i>
    </button>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-update copyright year
        const yearEl = document.getElementById('currentYear');
        if (yearEl) yearEl.textContent = new Date().getFullYear();

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            window.addEventListener('scroll', () => {
                navbar.classList.toggle('scrolled', window.scrollY > 40);
            });
        }



        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const offset = 80;
                    const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                    // Close mobile nav
                    const navCollapse = document.getElementById('mainNav');
                    if (navCollapse) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                        if (bsCollapse) bsCollapse.hide();
                    }
                }
            });
        });

        // Back to top button
        const backToTopBtn = document.getElementById('backToTop');
        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                backToTopBtn.classList.toggle('show', window.scrollY > 500);
            });
            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Estimate form
        const estimateForm = document.getElementById('estimateForm');
        if (estimateForm) {
            estimateForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = this.querySelector('.btn-estimate');
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Request Submitted!';
                btn.style.background = '#22c55e';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = orig;
                    btn.style.background = '';
                    btn.disabled = false;
                    this.reset();
                }, 3000);
            });
        }
    </script>



    @yield('script')

</body>
</html>