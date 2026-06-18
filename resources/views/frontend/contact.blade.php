@extends('frontend.layouts.master')

@section('content')


<style>

    /* ============================================
    CONTACT SERVICE PANELS
    ============================================ */
    .contact-panels {
        margin-top: -1px;
    }

    /* ---- LEFT PANEL — DOT Violation ---- */
    .panel-violation {
        background: var(--dark-bg);
        padding: 60px 50px;
        min-height: 680px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .panel-violation::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -60px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(0, 82, 255, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .panel-violation-inner {
        position: relative;
        z-index: 1;
    }

    .panel-v-icon {
        width: 64px;
        height: 64px;
        background: rgba(0, 82, 255, 0.1);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    .panel-v-icon i {
        font-size: 1.6rem;
        color: var(--blue);
    }

    .panel-v-tag {
        display: inline-block;
        background: rgba(239, 68, 68, 0.12);
        color: #ef4444;
        font-family: var(--font);
        font-weight: 700;
        font-size: 0.7rem;
        padding: 5px 14px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .panel-violation-inner h3 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-white);
        margin-bottom: 14px;
        line-height: 1.25;
        letter-spacing: -0.3px;
    }

    .panel-v-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 30px;
    }

    /* Violation Steps */
    .panel-v-steps {
        display: flex;
        flex-direction: column;
        gap: 18px;
        margin-bottom: 34px;
    }

    .v-step {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .v-step-num {
        width: 36px;
        height: 36px;
        min-width: 36px;
        background: var(--blue);
        color: #ffffff;
        font-family: var(--font);
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 2px;
    }

    .v-step-text h6 {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-white);
        margin-bottom: 3px;
    }

    .v-step-text p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.5;
    }

    /* Violation Button */
    .btn-panel-violation {
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

    .btn-panel-violation:hover {
        background: var(--blue-hover);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 82, 255, 0.35);
    }

    .btn-panel-violation i {
        transition: transform 0.3s ease;
    }

    .btn-panel-violation:hover i {
        transform: translateX(4px);
    }

    /* ---- RIGHT PANEL — Concrete Maintenance ---- */
    .panel-concrete {
        background: #f5f7fb;
        padding: 60px 50px;
        min-height: 680px;
        display: flex;
        align-items: center;
    }

    .panel-concrete-inner {
        width: 100%;
    }

    .panel-c-icon {
        width: 64px;
        height: 64px;
        background: rgba(0, 82, 255, 0.08);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    .panel-c-icon i {
        font-size: 1.6rem;
        color: var(--blue);
    }

    .panel-c-tag {
        display: inline-block;
        background: rgba(0, 82, 255, 0.1);
        color: var(--blue);
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.7rem;
        padding: 5px 14px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .panel-concrete-inner h3 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #111832;
        margin-bottom: 14px;
        line-height: 1.25;
        letter-spacing: -0.3px;
    }

    .panel-c-desc {
        font-size: 0.9rem;
        color: #6b7280;
        line-height: 1.8;
        margin-bottom: 26px;
    }

    /* Concrete Services List */
    .panel-c-services {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 28px;
    }

    .c-service-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        font-weight: 500;
        color: #374151;
    }

    .c-service-item i {
        color: var(--blue);
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* Concrete Stats */
    .panel-c-stats {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        border: 1px solid #e8ecf4;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 28px;
    }

    .c-stat {
        text-align: center;
        flex: 1;
    }

    .c-stat-num {
        display: block;
        font-family: var(--font);
        font-size: 1.3rem;
        font-weight: 800;
        color: #111832;
        line-height: 1.2;
        margin-bottom: 2px;
    }

    .c-stat-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 500;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .c-stat-divider {
        width: 1px;
        height: 40px;
        background: #e8ecf4;
    }

    /* Concrete Button */
    .btn-panel-concrete {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: var(--blue);
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.95rem;
        padding: 14px 30px;
        border: 2px solid var(--blue);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-panel-concrete:hover {
        background: var(--blue);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 82, 255, 0.3);
    }

    .btn-panel-concrete i {
        transition: transform 0.3s ease;
    }

    .btn-panel-concrete:hover i {
        transform: translateX(4px);
    }

    /* ============================================
    CONTACT PANELS RESPONSIVE — TABLET
    ============================================ */
    @media (max-width: 991.98px) {
        .panel-violation {
            padding: 50px 40px;
            min-height: auto;
        }

        .panel-concrete {
            padding: 50px 40px;
            min-height: auto;
        }

        .panel-violation-inner h3,
        .panel-concrete-inner h3 {
            font-size: 1.4rem;
        }
    }

    /* ============================================
    CONTACT PANELS RESPONSIVE — MOBILE
    ============================================ */
    @media (max-width: 767.98px) {
        .panel-violation {
            padding: 40px 24px;
        }

        .panel-concrete {
            padding: 40px 24px;
        }

        .panel-v-icon,
        .panel-c-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
        }

        .panel-v-icon i,
        .panel-c-icon i {
            font-size: 1.4rem;
        }

        .panel-violation-inner h3,
        .panel-concrete-inner h3 {
            font-size: 1.25rem;
        }

        .panel-v-desc,
        .panel-c-desc {
            font-size: 0.86rem;
            margin-bottom: 24px;
        }

        .v-step-num {
            width: 32px;
            height: 32px;
            min-width: 32px;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        .v-step-text h6 {
            font-size: 0.85rem;
        }

        .v-step-text p {
            font-size: 0.76rem;
        }

        .panel-v-steps {
            gap: 14px;
            margin-bottom: 28px;
        }

        .panel-c-services {
            grid-template-columns: 1fr;
            gap: 10px;
            margin-bottom: 22px;
        }

        .c-service-item {
            font-size: 0.84rem;
        }

        .panel-c-stats {
            padding: 16px 18px;
            margin-bottom: 22px;
        }

        .c-stat-num {
            font-size: 1.1rem;
        }

        .c-stat-label {
            font-size: 0.66rem;
        }

        .btn-panel-violation,
        .btn-panel-concrete {
            width: 100%;
            justify-content: center;
            padding: 13px 24px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 575.98px) {
        .panel-violation {
            padding: 34px 18px;
        }

        .panel-concrete {
            padding: 34px 18px;
        }

        .panel-violation-inner h3,
        .panel-concrete-inner h3 {
            font-size: 1.12rem;
        }

        .v-step {
            gap: 12px;
        }

        .v-step-num {
            width: 28px;
            height: 28px;
            min-width: 28px;
            font-size: 0.75rem;
            border-radius: 7px;
        }

        .v-step-text h6 {
            font-size: 0.8rem;
        }

        .c-stat-divider {
            height: 30px;
        }
    }

</style>


<style>
    /* ============================================
    CONTACT FORM SECTION
    ============================================ */
    .contact-form-section {
        padding: 80px 0;
        background: #F2F4F7;
    }

    .contact-left {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* ---- Current Activity Card ---- */
    .activity-card {
        background: #0F172A;
        border-radius: 16px;
        padding: 28px 26px;
    }

    .activity-card h5 {
        font-size: 0.82rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .activity-card h5 i {
        color: var(--blue);
        font-size: 0.95rem;
    }

    .activity-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .activity-item {
        text-align: center;
        padding: 16px 10px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: rgba(0, 82, 255, 0.08);
        border-color: rgba(0, 82, 255, 0.15);
    }

    .activity-num {
        display: block;
        font-family: var(--font);
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--blue);
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .activity-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.45);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ---- Contact Info Card ---- */
    .contact-info-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px 26px;
        border: 1px solid #e2e8f0;
    }

    .contact-info-card h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111832;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .contact-info-card h5 i {
        color: var(--blue);
        font-size: 1.05rem;
    }

    .contact-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .contact-info-list li {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .contact-info-list li > i {
        color: var(--blue);
        font-size: 1.05rem;
        margin-top: 3px;
        flex-shrink: 0;
        width: 18px;
        text-align: center;
    }

    .ci-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .contact-info-list li a,
    .contact-info-list li > div > span:last-child {
        font-size: 0.9rem;
        font-weight: 500;
        color: #374151;
        line-height: 1.4;
    }

    .contact-info-list li a:hover {
        color: var(--blue);
    }

    /* ---- Service Areas Card ---- */
    .areas-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px 26px;
        border: 1px solid #e2e8f0;
    }

    .areas-card h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111832;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .areas-card h5 i {
        color: var(--blue);
        font-size: 1.05rem;
    }

    .area-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .area-tag {
        display: inline-block;
        background: rgba(0, 82, 255, 0.06);
        color: var(--blue);
        font-family: var(--font);
        font-weight: 600;
        font-size: 0.78rem;
        padding: 6px 16px;
        border-radius: 50px;
        border: 1px solid rgba(0, 82, 255, 0.12);
        transition: all 0.3s ease;
    }

    .area-tag:hover {
        background: var(--blue);
        color: #ffffff;
        border-color: var(--blue);
    }

    /* ---- Cert Badges Row ---- */
    .cert-badges-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .cert-badge-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 9px 18px;
        transition: all 0.3s ease;
    }

    .cert-badge-item i {
        color: var(--blue);
        font-size: 0.95rem;
    }

    .cert-badge-item span {
        font-size: 0.78rem;
        font-weight: 600;
        color: #374151;
    }

    .cert-badge-item:hover {
        border-color: rgba(0, 82, 255, 0.2);
        box-shadow: 0 4px 12px rgba(0, 82, 255, 0.08);
    }

    /* ---- Contact Form Card ---- */
    .contact-form-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px 36px 32px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
    }

    .form-card-top {
        margin-bottom: 30px;
    }

    .form-card-top h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #111832;
        margin-bottom: 8px;
        letter-spacing: -0.3px;
    }

    .form-card-top p {
        font-size: 0.9rem;
        color: #6b7280;
        margin: 0;
    }

    /* ---- Form Fields ---- */
    .cf-field {
        position: relative;
    }

    .cf-input {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 2px solid #CBD5E1;
        padding: 12px 0;
        font-family: var(--font);
        font-size: 0.92rem;
        color: #0F172A;
        outline: none;
        transition: border-color 0.25s ease;
        border-radius: 0;
    }

    .cf-input::placeholder {
        color: transparent;
    }

    .cf-input:focus {
        border-bottom-color: var(--blue);
    }

    .cf-field label {
        position: absolute;
        left: 0;
        top: 12px;
        font-size: 0.92rem;
        color: #94A3B8;
        font-weight: 400;
        pointer-events: none;
        transition: all 0.25s ease;
    }

    .cf-input:focus + label,
    .cf-input:not(:placeholder-shown) + label {
        top: -10px;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--blue);
        letter-spacing: 0.3px;
    }

    /* Select Styling */
    .cf-select {
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394A3B8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 4px center;
        background-size: 16px;
        color: #94A3B8;
    }

    .cf-select:focus,
    .cf-select.has-value {
        color: #0F172A;
    }

    .cf-select option {
        background: #0F172A;
        color: #ffffff;
        padding: 10px;
    }

    .cf-select-label {
        top: -10px !important;
        font-size: 0.72rem !important;
        font-weight: 600 !important;
        color: var(--blue) !important;
        letter-spacing: 0.3px !important;
    }

    /* Textarea */
    .cf-textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Submit Button */
    .btn-cf-submit {
        width: 100%;
        background: var(--blue);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 15px 24px;
        font-family: var(--font);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        margin-top: 8px;
    }

    .btn-cf-submit:hover {
        background: var(--blue-hover);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 82, 255, 0.35);
    }

    .btn-cf-submit i {
        transition: transform 0.3s ease;
    }

    .btn-cf-submit:hover i {
        transform: translateX(4px);
    }

    /* Trust Badge */
    .cf-trust {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 22px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .cf-trust i {
        color: #22c55e;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .cf-trust span {
        font-size: 0.78rem;
        color: #94A3B8;
        line-height: 1.5;
    }

    /* ============================================
    CONTACT FORM RESPONSIVE — TABLET
    ============================================ */
    @media (max-width: 991.98px) {
        .contact-form-section {
            padding: 60px 0;
        }

        .contact-left {
            order: 2;
        }

        .contact-form-card {
            order: 1;
        }
    }

    /* ============================================
    CONTACT FORM RESPONSIVE — MOBILE
    ============================================ */
    @media (max-width: 767.98px) {
        .contact-form-section {
            padding: 40px 0;
        }

        .contact-left {
            gap: 14px;
        }

        .activity-card {
            padding: 22px 20px;
        }

        .activity-num {
            font-size: 1.35rem;
        }

        .activity-label {
            font-size: 0.66rem;
        }

        .contact-info-card {
            padding: 22px 20px;
        }

        .contact-info-list li {
            gap: 12px;
        }

        .areas-card {
            padding: 20px 20px;
        }

        .contact-form-card {
            padding: 30px 24px 24px;
            border-radius: 16px;
        }

        .form-card-top h3 {
            font-size: 1.3rem;
        }

        .cf-input {
            font-size: 0.88rem;
            padding: 10px 0;
        }

        .cf-field label {
            font-size: 0.88rem;
            top: 10px;
        }

        .cf-input:focus + label,
        .cf-input:not(:placeholder-shown) + label {
            top: -8px;
            font-size: 0.68rem;
        }

        .cf-select-label {
            top: -8px !important;
            font-size: 0.68rem !important;
        }

        .btn-cf-submit {
            padding: 14px 20px;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 575.98px) {
        .activity-grid {
            gap: 10px;
        }

        .activity-item {
            padding: 12px 8px;
        }

        .activity-num {
            font-size: 1.2rem;
        }

        .cert-badges-row {
            gap: 8px;
        }

        .cert-badge-item {
            padding: 7px 14px;
        }

        .cert-badge-item span {
            font-size: 0.72rem;
        }

        .contact-form-card {
            padding: 26px 18px 20px;
        }

        .form-card-top h3 {
            font-size: 1.15rem;
        }

        .cf-trust {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
    }
</style>

        <!-- ========== PAGE BANNER ========== -->
        <section class="page-banner">
            <div class="banner-overlay"></div>
            <div class="container">
                <div class="banner-content">
                    <span class="banner-tag">Contact Us</span>
                    <h1 class="banner-title">Request a <span class="text-blue">Free Estimate</span></h1>
                    <p class="banner-desc">Tell us about your sidewalk or concrete needs and we'll provide a detailed, no-obligation estimate within 24 hours.</p>
                    <div class="banner-breadcrumb">
                        <a href="#">Home</a>
                        <i class="bi bi-chevron-right"></i>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== SERVICE PANELS ========== -->
        <section class="container contact-panels">
            <div class="row g-0">

                <!-- Left Panel — DOT Violation Resolution -->
                <div class="col-lg-6">
                    <div class="panel-violation">
                        <div class="panel-violation-inner">
                            <div class="panel-v-icon">
                                <i class="bi bi-shield-exclamation"></i>
                            </div>
                            <span class="panel-v-tag">Urgent Service</span>
                            <h3>DOT Violation Resolution</h3>
                            <p class="panel-v-desc">Received a sidewalk violation notice from the NYC Department of Transportation? Don't wait — penalties can add up to $1,000 per day. We handle the entire resolution process from start to finish.</p>

                            <div class="panel-v-steps">
                                <div class="v-step">
                                    <div class="v-step-num">1</div>
                                    <div class="v-step-text">
                                        <h6>Violation Assessment</h6>
                                        <p>We review your violation notice and inspect the property</p>
                                    </div>
                                </div>
                                <div class="v-step">
                                    <div class="v-step-num">2</div>
                                    <div class="v-step-text">
                                        <h6>Permit & Filing</h6>
                                        <p>We handle all DOT permits and paperwork for you</p>
                                    </div>
                                </div>
                                <div class="v-step">
                                    <div class="v-step-num">3</div>
                                    <div class="v-step-text">
                                        <h6>Compliant Repair</h6>
                                        <p>DOT-approved materials and methods for all repairs</p>
                                    </div>
                                </div>
                                <div class="v-step">
                                    <div class="v-step-num">4</div>
                                    <div class="v-step-text">
                                        <h6>Inspection & Dismissal</h6>
                                        <p>We coordinate the DOT inspection to clear your violation</p>
                                    </div>
                                </div>
                            </div>

                            <a href="#" class="btn-panel-violation">
                                Resolve My Violation
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Panel — Concrete Maintenance -->
                <div class="col-lg-6">
                    <div class="panel-concrete">
                        <div class="panel-concrete-inner">
                            <div class="panel-c-icon">
                                <i class="bi bi-bricks"></i>
                            </div>
                            <span class="panel-c-tag">Preventive Care</span>
                            <h3>Concrete Maintenance</h3>
                            <p class="panel-c-desc">Protect your investment with proactive concrete maintenance. Regular upkeep prevents costly violations and extends the lifespan of your sidewalk, driveway, and concrete surfaces.</p>

                            <div class="panel-c-services">
                                <div class="c-service-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Concrete Installation</span>
                                </div>
                                <div class="c-service-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Crack & Chip Repair</span>
                                </div>
                                <div class="c-service-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Sidewalk Leveling</span>
                                </div>
                                <div class="c-service-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Surface Sealing</span>
                                </div>
                                <div class="c-service-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Joint & Expansion Repair</span>
                                </div>
                                <div class="c-service-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Driveway Maintenance</span>
                                </div>
                            </div>

                            <div class="panel-c-stats">
                                <div class="c-stat">
                                    <span class="c-stat-num">5,000+</span>
                                    <span class="c-stat-label">Jobs Done</span>
                                </div>
                                <div class="c-stat-divider"></div>
                                <div class="c-stat">
                                    <span class="c-stat-num">25+</span>
                                    <span class="c-stat-label">Yrs Experience</span>
                                </div>
                                <div class="c-stat-divider"></div>
                                <div class="c-stat">
                                    <span class="c-stat-num">98%</span>
                                    <span class="c-stat-label">Satisfaction</span>
                                </div>
                            </div>

                            <a href="#" class="btn-panel-concrete">
                                View All Services
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>



        <!-- ========== CONTACT FORM SECTION ========== -->
        <section class="contact-form-section">
            <div class="container">
                <div class="row g-4">

                    <!-- Left Column -->
                    <div class="col-lg-5">
                        <div class="contact-left">

                            <!-- Current Activity Card -->
                            <div class="activity-card">
                                <h5><i class="bi bi-broadcast"></i> Current Activity</h5>
                                <div class="activity-grid">
                                    <div class="activity-item">
                                        <span class="activity-num">12</span>
                                        <span class="activity-label">Active Projects</span>
                                    </div>
                                    <div class="activity-item">
                                        <span class="activity-num">28</span>
                                        <span class="activity-label">Estimates This Week</span>
                                    </div>
                                    <div class="activity-item">
                                        <span class="activity-num">&lt;2hr</span>
                                        <span class="activity-label">Avg Response</span>
                                    </div>
                                    <div class="activity-item">
                                        <span class="activity-num">5</span>
                                        <span class="activity-label">Available Slots</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="contact-info-card">
                                <h5><i class="bi bi-telephone-outbound"></i> Contact Info</h5>
                                <ul class="contact-info-list">
                                    <li>
                                        <i class="bi bi-telephone-fill"></i>
                                        <div>
                                            <span class="ci-label">Phone</span>
                                            <a href="tel:+17185551234">(718) 555-1234</a>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="bi bi-envelope-fill"></i>
                                        <div>
                                            <span class="ci-label">Email</span>
                                            <a href="mailto:info@nycsidewalkpros.com">info@nycsidewalkpros.com</a>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <div>
                                            <span class="ci-label">Office</span>
                                            <span>450 W 33rd St, New York, NY 10001</span>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="bi bi-clock-fill"></i>
                                        <div>
                                            <span class="ci-label">Hours</span>
                                            <span>Mon - Sat: 7:00 AM - 7:00 PM</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Service Areas -->
                            <div class="areas-card">
                                <h5><i class="bi bi-geo-alt"></i> Service Areas</h5>
                                <div class="area-tags">
                                    <span class="area-tag">Manhattan</span>
                                    <span class="area-tag">Brooklyn</span>
                                    <span class="area-tag">Queens</span>
                                    <span class="area-tag">The Bronx</span>
                                    <span class="area-tag">Staten Island</span>
                                </div>
                            </div>

                            <!-- Cert Badges -->
                            <div class="cert-badges-row">
                                <div class="cert-badge-item">
                                    <i class="bi bi-patch-check-fill"></i>
                                    <span>Licensed & Insured</span>
                                </div>
                                <div class="cert-badge-item">
                                    <i class="bi bi-shield-check"></i>
                                    <span>DOT Certified</span>
                                </div>
                                <div class="cert-badge-item">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                    <span>24/7 Emergency</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column — Form -->
                    <div class="col-lg-7">
                        <div class="contact-form-card">
                            <div class="form-card-top">
                                <h3>Get Your Free Estimate</h3>
                                <p>Fill in the details below and we'll get back to you within 24 hours.</p>
                            </div>
                            <form id="contactEstimateForm">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="cf-field">
                                            <input type="text" class="cf-input" placeholder=" " required>
                                            <label>Full Name *</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cf-field">
                                            <input type="tel" class="cf-input" placeholder=" " required>
                                            <label>Phone Number *</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cf-field">
                                            <input type="email" class="cf-input" placeholder=" ">
                                            <label>Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cf-field">
                                            <input type="text" class="cf-input" placeholder=" " required>
                                            <label>Property Address *</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="cf-field">
                                            <select class="cf-input cf-select" required>
                                                <option value="" disabled selected></option>
                                                <option value="DOT Violation Removal">DOT Violation Removal</option>
                                                <option value="Sidewalk Repair">Sidewalk Repair</option>
                                                <option value="Concrete Installation">Concrete Installation</option>
                                                <option value="Sidewalk Replacement">Sidewalk Replacement</option>
                                                <option value="Curb Repair">Curb Repair</option>
                                                <option value="Driveway Repair">Driveway Repair</option>
                                                <option value="Tree Root Damage Repair">Tree Root Damage Repair</option>
                                                <option value="Emergency Services">Emergency Services</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <label class="cf-select-label">Service Type *</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="cf-field">
                                            <textarea class="cf-input cf-textarea" rows="4" placeholder=" "></textarea>
                                            <label>Project Details</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-cf-submit">
                                            Get My Free Estimate
                                            <i class="bi bi-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="cf-trust">
                                <i class="bi bi-shield-lock-fill"></i>
                                <span>Your information is secure and will never be shared with third parties.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>






@endsection

@section('script')


@endsection