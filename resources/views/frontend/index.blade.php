@extends('frontend.layouts.master')

@section('content')


    <!-- ========== HERO SECTION ========== -->
    <section class="hero-section"
        @if($slider && $slider->image)
            style="background-image: url('{{ asset('uploads/slider/' . $slider->image) }}');"
        @endif
        >
        <div class="hero-bg-overlay"></div>
        <div class="container">
            <div class="row align-items-center hero-row">
                <!-- Left Content -->
                <div class="col-lg-6 hero-left">
                    <h1 class="hero-title">
                        {!! $slider->title ?? 'Does Your Sidewalk Have <span class="text-blue">Violations?</span>' !!}
                    </h1>
                    <p class="hero-desc">
                        {{ $slider->subtitle ?? 'Enter your New York property information below to check for any sidewalk violations. We help property owners resolve DOT violations quickly and affordably.' }}
                    </p>
                    @php
                        // Check if already an array (Laravel auto-casts JSON columns)
                        $highlights = is_array($slider->highlights) ? $slider->highlights : [];
                        $defaultHighlights = [
                            ['icon' => 'bi bi-check-circle-fill', 'text' => 'Free Property Inspection'],
                            ['icon' => 'bi bi-check-circle-fill', 'text' => 'DOT Violation Experts'],
                            ['icon' => 'bi bi-check-circle-fill', 'text' => 'Fast & Affordable Repairs'],
                        ];
                        $highlights = !empty($highlights) ? $highlights : $defaultHighlights;
                    @endphp
                    <div class="hero-highlights">
                        @foreach($highlights as $item)
                            <div class="highlight-item">
                                <i class="{{ $item['icon'] ?? 'bi bi-check-circle-fill' }}"></i>
                                <span>{{ $item['text'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Form -->
                <div class="col-lg-6 hero-right">
                    <div class="hero-form-card">
                        <div class="form-card-header">
                            <i class="bi bi-search"></i>
                            <h3>Check My Property</h3>
                        </div>
                        <form id="checkForm" action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Property Address" value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="Full Name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-submit">
                                Check Now
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
    </section>


    <!-- ========== SERVICES SECTION ========== -->
    <section class="services-section">
        <div class="container">
            <div class="services-header text-center">
                <span class="services-tag">Our Services</span>
                <h2 class="services-title">Comprehensive Sidewalk &<br><span class="text-blue">Concrete Services</span></h2>
                <p class="services-desc">From violation removal to complete concrete installation, we provide end-to-end sidewalk solutions for property owners across New York City.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-shield-exclamation"></i>
                        </div>
                        <h5>DOT Sidewalk Violation Removal</h5>
                        <p>Complete violation resolution including permit filing, repair, and DOT inspection coordination.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-wrench-adjustable"></i>
                        </div>
                        <h5>Sidewalk Repair</h5>
                        <p>Targeted repairs for cracks, chips, uneven surfaces, and trip hazards without full replacement.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-bricks"></i>
                        </div>
                        <h5>Concrete Installation</h5>
                        <p>New concrete sidewalk installation with DOT-compliant materials and professional finishing.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h5>Concrete Replacement</h5>
                        <p>Full slab removal and replacement using NYC-approved concrete mix and specifications.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-layers"></i>
                        </div>
                        <h5>Sidewalk Replacement</h5>
                        <p>Complete sidewalk reconstruction for severely damaged or non-compliant walkways.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-signpost-split"></i>
                        </div>
                        <h5>Curb & Gutter</h5>
                        <p>Professional curb and gutter work to meet city specifications and drainage requirements.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-house-door"></i>
                        </div>
                        <h5>Driveway Installation</h5>
                        <p>Residential and commercial driveway concrete work with proper slope and finishing.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-universal-access-circle"></i>
                        </div>
                        <h5>ADA Ramps</h5>
                        <p>ADA-compliant wheelchair ramp installation meeting all accessibility standards and codes.</p>
                    </div>
                </div>
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