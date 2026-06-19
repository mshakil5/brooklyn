@extends('frontend.layouts.master')

@section('content')


<style>

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
                    @php
                        $defaultTitle = 'Does Your Sidewalk<br>Have <span class="text-blue">Violations?</span>';
                        $title = $slider->title ?? $defaultTitle;
                        
                        // If title doesn't contain HTML span, wrap the last word in blue
                        if (strpos($title, '<span') === false) {
                            // Split by spaces and wrap last word
                            $words = explode(' ', $title);
                            if (count($words) > 0) {
                                $lastWord = array_pop($words);
                                $words[] = '<span class="text-blue">' . $lastWord . '</span>';
                                $title = implode(' ', $words);
                            }
                        }
                        
                        // Handle line breaks - convert \n to <br> if present
                        $title = nl2br($title);
                    @endphp
                    {!! $title !!}
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









    @if($galleries->count() > 0)
    <!-- ========== RECENT PROJECTS GALLERY ========== -->
    <section class="projects-section">
        <div class="container">
            <div class="projects-top-row">
                <div class="projects-header-left">
                    <span class="section-tag">Our Work</span>
                    <h2 class="section-title">Recent <span class="text-blue">Projects</span></h2>
                </div>
                <a href="{{ route('gallery') }}" class="btn-gallery-link">
                    View Full Gallery <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            
            @if($galleries->count() > 0)
            <div class="row g-3">
                @foreach($galleries as $gallery)
                    <div class="col-6 col-lg-3">
                        <div class="gallery-card" data-img="{{ asset($gallery->after_image ?? $gallery->before_image) }}">
                            <div class="gallery-img">
                                <img src="{{ asset($gallery->after_image ?? $gallery->before_image) }}" 
                                     alt="{{ $gallery->title }}"
                                     onerror="this.src='https://via.placeholder.com/600x400?text=No+Image'">
                                <div class="gallery-zoom">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </div>
                            </div>
                            <div class="gallery-info">
                                <span class="gallery-category">{{ App\Models\Gallery::getCategoryOptions()[$gallery->category] ?? 'Uncategorized' }}</span>
                                <h5>{{ $gallery->title }}</h5>
                                @if($gallery->location)
                                    <p class="gallery-location">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $gallery->location }}
                                    </p>
                                @endif
                                @if($gallery->year)
                                    <span class="gallery-year">{{ $gallery->year }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
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
    @endif




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

    <script>
        // ========== HOMEPAGE LIGHTBOX ==========
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const lightboxCaption = document.getElementById('lightboxCaption');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxPrev = document.getElementById('lightboxPrev');
        const lightboxNext = document.getElementById('lightboxNext');
        const galleryCards = document.querySelectorAll('.projects-section .gallery-card');
        let currentIndex = 0;

        if (galleryCards.length > 0) {
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
                
                // Safely get location text without the icon text
                const locationEl = card.querySelector('.gallery-location');
                const locationText = locationEl ? locationEl.textContent.trim() : '';
                
                lightboxImg.src = imgSrc;
                lightboxCaption.textContent = title + (locationText ? ' — ' + locationText : '');
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
        }
    </script>

@endsection