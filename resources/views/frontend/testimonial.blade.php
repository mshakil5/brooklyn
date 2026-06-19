@extends('frontend.layouts.master')

@section('title', __('Reviews & Testimonials'))


@section('content')






<!-- ========== PAGE BANNER ========== -->
<section class="page-banner">
    <div class="banner-overlay"></div>
            <!-- Grid Pattern Overlay -->
            <div class="hero-grid-overlay"></div>
    <div class="container">
        <div class="banner-content">
            <span class="banner-tag">Client Reviews</span>
            <h1 class="banner-title">What <span class="text-blue"> Our Clients Say</span></h1>
            <p class="banner-desc">Over 500 verified reviews from property owners across all five boroughs of New York City.</p>
        </div>
    </div>
</section>



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





    @include('frontend.inc.estimate')

@endsection

@section('script')

@endsection