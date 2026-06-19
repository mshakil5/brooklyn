@extends('frontend.layouts.master')

@section('content')


<style>
    /* ============================================
    HERO SECTION
    ============================================ */
    .hero-section {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: #0A0F1C;
    }

    .hero-bg-image {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .hero-bg-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.25;
    }

    .hero-bg-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom right,
            #0A0F1C 0%,
            rgba(10, 15, 28, 0.85) 50%,
            rgba(10, 15, 28, 0.60) 100%
        );
        z-index: 1;
    }

    /* Grid pattern overlay */
    .hero-grid-overlay {
        position: absolute;
        inset: 0;
        opacity: 0.04;
        background-image: 
            linear-gradient(rgba(255, 255, 255) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255) 1px, transparent 1px);
        background-size: 60px 60px;
        z-index: 2;
    }

    .hero-section .container {
        position: relative;
        z-index: 10;
        padding-top: 7rem;
        padding-bottom: 5rem;
    }

    @media (min-width: 1024px) {
        .hero-section .container {
            padding-top: 9rem;
            padding-bottom: 7rem;
        }
    }

    .hero-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        align-items: center;
    }

    @media (min-width: 1024px) {
        .hero-row {
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
        }
    }

    /* ---- Amber Tag ---- */
    .amber-tag {
        display: inline-block;
        background: rgba(245, 158, 11, 0.15);
        color: #F59E0B;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    /* ---- Left Content ---- */
    .hero-subtitle-small {
        color: #0052FF;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        margin-bottom: 0.75rem;
    }

    .hero-title {
        font-size: clamp(2.4rem, 5.5vw, 4.5rem);
        font-weight: 700;
        color: #ffffff;
        line-height: 1.0;
        margin-bottom: 1.5rem;
        letter-spacing: -0.025em;
    }

    .hero-title .text-blue {
        color: #0052FF;
    }

    .hero-desc {
        font-size: 1.125rem;
        color: #94A3B8;
        line-height: 1.625;
        margin-bottom: 2.5rem;
        max-width: 32rem;
    }

    /* ---- Highlights with Circle Icons ---- */
    .hero-highlights {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .highlight-icon-circle {
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 50%;
        background: rgba(0, 82, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .highlight-icon-circle i,
    .highlight-icon-circle svg {
        color: #0052FF;
        font-size: 0.8125rem;
    }

    .highlight-item span {
        color: #94A3B8;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* ---- Right Form Card ---- */
    .hero-form-card {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.10);
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .form-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.25rem;
    }

    .form-card-subtitle {
        font-size: 0.875rem;
        color: #64748B;
        margin-bottom: 1.5rem;
    }

    /* Form Labels */
    .form-label-custom {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.375rem;
    }

    .form-label-custom .required {
        color: #0052FF;
    }

    /* Form Inputs */
    .hero-form-card .form-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 0.375rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: #ffffff;
        font-family: var(--font);
        transition: all 0.3s ease;
    }

    .hero-form-card .form-control::placeholder {
        color: #475569;
    }

    .hero-form-card .form-control:focus {
        background: rgba(255, 255, 255, 0.12);
        border-color: #0052FF;
        box-shadow: none;
        outline: none;
        color: #ffffff;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .form-row {
            grid-template-columns: 1fr 1fr;
        }
    }

    .btn-submit {
        width: 100%;
        background: #0052FF;
        color: #ffffff;
        border: none;
        border-radius: 0.375rem;
        padding: 1rem 1.5rem;
        font-family: var(--font);
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
    }

    .btn-submit:hover {
        background: #003ACC;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 82, 255, 0.3);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .form-privacy-note {
        text-align: center;
        font-size: 0.75rem;
        color: #475569;
        margin-top: 1rem;
    }

    /* ---- Scroll Indicator ---- */
    .scroll-indicator {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        z-index: 10;
    }

    .scroll-indicator span {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .scroll-line {
        width: 1px;
        height: 2.5rem;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.2), transparent);
    }

    /* ============================================
    STATS BAR
    ============================================ */
    .stats-bar {
        position: relative;
        z-index: 10;
        background: #0052FF;
        padding: 2rem 0;
    }

    .stat-item {
        text-align: center;
        padding: 0.5rem 0.75rem;
        border-right: 1px solid rgba(255, 255, 255, 0.15);
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-number {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.75);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<!-- ========== HERO SECTION ========== -->
<section class="hero-section">
    <!-- Background Image -->
    <div class="hero-bg-image">
        @if($slider && $slider->image)
            <img src="{{ asset('uploads/slider/' . $slider->image) }}" alt="NYC streets">
        @else
            <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=1800&q=85&fit=crop" alt="NYC streets">
        @endif
    </div>
    
    <!-- Dark Gradient Overlay -->
    <div class="hero-bg-overlay"></div>
    
    <!-- Grid Pattern Overlay -->
    <div class="hero-grid-overlay"></div>
    
    <!-- Main Content -->
    <div class="container">
        <div class="hero-row">
            <!-- Left Content -->
            <div class="hero-left">
                <span class="amber-tag">DOT Certified · Licensed & Insured Since 1998</span>
                
                <p class="hero-subtitle-small">FREE INSTANT CHECK</p>
                
                <h1 class="hero-title">
                    {!! $slider->title ?? 'Does Your Sidewalk<br>Have <span class="text-blue">Violations?</span>' !!}
                </h1>
                
                <p class="hero-desc">
                    {{ $slider->subtitle ?? 'Enter your NYC property details below to quickly check if your sidewalk may have DOT violations. Our experts respond within 2 business hours.' }}
                </p>
                
                @php
                    $highlights = is_array($slider->highlights) ? $slider->highlights : [];
                    $defaultHighlights = [
                        ['icon' => 'bi bi-lightning-charge-fill', 'text' => 'Fast Response'],
                        ['icon' => 'bi bi-currency-dollar', 'text' => 'Free Estimate'],
                        ['icon' => 'bi bi-hand-thumbs-up-fill', 'text' => 'No Obligation'],
                    ];
                    $highlights = !empty($highlights) ? $highlights : $defaultHighlights;
                @endphp
                <div class="hero-highlights">
                    @foreach($highlights as $item)
                        <div class="highlight-item">
                            <div class="highlight-icon-circle">
                                <i class="{{ $item['icon'] ?? 'bi bi-lightning-charge-fill' }}"></i>
                            </div>
                            <span>{{ $item['text'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Form -->
            <div class="hero-right">
                <div class="hero-form-card">
                    <h2 class="form-card-title">Check My Property</h2>
                    <p class="form-card-subtitle">Free · Takes 30 seconds · No obligation</p>
                    
                    <form id="checkForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label-custom">Property Address <span class="required">*</span></label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="e.g. 123 Atlantic Ave, Brooklyn, NY" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label-custom">Your Name</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="John Smith" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label-custom">Phone Number</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="(718) 000-0000" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label-custom">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            Check My Property →
                        </button>
                    </form>
                    
                    <p class="form-privacy-note">🔒 Your information is private and never shared.</p>
                </div>
            </div>
        </div>
    </div>
    
</section>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="container">
            <div class="row g-0">
                @php
                    $stats = is_array($slider->stats) ? $slider->stats : [];
                    $defaultStats = [
                        ['number' => '5,000+', 'label' => 'Projects Completed'],
                        ['number' => '25+', 'label' => 'Years in Business'],
                        ['number' => '100%', 'label' => 'DOT Compliant'],
                        ['number' => '24/7', 'label' => 'Emergency Service'],
                    ];
                    $stats = !empty($stats) ? $stats : $defaultStats;
                @endphp
                @foreach($stats as $stat)
                    <div class="col-6 col-md-2">
                        <div class="stat-item">
                            <span class="stat-number">{{ $stat['number'] ?? '' }}</span>
                            <span class="stat-label">{{ $stat['label'] ?? '' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <!-- ========== SERVICES SECTION ========== -->
    <section class="services-section">
        <div class="container">
            <div class="services-header text-center">
                <span class="services-tag">Our Services</span>
                <h2 class="services-title">Comprehensive Sidewalk &<br><span class="text-blue">Concrete Services</span></h2>
                <p class="services-desc">From violation removal to complete concrete installation, we provide end-to-end sidewalk solutions for property owners across New York City.</p>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-6 col-lg-3">
                        <a href="{{ route('service') }}#{{ $service->slug }}" class="text-decoration-none">
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="{{ $service->icon }}"></i>
                                </div>
                                <h5>{{ $service->title }}</h5>
                                <p>{{ Str::limit(strip_tags($service->description), 90) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========== WHY NYC SIDEWALK PROS ========== -->
    <section class="why-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="why-content">
                        <span class="why-tag">Why Choose Us</span>
                        <h2 class="why-title">The Standard for <span class="text-blue">NYC Concrete</span> Work</h2>
                        <p class="why-desc">NYC Sidewalk Pros is the trusted choice for property owners, building managers, and contractors across all five boroughs. Our commitment to quality, compliance, and customer satisfaction sets us apart.</p>
                        <div class="why-credentials">
                            <div class="credential-item">
                                <i class="bi bi-patch-check-fill"></i>
                                <span>Licensed & Insured</span>
                            </div>
                            <div class="credential-item">
                                <i class="bi bi-patch-check-fill"></i>
                                <span>DOT Certified Contractor</span>
                            </div>
                            <div class="credential-item">
                                <i class="bi bi-patch-check-fill"></i>
                                <span>5-Year Workmanship Warranty</span>
                            </div>
                            <div class="credential-item">
                                <i class="bi bi-patch-check-fill"></i>
                                <span>All 5 Boroughs Covered</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="why-cards-row">
                        <div class="why-card">
                            <div class="why-card-icon">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <div class="why-card-info">
                                <span class="why-card-value">A+</span>
                                <span class="why-card-label">BBB Rating</span>
                            </div>
                        </div>
                        <div class="why-card">
                            <div class="why-card-icon">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="why-card-info">
                                <span class="why-card-value">4.9 <small>★</small></span>
                                <span class="why-card-label">Google Rating</span>
                            </div>
                        </div>
                        <div class="why-card">
                            <div class="why-card-icon">
                                <i class="bi bi-chat-square-text-fill"></i>
                            </div>
                            <div class="why-card-info">
                                <span class="why-card-value">500+</span>
                                <span class="why-card-label">Customer Reviews</span>
                            </div>
                        </div>
                        <div class="why-card">
                            <div class="why-card-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="why-card-info">
                                <span class="why-card-value">5,000+</span>
                                <span class="why-card-label">Projects Done</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ========== RECENT PROJECTS GALLERY ========== -->
    <section class="projects-section">
        <div class="container">
            <div class="projects-top-row">
                <div class="projects-header-left">
                    <span class="section-tag">Our Work</span>
                    <h2 class="section-title">Recent <span class="text-blue">Projects</span></h2>
                </div>
                <a href="#" class="btn-gallery-link">
                    View Full Gallery <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="gallery-card" data-img="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=1200&q=80">
                        <div class="gallery-img">
                            <img src="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=600&q=80" alt="DOT Violation Removal">
                            <div class="gallery-zoom">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <span class="gallery-category">DOT Violation Removal</span>
                            <h5>Flatbush Avenue Sidewalk</h5>
                            <p class="gallery-location"><i class="bi bi-geo-alt-fill"></i> Flatbush Avenue, Brooklyn</p>
                            <span class="gallery-year">2024</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="gallery-card" data-img="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1200&q=80">
                        <div class="gallery-img">
                            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=600&q=80" alt="Full Sidewalk Replacement">
                            <div class="gallery-zoom">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <span class="gallery-category">Full Sidewalk Replacement</span>
                            <h5>Jackson Heights Walkway</h5>
                            <p class="gallery-location"><i class="bi bi-geo-alt-fill"></i> Jackson Heights, Queens</p>
                            <span class="gallery-year">2024</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="gallery-card" data-img="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=1200&q=80">
                        <div class="gallery-img">
                            <img src="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=600&q=80" alt="Concrete Driveway Installation">
                            <div class="gallery-zoom">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <span class="gallery-category">Concrete Driveway Installation</span>
                            <h5>Residential Driveway</h5>
                            <p class="gallery-location"><i class="bi bi-geo-alt-fill"></i> Pelham Bay, Bronx</p>
                            <span class="gallery-year">2025</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="gallery-card" data-img="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1200&q=80">
                        <div class="gallery-img">
                            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=600&q=80" alt="ADA Ramp Construction">
                            <div class="gallery-zoom">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <span class="gallery-category">ADA Ramp Construction</span>
                            <h5>Commercial ADA Compliance</h5>
                            <p class="gallery-location"><i class="bi bi-geo-alt-fill"></i> Midtown, Manhattan</p>
                            <span class="gallery-year">2025</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== LIGHTBOX MODAL ========== -->
    <div class="lightbox-overlay" id="lightbox">
        <button class="lightbox-close" id="lightboxClose"><i class="bi bi-x-lg"></i></button>
        <button class="lightbox-nav lightbox-prev" id="lightboxPrev"><i class="bi bi-chevron-left"></i></button>
        <button class="lightbox-nav lightbox-next" id="lightboxNext"><i class="bi bi-chevron-right"></i></button>
        <div class="lightbox-content">
            <img src="" alt="Project Image" id="lightboxImg">
            <div class="lightbox-caption" id="lightboxCaption"></div>
        </div>
    </div>

    <!-- ========== CLIENT STORIES ========== -->
    <section class="stories-section">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag dark-tag">Testimonials</span>
                <h2 class="section-title-dark">What NYC Property <span class="text-blue">Owners Say</span></h2>
                <p class="section-desc-dark">Trusted by thousands of property owners across all five boroughs.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="story-card">
                        <div class="story-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="story-text">"They handled my sidewalk violation from start to finish. The DOT inspection passed on the first try and my violation was completely dismissed. Couldn't be happier!"</p>
                        <div class="story-author">
                            <div class="story-avatar">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&q=80" alt="Michael R.">
                            </div>
                            <div class="story-info">
                                <h6>Michael R.</h6>
                                <span>Property Owner, Brooklyn</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="story-card">
                        <div class="story-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="story-text">"Professional team, fair pricing, and excellent communication throughout the entire project. They replaced 12 sidewalk slabs in just 4 days. Highly recommend their services."</p>
                        <div class="story-author">
                            <div class="story-avatar">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&q=80" alt="Sarah K.">
                            </div>
                            <div class="story-info">
                                <h6>Sarah K.</h6>
                                <span>Building Manager, Manhattan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="story-card">
                        <div class="story-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="story-text">"I was so stressed about my DOT violation notice. These guys took care of everything — permits, concrete work, inspection. Peace of mind at a great price."</p>
                        <div class="story-author">
                            <div class="story-avatar">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&q=80" alt="David L.">
                            </div>
                            <div class="story-info">
                                <h6>David L.</h6>
                                <span>Homeowner, Queens</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FREE INSTANT CHECK ========== -->
    <section class="check-section">
        <div class="container">
            <div class="check-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="check-content">
                            <span class="check-tag">Free Check</span>
                            <h2 class="check-title">Does Your Sidewalk Have <span class="text-blue">Violations?</span></h2>
                            <p class="check-desc">Enter your property address below and we'll instantly check if there are any active sidewalk violations. It's completely free and takes just seconds.</p>
                            <div class="check-features">
                                <div class="check-feature">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Instant violation lookup</span>
                                </div>
                                <div class="check-feature">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>No obligation or cost</span>
                                </div>
                                <div class="check-feature">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Expert review included</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="check-form-card">
                            <h4><i class="bi bi-search"></i> Check Your Property</h4>
                            <p>Enter your NYC property address to get started</p>
                            <form id="instantCheckForm">
                                <div class="check-input-group">
                                    <i class="bi bi-geo-alt"></i>
                                    <input type="text" class="form-control" placeholder="Enter your property address..." required>
                                </div>
                                <button type="submit" class="btn-check">
                                    Check Now
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </form>
                            <div class="check-trust">
                                <i class="bi bi-shield-lock-fill"></i>
                                <span>Your information is 100% secure and private</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    
    @include('frontend.inc.estimate')


@endsection

@section('script')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>


        // ========== LIGHTBOX ==========
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const lightboxCaption = document.getElementById('lightboxCaption');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxPrev = document.getElementById('lightboxPrev');
        const lightboxNext = document.getElementById('lightboxNext');
        const galleryCards = document.querySelectorAll('.gallery-card');
        let currentIndex = 0;

        function openLightbox(index) {
            currentIndex = index;
            updateLightbox();
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        function updateLightbox() {
            const card = galleryCards[currentIndex];
            const imgSrc = card.getAttribute('data-img');
            const title = card.querySelector('h5').textContent;
            const location = card.querySelector('.gallery-location').textContent.trim();
            lightboxImg.src = imgSrc;
            lightboxCaption.textContent = title + ' — ' + location;
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % galleryCards.length;
            updateLightbox();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + galleryCards.length) % galleryCards.length;
            updateLightbox();
        }

        galleryCards.forEach((card, index) => {
            card.addEventListener('click', () => openLightbox(index));
        });

        lightboxClose.addEventListener('click', closeLightbox);
        lightboxNext.addEventListener('click', nextSlide);
        lightboxPrev.addEventListener('click', prevSlide);

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextSlide();
            if (e.key === 'ArrowLeft') prevSlide();
        });


    </script>

@endsection