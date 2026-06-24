@extends('frontend.layouts.master')

@section('title', __('Project Gallery'))

@section('page-css')
    <link href="{{ asset('resources/frontend/css/gallery.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- ========== PAGE BANNER ========== -->
    <section class="page-banner">
        <div class="hero-grid-overlay"></div>
        <div class="hero-bg-overlay"></div>
        <div class="container">
            <div class="banner-content">
                <span class="banner-tag">Our Projects</span>
                <h1 class="banner-title">Project <span class="text-blue">Gallery</span></h1>
                <p class="banner-desc">Browse our portfolio of sidewalk and concrete repair projects completed across New York City.</p>
            </div>
        </div>
    </section>

    <!-- ========== GALLERY SECTION ========== -->
    <section class="gallery-page-section">
        <div class="container">

            <!-- Category Filters -->
            <div class="gallery-filters">
                <button class="filter-btn active" data-filter="all">All</button>
                @if(!empty($categories))
                    @foreach($categories as $key => $label)
                        <button class="filter-btn" data-filter="{{ $key }}">{{ $label }}</button>
                    @endforeach
                @endif
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-grid">
                @forelse($galleries as $gallery)
                    <div class="gallery-item" data-category="{{ $gallery->category }}">
                        <div class="gal-card">
                            <div class="gal-img-wrap" 
                                 data-before="{{ $gallery->before_image ? asset($gallery->before_image) : '' }}" 
                                 data-after="{{ $gallery->after_image ? asset($gallery->after_image) : '' }}">
                                
                                <img src="{{ $gallery->before_image ? asset($gallery->before_image) : ($gallery->preview_image ? asset($gallery->preview_image) : 'https://placehold.co/800x600?text=No+Image') }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="gal-img">
                                     
                                <div class="gal-zoom-btn">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </div>
                                
                                @if($gallery->before_image && $gallery->after_image)
                                    <div class="gal-ba-toggle">
                                        <button class="ba-btn active" data-state="before">Before</button>
                                        <button class="ba-btn" data-state="after">After</button>
                                    </div>
                                @endif
                            </div>
                            <div class="gal-info">
                                <span class="gal-category">{{ $categories[$gallery->category] ?? 'Uncategorized' }}</span>
                                <h5>{{ $gallery->title }}</h5>
                                @if($gallery->location)
                                    <p class="gal-location">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $gallery->location }}
                                    </p>
                                @endif
                                @if($gallery->year)
                                    <span class="gal-year">{{ $gallery->year }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="gallery-no-results" style="display: block;">
                        <i class="bi bi-image"></i>
                        <h4>No Projects Yet</h4>
                        <p>There are no projects to display at this time.</p>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message (for filtering) -->
            <div class="gallery-no-results" id="noResults" style="display: none;">
                <i class="bi bi-image"></i>
                <h4>No Projects Found</h4>
                <p>There are no projects in this category yet.</p>
            </div>

        </div>
    </section>

    <!-- ========== LIGHTBOX ========== -->
    <div class="lightbox-overlay" id="lightbox">
        <button class="lightbox-close" id="lightboxClose">
            <i class="bi bi-x-lg"></i>
        </button>
        <button class="lightbox-nav lightbox-prev" id="lightboxPrev">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="lightbox-nav lightbox-next" id="lightboxNext">
            <i class="bi bi-chevron-right"></i>
        </button>
        <div class="lightbox-content">
            <img src="" alt="Project Image" id="lightboxImg">
            <div class="lightbox-caption" id="lightboxCaption"></div>
        </div>
    </div>

    @include('frontend.inc.estimate')

@endsection

@section('script')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ========== CATEGORY FILTER ==========
        const filterBtns = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');
        const noResults = document.getElementById('noResults');

        if (!filterBtns.length || !galleryItems.length) {
            console.warn('Gallery elements not found');
            return;
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                let visibleCount = 0;

                galleryItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (noResults) {
                    noResults.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            });
        });

        // ========== BEFORE / AFTER TOGGLE ==========
        document.querySelectorAll('.ba-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const wrap = this.closest('.gal-img-wrap');
                if (!wrap) return;
                
                const img = wrap.querySelector('.gal-img');
                const state = this.getAttribute('data-state');
                const src = wrap.getAttribute('data-' + state);

                if (!img || !src) return;

                wrap.querySelectorAll('.ba-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                img.style.opacity = '0';
                setTimeout(() => {
                    img.src = src;
                    img.style.opacity = '1';
                }, 200);
            });
        });

        // ========== LIGHTBOX ==========
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const lightboxCaption = document.getElementById('lightboxCaption');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxPrev = document.getElementById('lightboxPrev');
        const lightboxNext = document.getElementById('lightboxNext');
        const zoomBtns = document.querySelectorAll('.gal-zoom-btn');
        let currentIndex = 0;
        let visibleItems = [];

        function getVisibleItems() {
            return Array.from(galleryItems).filter(item => item.style.display !== 'none');
        }

        function openLightbox(index) {
            visibleItems = getVisibleItems();
            if (visibleItems.length === 0) return;
            
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
            if (!visibleItems[currentIndex]) return;
            
            const item = visibleItems[currentIndex];
            const img = item.querySelector('.gal-img');
            const title = item.querySelector('h5');
            const locationEl = item.querySelector('.gal-location');

            if (img) lightboxImg.src = img.src;
            if (title) {
                let caption = title.textContent.trim();
                if (locationEl) {
                    caption += ' — ' + locationEl.textContent.trim();
                }
                lightboxCaption.textContent = caption;
            }
        }

        function nextSlide() {
            if (visibleItems.length === 0) return;
            currentIndex = (currentIndex + 1) % visibleItems.length;
            updateLightbox();
        }

        function prevSlide() {
            if (visibleItems.length === 0) return;
            currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
            updateLightbox();
        }

        // Zoom button click
        zoomBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const visibleList = getVisibleItems();
                const galleryItem = this.closest('.gallery-item');
                const actualIndex = visibleList.indexOf(galleryItem);
                openLightbox(actualIndex >= 0 ? actualIndex : 0);
            });
        });

        // Image click
        document.querySelectorAll('.gal-img').forEach(img => {
            img.addEventListener('click', function(e) {
                e.stopPropagation();
                const visibleList = getVisibleItems();
                const galleryItem = this.closest('.gallery-item');
                const actualIndex = visibleList.indexOf(galleryItem);
                openLightbox(actualIndex >= 0 ? actualIndex : 0);
            });
        });

        // Lightbox controls
        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxNext) lightboxNext.addEventListener('click', nextSlide);
        if (lightboxPrev) lightboxPrev.addEventListener('click', prevSlide);

        if (lightbox) {
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) closeLightbox();
            });
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (!lightbox || !lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextSlide();
            if (e.key === 'ArrowLeft') prevSlide();
        });
    });
    </script>
@endsection