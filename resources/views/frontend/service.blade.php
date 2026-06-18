@extends('frontend.layouts.master')

@section('content')

<style>

    /* ============================================
    SERVICES ACCORDION SECTION
    ============================================ */
    .svc-section {
        padding: 80px 0 100px;
        background: #f5f7fb;
    }

    /* Accordion Items */
    .svc-item {
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        margin-bottom: 14px;
        overflow: hidden;
        background: #ffffff;
        transition: all 0.35s ease;
    }

    .svc-item:last-child {
        margin-bottom: 0;
    }

    .svc-item.active-item {
        border-color: rgba(0, 82, 255, 0.2) !important;
        box-shadow: 0 8px 30px rgba(0, 82, 255, 0.08);
    }

    /* Accordion Button */
    .svc-btn {
        background: #ffffff !important;
        border: none !important;
        border-radius: 14px !important;
        padding: 20px 24px !important;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: none !important;
        transition: all 0.3s ease;
    }

    .svc-btn:not(.collapsed) {
        background: #ffffff !important;
        color: var(--text-dark) !important;
    }

    .svc-btn::after {
        display: none !important;
    }

    /* Service Number */
    .svc-num {
        font-family: var(--font);
        font-size: 1.5rem;
        font-weight: 800;
        color: #e2e8f0;
        min-width: 40px;
        transition: color 0.3s ease;
        line-height: 1;
    }

    .active-item .svc-num {
        color: var(--blue);
    }

    /* Service Icon */
    .svc-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        background: rgba(0, 82, 255, 0.06);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .svc-icon i {
        font-size: 1.3rem;
        color: var(--blue);
        transition: all 0.3s ease;
    }

    .active-item .svc-icon {
        background: var(--blue);
    }

    .active-item .svc-icon i {
        color: #ffffff;
    }

    /* Button Text */
    .svc-btn-text {
        flex: 1;
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .svc-btn-title {
        font-family: var(--font);
        font-size: 1.05rem;
        font-weight: 700;
        color: #111832;
        line-height: 1.3;
        margin-bottom: 3px;
    }

    .svc-btn-sub {
        font-size: 0.82rem;
        color: #6b7280;
        font-weight: 400;
        line-height: 1.4;
    }

    /* Urgent Badge */
    .svc-urgent {
        display: none;
        background: #ef4444;
        color: #ffffff;
        font-family: var(--font);
        font-weight: 700;
        font-size: 0.65rem;
        padding: 4px 12px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 1px;
        animation: urgentPulse 2s ease-in-out infinite;
    }

    @keyframes urgentPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Expand/Collapse Arrow */
    .svc-btn .svc-arrow {
        width: 36px;
        height: 36px;
        min-width: 36px;
        background: #f5f7fb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .svc-btn .svc-arrow i {
        font-size: 0.9rem;
        color: #6b7280;
        transition: transform 0.3s ease;
    }

    .svc-btn:not(.collapsed) .svc-arrow {
        background: var(--blue);
    }

    .svc-btn:not(.collapsed) .svc-arrow i {
        color: #ffffff;
        transform: rotate(180deg);
    }

    /* ============================================
    ACCORDION BODY CONTENT
    ============================================ */
    .svc-body {
        padding: 0 !important;
        border-top: 1px solid #e2e8f0;
    }

    .svc-body-content {
        padding: 40px 30px 40px 24px;
    }

    .svc-badge {
        display: inline-block;
        background: rgba(0, 82, 255, 0.08);
        color: var(--blue);
        font-family: var(--font);
        font-weight: 700;
        font-size: 0.68rem;
        padding: 5px 14px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .svc-badge.urgent {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .svc-body-content h3 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #111832;
        margin-bottom: 16px;
        letter-spacing: -0.3px;
    }

    .svc-body-content p {
        font-size: 0.92rem;
        color: #6b7280;
        line-height: 1.8;
        margin-bottom: 14px;
    }

    /* Service Features */
    .svc-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin: 28px 0 32px;
    }

    .svc-feature {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        font-weight: 500;
        color: #374151;
    }

    .svc-feature i {
        color: var(--blue);
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    /* Service CTA Button */
    .btn-svc {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--blue);
        color: #ffffff;
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.95rem;
        padding: 14px 30px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-svc:hover {
        background: var(--blue-hover);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 82, 255, 0.3);
    }

    .btn-svc i {
        transition: transform 0.3s ease;
    }

    .btn-svc:hover i {
        transform: translateX(4px);
    }

    /* Service Image */
    .svc-body-img {
        height: 100%;
        min-height: 400px;
        overflow: hidden;
    }

    .svc-body-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ============================================
    RESPONSIVE — TABLET
    ============================================ */
    @media (max-width: 991.98px) {
        .banner-title {
            font-size: 2.4rem;
        }

        .svc-btn {
            padding: 16px 20px !important;
            gap: 14px;
        }

        .svc-num {
            font-size: 1.2rem;
            min-width: 32px;
        }

        .svc-icon {
            width: 46px;
            height: 46px;
            min-width: 46px;
        }

        .svc-icon i {
            font-size: 1.15rem;
        }

        .svc-btn-title {
            font-size: 0.95rem;
        }

        .svc-body-content {
            padding: 30px 24px;
        }

        .svc-body-content h3 {
            font-size: 1.35rem;
        }

        .svc-body-img {
            min-height: 300px;
            margin-top: 0;
        }

        .svc-features {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }

    /* ============================================
    RESPONSIVE — MOBILE
    ============================================ */
    @media (max-width: 767.98px) {
        .page-banner {
            padding: 140px 0 70px;
        }

        .banner-title {
            font-size: 1.8rem;
        }

        .banner-desc {
            font-size: 0.92rem;
        }

        .svc-section {
            padding: 50px 0 70px;
        }

        .svc-btn {
            padding: 14px 16px !important;
            gap: 12px;
            flex-wrap: wrap;
        }

        .svc-num {
            font-size: 1rem;
            min-width: 26px;
        }

        .svc-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: 10px;
        }

        .svc-icon i {
            font-size: 1rem;
        }

        .svc-btn-title {
            font-size: 0.88rem;
        }

        .svc-btn-sub {
            font-size: 0.76rem;
        }

        .svc-urgent {
            display: inline-block;
        }

        .svc-body-content {
            padding: 24px 18px;
        }

        .svc-body-content h3 {
            font-size: 1.2rem;
        }

        .svc-body-content p {
            font-size: 0.86rem;
        }

        .svc-feature {
            font-size: 0.84rem;
        }

        .svc-body-img {
            min-height: 250px;
        }

        .btn-svc {
            width: 100%;
            justify-content: center;
            padding: 13px 24px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 575.98px) {
        .banner-title {
            font-size: 1.55rem;
        }

        .svc-num {
            display: none;
        }

        .svc-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
        }

        .svc-icon i {
            font-size: 0.9rem;
        }

        .svc-body-img {
            min-height: 200px;
        }
    }
</style>




<!-- ========== PAGE BANNER ========== -->
<section class="page-banner">
    <div class="banner-overlay"></div>
    <div class="container">
        <div class="banner-content">
            <span class="banner-tag">What We Do</span>
            <h1 class="banner-title">NYC Sidewalk &<br><span class="text-blue">Concrete Services</span></h1>
            <p class="banner-desc">From emergency violation removal to new concrete installation, we provide comprehensive sidewalk solutions for property owners across all five boroughs.</p>
            <div class="banner-breadcrumb">
                <a href="#">Home</a>
                <i class="bi bi-chevron-right"></i>
                <span>Services</span>
            </div>
        </div>
    </div>
</section>

<!-- ========== SERVICES ACCORDION ========== -->
<section class="svc-section">
    <div class="container">
        <div class="accordion" id="servicesAccordion">

            <!-- Service 1: DOT Violation Removal -->
            <div class="accordion-item svc-item active-item">
                <h2 class="accordion-header" id="heading1">
                    <button class="accordion-button svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        <span class="svc-num">01</span>
                        <span class="svc-icon"><i class="bi bi-shield-exclamation"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">DOT Violation Removal</span>
                            <span class="svc-btn-sub">Complete violation resolution from filing to dismissal</span>
                        </div>
                        <span class="svc-urgent">URGENT</span>
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <span class="svc-badge urgent">URGENT SERVICE</span>
                                    <h3>DOT Sidewalk Violation Removal</h3>
                                    <p>Received a DOT sidewalk violation notice? Don't panic. We handle the entire process from start to finish — permit filing, concrete repair or replacement, and DOT inspection coordination to get your violation dismissed quickly.</p>
                                    <p>NYC property owners are legally responsible for maintaining sidewalks adjacent to their property. Failure to address a DOT violation can result in fines up to $1,000 per day. Our team resolves violations fast and affordably.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>24-Hour Emergency Response</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Full Permit & Filing Handling</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>DOT-Compliant Materials & Methods</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Inspection Coordination Included</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Violation Dismissal Guaranteed</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Get Free Estimate <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80" alt="DOT Violation Removal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 2: Sidewalk Repair -->
            <div class="accordion-item svc-item">
                <h2 class="accordion-header" id="heading2">
                    <button class="accordion-button collapsed svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        <span class="svc-num">02</span>
                        <span class="svc-icon"><i class="bi bi-wrench-adjustable"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">Sidewalk Repair</span>
                            <span class="svc-btn-sub">Targeted fixes for cracks, chips & trip hazards</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <span class="svc-badge">POPULAR</span>
                                    <h3>Professional Sidewalk Repair</h3>
                                    <p>Not every damaged sidewalk needs full replacement. Our expert team evaluates the condition and performs targeted repairs for cracks, chips, uneven surfaces, and trip hazards — saving you time and money.</p>
                                    <p>We use advanced concrete repair techniques including leveling, patching, and grinding to restore your sidewalk to safe, code-compliant condition without the cost of complete replacement.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Crack & Chip Patching</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Surface Leveling & Grinding</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Trip Hazard Elimination</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Color-Matched Concrete Finish</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Same-Day Service Available</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Get Free Estimate <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="Sidewalk Repair">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 3: Concrete Installation -->
            <div class="accordion-item svc-item">
                <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        <span class="svc-num">03</span>
                        <span class="svc-icon"><i class="bi bi-bricks"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">Concrete Installation</span>
                            <span class="svc-btn-sub">New sidewalk & concrete work from scratch</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <span class="svc-badge">PREMIUM</span>
                                    <h3>New Concrete Installation</h3>
                                    <p>Need a brand new sidewalk or concrete surface? Our installation team delivers flawless results using NYC DOT-approved concrete mixes, proper reinforcement, and professional finishing techniques.</p>
                                    <p>Every new installation meets or exceeds city code requirements, including proper slope for drainage, correct thickness, and expansion joints for long-term durability.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>DOT-Approved Concrete Mix</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Proper Reinforcement & Joints</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Correct Drainage Slope</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Professional Smooth Finish</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>5-Year Workmanship Warranty</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Get Free Estimate <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80" alt="Concrete Installation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 4: Sidewalk Replacement -->
            <div class="accordion-item svc-item">
                <h2 class="accordion-header" id="heading4">
                    <button class="accordion-button collapsed svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        <span class="svc-num">04</span>
                        <span class="svc-icon"><i class="bi bi-arrow-repeat"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">Sidewalk Replacement</span>
                            <span class="svc-btn-sub">Full slab removal & new concrete pour</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <h3>Complete Sidewalk Replacement</h3>
                                    <p>When repair isn't enough, full replacement is the answer. We remove damaged slabs, prepare the sub-base, and pour fresh DOT-compliant concrete for a completely new sidewalk that lasts decades.</p>
                                    <p>Our replacement service includes proper disposal of old concrete, sub-base compaction, rebar installation where needed, and a smooth finished surface that passes DOT inspection every time.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Full Slab Demolition & Removal</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Sub-Base Preparation & Compaction</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Rebar Reinforcement Installed</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Clean Site After Completion</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>DOT Inspection Guaranteed Pass</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Get Free Estimate <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80" alt="Sidewalk Replacement">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 5: Driveway Installation -->
            <div class="accordion-item svc-item">
                <h2 class="accordion-header" id="heading5">
                    <button class="accordion-button collapsed svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        <span class="svc-num">05</span>
                        <span class="svc-icon"><i class="bi bi-house-door"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">Driveway Installation</span>
                            <span class="svc-btn-sub">Residential & commercial driveway concrete work</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <h3>Concrete Driveway Installation</h3>
                                    <p>Whether it's a residential home or commercial property, we install durable concrete driveways with proper slope, drainage, and a professional finish that enhances your property's curb appeal.</p>
                                    <p>We work with your property's specific requirements including apron connections, garage alignment, and city regulations to deliver a driveway built to last.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Custom Size & Design</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Proper Slope & Drainage</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Apron & Curb Connection</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Broom or Smooth Finish Options</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Reinforced for Heavy Vehicles</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Get Free Estimate <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800&q=80" alt="Driveway Installation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 6: Curb & Gutter -->
            <div class="accordion-item svc-item">
                <h2 class="accordion-header" id="heading6">
                    <button class="accordion-button collapsed svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        <span class="svc-num">06</span>
                        <span class="svc-icon"><i class="bi bi-signpost-split"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">Curb & Gutter</span>
                            <span class="svc-btn-sub">Curbside reconstruction to city specs</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <h3>Curb & Gutter Services</h3>
                                    <p>Damaged curbs and gutters can cause drainage problems and code violations. We reconstruct curbs and gutters to exact city specifications, ensuring proper water flow and street-level compliance.</p>
                                    <p>Our team handles both residential and commercial curb work, including intersection curbs, driveway aprons, and continuous gutter runs.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>City Specification Compliant</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Proper Drainage Flow</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Driveway Apron Connection</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Intersection & Corner Work</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>ADA Ramp Integration</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Get Free Estimate <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1590644365607-1c5a0a1e9b9c?w=800&q=80" alt="Curb and Gutter">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 7: ADA Ramps -->
            <div class="accordion-item svc-item">
                <h2 class="accordion-header" id="heading7">
                    <button class="accordion-button collapsed svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        <span class="svc-num">07</span>
                        <span class="svc-icon"><i class="bi bi-universal-access-circle"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">ADA Ramps</span>
                            <span class="svc-btn-sub">Wheelchair ramp installation per ADA standards</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <h3>ADA-Compliant Ramp Installation</h3>
                                    <p>Federal and city law requires accessible pedestrian ramps at intersections and commercial properties. We install ADA-compliant wheelchair ramps that meet all slope, width, and surface requirements.</p>
                                    <p>Our ramps include proper detectable warning surfaces (truncated domes), correct slope ratios, and landing areas to ensure full accessibility compliance.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Proper 1:12 Slope Ratio</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Truncated Dome Warning Surface</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Correct Width & Landing Areas</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Flawless Integration with Sidewalk</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Full ADA Code Compliance</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Get Free Estimate <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80" alt="ADA Ramps">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 8: Emergency Sidewalk Services -->
            <div class="accordion-item svc-item">
                <h2 class="accordion-header" id="heading8">
                    <button class="accordion-button collapsed svc-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                        <span class="svc-num">08</span>
                        <span class="svc-icon"><i class="bi bi-lightning-charge-fill"></i></span>
                        <div class="svc-btn-text">
                            <span class="svc-btn-title">Emergency Sidewalk Services</span>
                            <span class="svc-btn-sub">24/7 urgent sidewalk repair & hazard response</span>
                        </div>
                        <span class="svc-urgent">URGENT</span>
                    </button>
                </h2>
                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#servicesAccordion">
                    <div class="accordion-body svc-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="svc-body-content">
                                    <span class="svc-badge urgent">24/7 EMERGENCY</span>
                                    <h3>Emergency Sidewalk Services</h3>
                                    <p>Sidewalk collapse, severe trip hazard, or imminent DOT penalty? Our emergency crew is available 24/7 to respond to urgent sidewalk situations across all five boroughs.</p>
                                    <p>We prioritize safety and speed. Our emergency team arrives quickly, secures the area, and performs immediate temporary or permanent repairs to address the hazard and protect you from liability.</p>
                                    <div class="svc-features">
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>24/7 Availability — Nights & Weekends</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>1-Hour Emergency Response</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Immediate Hazard Securing</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Temporary & Permanent Repair Options</span>
                                        </div>
                                        <div class="svc-feature">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Liability Protection Documentation</span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-svc">
                                        Call Now: (718) 555-1234 <i class="bi bi-telephone-fill"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="svc-body-img">
                                    <img src="https://images.unsplash.com/photo-1607400201889-565b1ee75f8e?w=800&q=80" alt="Emergency Sidewalk Services">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>




@endsection

@section('script')
    <script>
        // Add active class styling on accordion toggle
        const accordionItems = document.querySelectorAll('.svc-item');
        accordionItems.forEach(item => {
            const btn = item.querySelector('.svc-btn');
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
    </script>

@endsection