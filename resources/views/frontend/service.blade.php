@extends('frontend.layouts.master')

@section('page-css')
    <link href="{{ asset('resources/frontend/css/service.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<!-- ========== PAGE BANNER ========== -->
<section class="page-banner">
    <div class="banner-overlay"></div>
    <div class="container">
        <div class="banner-content">
            <h1 class="banner-title">NYC Sidewalk &<br><span class="text-blue">Concrete Services</span></h1>
            <p class="banner-desc">From emergency violation removal to new concrete installation, we provide comprehensive sidewalk solutions for property owners across all five boroughs.</p>
            <div class="banner-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="bi bi-chevron-right"></i>
                <span>Services</span>
            </div>
        </div>
    </div>
</section>

<!-- ========== SERVICES ACCORDION ========== -->
<section class="svc-section" id="services">
    <div class="container">
        <div class="accordion" id="servicesAccordion">

            @foreach($services as $index => $service)
                @php
                    $isFirst  = $index === 0;
                    $num      = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $features = is_array($service->features) ? $service->features : [];
                @endphp

                <div class="accordion-item svc-item {{ $isFirst ? 'active-item' : '' }}" id="service-{{ $service->slug }}">
                    <h2 class="accordion-header" id="heading{{ $num }}">
                        <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }} svc-btn"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $num }}"
                                aria-expanded="{{ $isFirst ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $num }}">
                            <span class="svc-num">{{ $num }}</span>
                            <span class="svc-icon"><i class="{{ $service->icon }}"></i></span>
                            <div class="svc-btn-text">
                                <span class="svc-btn-title">{{ $service->title }}</span>
                                <span class="svc-btn-sub">{{ $service->subtitle }}</span>
                            </div>
                            @if($service->urgent_tag)
                                <span class="svc-urgent">{{ $service->urgent_tag }}</span>
                            @endif
                        </button>
                    </h2>
                    <div id="collapse{{ $num }}"
                         class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}"
                         aria-labelledby="heading{{ $num }}"
                         data-bs-parent="#servicesAccordion">
                        <div class="accordion-body svc-body">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="svc-body-content">
                                        @if($service->badge)
                                            <span class="svc-badge {{ $service->badge_type ?? $service->badge_class }}">{{ $service->badge }}</span>
                                        @endif
                                        <h3>{{ $service->heading ?? $service->title }}</h3>
                                        {!! nl2br(e($service->description)) !!}
                                        @if($service->description_two)
                                            {!! nl2br(e($service->description_two)) !!}
                                        @endif
                                        @if(!empty($features))
                                            <div class="svc-features">
                                                @foreach($features as $feature)
                                                    <div class="svc-feature">
                                                        <!-- Use the dynamic icon from DB, fallback to default if missing -->
                                                        <i class="{{ $feature['icon'] ?? 'bi bi-check-circle-fill' }}"></i>
                                                        <!-- Target the 'text' key of the array -->
                                                        <span>{{ $feature['text'] }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <a href="{{ $service->btn_link ?? route('contact') }}" class="btn-svc">
                                            {{ $service->btn_text ?? 'Get Free Estimate' }} <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="svc-body-img">
                                        @if($service->image)
                                            <img src="{{ asset('uploads/service/' . $service->image) }}"
                                                 alt="{{ $service->title }}">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80"
                                                 alt="{{ $service->title }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>


    @include('frontend.inc.estimate')

@endsection

@section('script')
    <script>
        // Add active class styling on accordion toggle
        const accordionItems = document.querySelectorAll('.svc-item');
        accordionItems.forEach(item => {
            const collapse = item.querySelector('.accordion-collapse');

            collapse.addEventListener('show.bs.collapse', () => {
                accordionItems.forEach(i => i.classList.remove('active-item'));
                item.classList.add('active-item');
            });

            collapse.addEventListener('hide.bs.collapse', () => {
                item.classList.remove('active-item');
            });
        });

        // Smooth scroll to accordion item when clicking
        document.querySelectorAll('.svc-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const item = this.closest('.svc-item');
                if (!item.classList.contains('active-item')) {
                    setTimeout(() => {
                        const offset = 90;
                        const top = item.getBoundingClientRect().top + window.pageYOffset - offset;
                        window.scrollTo({ top, behavior: 'smooth' });
                    }, 350);
                }
            });
        });

        // Scroll to specific service from anchor links (e.g., /service#sidewalk-repair)
        (function() {
            const hash = window.location.hash;
            if (hash) {
                const target = document.querySelector(hash);
                if (target) {
                    setTimeout(() => {
                        const collapse = target.querySelector('.accordion-collapse');
                        if (collapse && !collapse.classList.contains('show')) {
                            const btn = target.querySelector('.svc-btn');
                            if (btn) btn.click();
                        }
                        setTimeout(() => {
                            const offset = 90;
                            const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                            window.scrollTo({ top, behavior: 'smooth' });
                        }, 400);
                    }, 300);
                }
            }
        })();
    </script>
@endsection