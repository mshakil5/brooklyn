@extends('frontend.layouts.master')
@section('page-css')
    <link href="{{ asset('resources/frontend/css/about.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <!-- ========== ABOUT HERO SECTION ========== -->
    <section class="about-hero">
        <div class="container">
            <div class="about-hero-content text-center">
                <span class="about-tag">{{ $aboutPage->hero_tag ?? '' }}</span>
                <h1 class="about-hero-title">{!! $aboutPage->hero_title ?? '' !!}</h1>
                <p class="about-hero-desc">{{ $aboutPage->hero_description ?? '' }}</p>
            </div>

            
    
            <!-- Grid Pattern Overlay -->
            <div class="hero-grid-overlay"></div>

            <!-- Stats Grid -->
            <div class="about-stats-grid">
                @foreach($stats as $stat)
                    <div class="about-stat-card">
                        <div class="about-stat-icon">
                            <i class="{!! $stat->icon !!}"></i>
                        </div>
                        <div class="about-stat-number">{{ $stat->number }}</div>
                        <div class="about-stat-label">{{ $stat->label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========== OUR STORY SECTION ========== -->
    <section class="about-story">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="story-content">
                        <span class="story-tag">{{ $aboutPage->story_tag ?? '' }}</span>
                        <h2 class="story-title">{!! $aboutPage->story_title ?? '' !!}</h2>
                        <div class="story-text">
                            {!! $aboutPage->story_content ?? '' !!}
                        </div>
                        <div class="story-highlights">
                            @foreach($highlights as $highlight)
                                <div class="story-highlight">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ $highlight->text }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="story-image">
                        @if($aboutPage->story_image)
                            <img src="{{ asset($aboutPage->story_image) }}" alt="Our construction team at work">
                        @else
                            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="Our construction team at work">
                        @endif
                        
                        @if($aboutPage->badge_rating)
                            <div class="story-badge">
                                <i class="bi bi-award-fill"></i>
                                <div>
                                    <span class="badge-rating">{{ $aboutPage->badge_rating }}</span>
                                    <span class="badge-label">{{ $aboutPage->badge_label }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== MILESTONES SECTION ========== -->
    <section class="milestones-section">
        <div class="container">
            <div class="milestones-header text-center">
                <span class="milestones-tag">Our Journey</span>
                <h2 class="milestones-title">Company <span class="text-blue">Milestones</span></h2>
                <p class="milestones-desc">From a small Brooklyn startup to NYC's most trusted sidewalk contractor — here's how we got here.</p>
            </div>

            <div class="timeline">
                @foreach($milestones as $index => $milestone)
                    <!-- Alternate left/right classes based on loop index -->
                    <div class="timeline-item {{ $loop->odd ? 'left' : 'right' }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <span class="timeline-year">{{ $milestone->year }}</span>
                            <h4>{{ $milestone->title }}</h4>
                            <p>{{ $milestone->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========== CORE VALUES SECTION ========== -->
    <section class="values-section">
        <div class="container">
            <div class="values-header text-center">
                <span class="values-tag">What We Stand For</span>
                <h2 class="values-title">Our Core <span class="text-blue">Values</span></h2>
                <p class="values-desc">These principles guide everything we do — from the first estimate to the final inspection.</p>
            </div>
            <div class="row g-4">
                @foreach($values as $value)
                    <div class="col-md-6 col-lg-3">
                        <div class="value-card">
                            <div class="value-icon">
                                <i class="{!! $value->icon !!}"></i>
                            </div>
                            <h4>{{ $value->title }}</h4>
                            <p>{{ $value->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========== LICENSED & CERTIFIED SECTION ========== -->
    <section class="certs-section">
        <div class="container">
            <div class="certs-header text-center">
                <span class="certs-tag">Trust & Credentials</span>
                <h2 class="certs-title">Licensed, Insured & <span class="text-blue">Certified</span></h2>
                <p class="certs-desc">Your peace of mind matters. Here's proof that you're working with a legitimate, fully qualified contractor.</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($certs as $cert)
                    <div class="col-md-6 col-lg-4">
                        <div class="cert-card">
                            <div class="cert-card-icon">
                                <i class="{!! $cert->icon !!}"></i>
                            </div>
                            <h4>{{ $cert->title }}</h4>
                            <div class="cert-license">
                                <span class="license-label">{{ $cert->license_label }}</span>
                                <span class="license-number {{ $cert->license_class ?? '' }}">{{ $cert->license_number }}</span>
                            </div>
                            <p>{{ $cert->description }}</p>
                            <div class="cert-status">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ $cert->status_text }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    
    @include('frontend.inc.estimate')

@endsection