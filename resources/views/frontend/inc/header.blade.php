<!-- ========== NAVBAR ========== -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            @if($company->company_logo)
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="{{ $company->company_name }}" class="brand-logo">
            @else
                <i class="bi bi-building"></i>
                NYC <span>Sidewalk Pros</span>
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-bar"></span>
            <span class="toggler-bar"></span>
            <span class="toggler-bar"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('service') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('aboutUs') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('testimonial') }}">Reviews</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            </ul>
            <div class="nav-right d-flex align-items-center">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company->phone1 ?? '(212) 555-1234') }}" class="nav-phone">
                    <i class="bi bi-telephone-fill"></i>
                    {{ $company->phone1 ?? '(212) 555-1234' }}
                </a>
                <a href="{{ route('contact') }}" class="btn-nav-cta">Get Free Estimate</a>
            </div>
        </div>
    </div>
</nav>