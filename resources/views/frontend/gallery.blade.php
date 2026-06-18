@extends('frontend.layouts.master')

@section('title', __('Project Gallery'))


@section('content')



<style>
    /* ============================================
    GALLERY PAGE SECTION
    ============================================ */
    .gallery-page-section {
        padding: 60px 0 100px;
        background: #f5f7fb;
    }

    /* ---- Category Filters ---- */
    .gallery-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 40px;
        justify-content: center;
    }

    .filter-btn {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #6b7280;
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.85rem;
        padding: 10px 22px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        border-color: var(--blue);
        color: var(--blue);
    }

    .filter-btn.active {
        background: var(--blue);
        border-color: var(--blue);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 82, 255, 0.3);
    }

    /* ---- Gallery Grid ---- */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    /* ---- Gallery Item ---- */
    .gallery-item {
        transition: all 0.4s ease;
    }

    .gallery-item.hidden-item {
        opacity: 0;
        transform: scale(0.9);
    }

    /* ---- Gallery Card ---- */
    .gal-card {
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e8ecf4;
        transition: all 0.35s ease;
        height: 100%;
    }

    .gal-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.08);
        border-color: rgba(0, 82, 255, 0.15);
    }

    /* ---- Image Wrap ---- */
    .gal-img-wrap {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        cursor: pointer;
    }

    .gal-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease, opacity 0.25s ease;
    }

    .gal-card:hover .gal-img {
        transform: scale(1.06);
    }

    /* ---- Zoom Button Overlay ---- */
    .gal-zoom-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 38px;
        height: 38px;
        background: rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(4px);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 3;
        cursor: pointer;
    }

    .gal-card:hover .gal-zoom-btn {
        opacity: 1;
    }

    .gal-zoom-btn i {
        color: #ffffff;
        font-size: 1rem;
    }

    .gal-zoom-btn:hover {
        background: var(--blue);
    }

    /* ---- Before / After Toggle ---- */
    .gal-ba-toggle {
        position: absolute;
        bottom: 12px;
        left: 12px;
        display: flex;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        border-radius: 8px;
        overflow: hidden;
        z-index: 3;
    }

    .ba-btn {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.72rem;
        padding: 7px 16px;
        cursor: pointer;
        transition: all 0.25s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .ba-btn:hover {
        color: #ffffff;
    }

    .ba-btn.active {
        background: var(--blue);
        color: #ffffff;
    }

    /* ---- Gallery Info ---- */
    .gal-info {
        padding: 16px 18px 18px;
    }

    .gal-category {
        display: inline-block;
        background: rgba(0, 82, 255, 0.08);
        color: var(--blue);
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.65rem;
        padding: 3px 10px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 8px;
    }

    .gal-info h5 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #111832;
        margin-bottom: 6px;
        line-height: 1.35;
    }

    .gal-location {
        font-size: 0.78rem;
        color: #6b7280;
        margin-bottom: 8px !important;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .gal-location i {
        color: var(--blue);
        font-size: 0.7rem;
    }

    .gal-year {
        font-family: var(--font);
        font-weight: 700;
        font-size: 0.75rem;
        color: #9ca3af;
        letter-spacing: 0.3px;
    }

    /* ---- No Results ---- */
    .gallery-no-results {
        display: none;
        text-align: center;
        padding: 80px 20px;
    }

    .gallery-no-results i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 16px;
        display: block;
    }

    .gallery-no-results h4 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
    }

    .gallery-no-results p {
        font-size: 0.92rem;
        color: #9ca3af;
        margin: 0;
    }

    /* ============================================
    GALLERY RESPONSIVE — TABLET
    ============================================ */
    @media (max-width: 1199.98px) {
        .gallery-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 991.98px) {
        .gallery-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .gallery-page-section {
            padding: 50px 0 80px;
        }
    }

    /* ============================================
    GALLERY RESPONSIVE — MOBILE
    ============================================ */
    @media (max-width: 767.98px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .gallery-page-section {
            padding: 40px 0 70px;
        }

        .gallery-filters {
            gap: 8px;
            margin-bottom: 30px;
        }

        .filter-btn {
            font-size: 0.78rem;
            padding: 8px 16px;
        }

        .gal-info {
            padding: 12px 14px 14px;
        }

        .gal-category {
            font-size: 0.6rem;
            padding: 2px 8px;
        }

        .gal-info h5 {
            font-size: 0.82rem;
        }

        .gal-location {
            font-size: 0.72rem;
        }

        .gal-year {
            font-size: 0.7rem;
        }

        .gal-img-wrap {
            aspect-ratio: 3 / 2.5;
        }

        .ba-btn {
            font-size: 0.65rem;
            padding: 6px 12px;
        }

        .gal-zoom-btn {
            width: 32px;
            height: 32px;
        }

        .gal-zoom-btn i {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 575.98px) {
        .gallery-grid {
            gap: 10px;
        }

        .gal-info h5 {
            font-size: 0.78rem;
            line-height: 1.3;
        }

        .gal-location {
            font-size: 0.68rem;
            margin-bottom: 6px !important;
        }

        .gal-year {
            font-size: 0.65rem;
        }

        .gal-img-wrap {
            aspect-ratio: 4 / 3.5;
        }
    }
</style>




    <!-- ========== PAGE BANNER ========== -->
    <section class="page-banner">
        <div class="banner-overlay"></div>
        <div class="container">
            <div class="banner-content">
                <span class="banner-tag">Our Portfolio</span>
                <h1 class="banner-title">Project <span class="text-blue">Gallery</span></h1>
                <p class="banner-desc">Browse our portfolio of sidewalk and concrete repair projects completed across New York City. See the before and after results of our work.</p>
                <div class="banner-breadcrumb">
                    <a href="#">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Gallery</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== GALLERY SECTION ========== -->
    <section class="gallery-page-section">
        <div class="container">

            <!-- Category Filters -->
            <div class="gallery-filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="dot-violations">DOT Violations</button>
                <button class="filter-btn" data-filter="sidewalk-repair">Sidewalk Repair</button>
                <button class="filter-btn" data-filter="concrete-replacement">Concrete Replacement</button>
                <button class="filter-btn" data-filter="driveway">Driveway</button>
                <button class="filter-btn" data-filter="ada-ramps">ADA Ramps</button>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-grid">

                <!-- Project 1 -->
                <div class="gallery-item" data-category="dot-violations">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80" data-after="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80" alt="Flatbush Avenue Violation" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">DOT Violations</span>
                            <h5>Flatbush Avenue Sidewalk</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> Flatbush Avenue, Brooklyn</p>
                            <span class="gal-year">2025</span>
                        </div>
                    </div>
                </div>

                <!-- Project 2 -->
                <div class="gallery-item" data-category="dot-violations">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80" data-after="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80" alt="Flushing Violation" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">DOT Violations</span>
                            <h5>Flushing Main Street Repair</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> Flushing, Queens</p>
                            <span class="gal-year">2024</span>
                        </div>
                    </div>
                </div>

                <!-- Project 3 -->
                <div class="gallery-item" data-category="sidewalk-repair">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80" data-after="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80" alt="Park Slope Repair" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">Sidewalk Repair</span>
                            <h5>Park Slope Crack Repair</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> Park Slope, Brooklyn</p>
                            <span class="gal-year">2025</span>
                        </div>
                    </div>
                </div>

                <!-- Project 4 -->
                <div class="gallery-item" data-category="concrete-replacement">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" data-after="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="Harlem Replacement" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">Concrete Replacement</span>
                            <h5>Harlem Full Replacement</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> Harlem, Manhattan</p>
                            <span class="gal-year">2024</span>
                        </div>
                    </div>
                </div>

                <!-- Project 5 -->
                <div class="gallery-item" data-category="driveway">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800&q=80" data-after="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800&q=80" alt="Throgs Neck Driveway" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">Driveway</span>
                            <h5>Throgs Neck Driveway</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> Throgs Neck, Bronx</p>
                            <span class="gal-year">2025</span>
                        </div>
                    </div>
                </div>

                <!-- Project 6 -->
                <div class="gallery-item" data-category="ada-ramps">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80" data-after="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80" alt="Staten Island ADA Ramp" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">ADA Ramps</span>
                            <h5>St. George ADA Ramp</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> St. George, Staten Island</p>
                            <span class="gal-year">2024</span>
                        </div>
                    </div>
                </div>

                <!-- Project 7 -->
                <div class="gallery-item" data-category="sidewalk-repair">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80" data-after="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80" alt="Astoria Repair" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">Sidewalk Repair</span>
                            <h5>Astoria Trip Hazard Fix</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> Astoria, Queens</p>
                            <span class="gal-year">2025</span>
                        </div>
                    </div>
                </div>

                <!-- Project 8 -->
                <div class="gallery-item" data-category="concrete-replacement">
                    <div class="gal-card">
                        <div class="gal-img-wrap" data-before="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80" data-after="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80">
                            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80" alt="Williamsburg Replacement" class="gal-img">
                            <div class="gal-zoom-btn">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                            <div class="gal-ba-toggle">
                                <button class="ba-btn active" data-state="before">Before</button>
                                <button class="ba-btn" data-state="after">After</button>
                            </div>
                        </div>
                        <div class="gal-info">
                            <span class="gal-category">Concrete Replacement</span>
                            <h5>Williamsburg Slab Replacement</h5>
                            <p class="gal-location"><i class="bi bi-geo-alt-fill"></i> Williamsburg, Brooklyn</p>
                            <span class="gal-year">2024</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- No Results Message -->
            <div class="gallery-no-results" id="noResults">
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

                // Update button states
                wrap.querySelectorAll('.ba-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Fade transition
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
            const location = item.querySelector('.gal-location').textContent.trim();
            lightboxImg.src = img.src;
            lightboxCaption.textContent = title + ' — ' + location;
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

        zoomBtns.forEach((btn, i) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const visibleList = getVisibleItems();
                const actualIndex = visibleList.indexOf(btn.closest('.gallery-item'));
                openLightbox(actualIndex >= 0 ? actualIndex : 0);
            });
        });

        // Also open on image click
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




    <script>
        // Navbar scroll
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 40);
        });

        // Form submit feedback
        document.getElementById('checkForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('.btn-submit');
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Submitted!';
            btn.style.background = '#22c55e';
            setTimeout(() => {
                btn.innerHTML = orig;
                btn.style.background = '';
                this.reset();
            }, 2500);
        });

        // Estimate form
        document.getElementById('estimateForm').addEventListener('submit', function(e) {
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





    </script>

@endsection