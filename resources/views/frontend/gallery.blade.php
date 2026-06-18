@extends('frontend.layouts.master')

@section('title', __('Project Gallery'))
@section('page-css')
    <link href="{{ asset('resources/frontend/css/gallery.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- ========== PAGE BANNER ========== -->
    <section class="page-banner">
        <div class="banner-overlay"></div>
        <div class="container">
            <div class="banner-content">
                <span class="banner-tag">Our Portfolio</span>
                <h1 class="banner-title">Project <span class="text-blue">Gallery</span></h1>
                <p class="banner-desc">Browse our portfolio of sidewalk and concrete repair projects completed across New York City. See the before and after results of our work.</p>
                <div class="banner-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Gallery</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== GALLERY SECTION ========== -->
    <section class="gallery-page-section">
        <div class="container">

            <!-- Dynamic Category Filters -->
            <div class="gallery-filters">
                <button class="filter-btn active" data-filter="all">All</button>
                @foreach(App\Models\Gallery::getCategoryOptions() as $key => $label)
                    <button class="filter-btn" data-filter="{{ $key }}">{{ $label }}</button>
                @endforeach
            </div>

            <!-- Dynamic Gallery Grid -->
            <div class="gallery-grid">
                @foreach($galleries as $gallery)
                    <div class="gallery-item" data-category="{{ $gallery->category }}">
                        <div class="gal-card">
                            <div class="gal-img-wrap" 
                                 data-before="{{ asset($gallery->before_image) }}" 
                                 data-after="{{ asset($gallery->after_image) }}">
                                
                                <img src="{{ asset($gallery->before_image ?? $gallery->preview_image) }}" 
                                     alt="{{ $gallery->title }}" class="gal-img"
                                     onerror="this.src='https://via.placeholder.com/800x600?text=No+Image'">
                                     
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
                                <span class="gal-category">{{ App\Models\Gallery::getCategoryOptions()[$gallery->category] ?? 'Uncategorized' }}</span>
                                <h5>{{ $gallery->title }}</h5>
                                @if($gallery->location)
                                    <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> {{ $gallery->location }}</p>
                                @endif
                                @if($gallery->year)
                                    <span class="gal-year">{{ $gallery->year }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div class="gallery-no-results" id="noResults" style="display: none;">
                <i class="bi bi-image"></i>
                <h4>No Projects Found</h4>
                <p>There are no projects in this category yet. Please check back later.</p>
            </div>

        </div>
    </section>

    <!-- ========== LIGHTBOX ========== -->
    <div class="lightbox-overlay" id="lightbox">
        <button class="lightbox-close" id="lightboxClose"><i class="bi bi-x-lg"></i></button>
        <button class="lightbox-nav lightbox-prev" id="lightboxPrev"><i class="bi bi-chevron-left"></i></button>
        <button class="lightbox-nav lightbox-next" id="lightboxNext"><i class="bi bi-chevron-right"></i></button>
        <div class="lightbox-content">
            <img src="" alt="Project Image" id="lightboxImg">
            <div class="lightbox-caption" id="lightboxCaption"></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // ========== CATEGORY FILTER ==========
        const filterBtns = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');
        const noResults = document.getElementById('noResults');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');
                let visibleCount = 0;

                galleryItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            });
        });

        // ========== BEFORE / AFTER TOGGLE ==========
        document.querySelectorAll('.ba-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const wrap = this.closest('.gal-img-wrap');
                const img = wrap.querySelector('.gal-img');
                const state = this.getAttribute('data-state');
                const src = wrap.getAttribute('data-' + state);

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
            const item = visibleItems[currentIndex];
            const img = item.querySelector('.gal-img');
            const title = item.querySelector('h5').textContent;
            const locationEl = item.querySelector('.gal-location');
            const locationText = locationEl ? locationEl.textContent.trim() : '';
            lightboxImg.src = img.src;
            lightboxCaption.textContent = title + (locationText ? ' — ' + locationText : '');
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

        zoomBtns.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const visibleList = getVisibleItems();
                const actualIndex = visibleList.indexOf(btn.closest('.gallery-item'));
                openLightbox(actualIndex >= 0 ? actualIndex : 0);
            });
        });

        document.querySelectorAll('.gal-img').forEach(img => {
            img.addEventListener('click', (e) => {
                e.stopPropagation();
                const visibleList = getVisibleItems();
                const actualIndex = visibleList.indexOf(img.closest('.gallery-item'));
                openLightbox(actualIndex >= 0 ? actualIndex : 0);
            });
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