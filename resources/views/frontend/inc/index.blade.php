
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

