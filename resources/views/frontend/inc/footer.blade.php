
<!-- ========== DOT VIOLATION CTA BANNER ========== -->
<section class="cta-banner">
    <div class="container">
        <div class="cta-inner">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="cta-content">
                        <h2>Got a DOT Violation or <span class="text-white">Damaged Sidewalk?</span></h2>
                        <p>Don't wait until penalties add up. Get a free, no-obligation estimate from NYC's most trusted sidewalk contractors. We handle everything from permit filing to final inspection.</p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="cta-buttons">
                        <a href="{{ route('contact') }}" class="btn-cta-primary">
                            Get Free Estimate
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company->phone1 ?? '(718) 555-1234') }}" class="btn-cta-secondary">
                            <i class="bi bi-telephone-fill"></i>
                            Call Now: {{ $company->phone1 ?? '(718) 555-1234' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="footer-section">
    <div class="container">
        <div class="footer-main">
            <div class="row g-4">
                <!-- Brand Column -->
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="footer-logo">
                            @if($company->footer_logo)
                                <img src="{{ asset('uploads/company/' . $company->footer_logo) }}" alt="{{ $company->company_name }}" class="footer-logo-img">
                            @elseif($company->company_logo)
                                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="{{ $company->company_name }}" class="footer-logo-img">
                            @else
                                <i class="bi bi-building"></i>
                                NYC <span>Sidewalk Pros</span>
                            @endif
                        </a>
                        <p class="footer-about">{{ $company->footer_content ?? "New York's most trusted sidewalk and concrete experts. Fully licensed and insured since 1998, serving all five boroughs with quality workmanship." }}</p>
                        <div class="footer-social">
                            <a href="{{ $company->facebook ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="{{ $company->instagram ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="{{ $company->youtube ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                            <a href="#" aria-label="Google"><i class="bi bi-google"></i></a>
                            <a href="{{ $company->linkedin ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Services Column -->
                <div class="col-6 col-lg-2">
                    <h6 class="footer-heading">Services</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('service') }}#dot-violation-removal">DOT Violation Removal</a></li>
                        <li><a href="{{ route('service') }}#sidewalk-repair">Sidewalk Repair</a></li>
                        <li><a href="{{ route('service') }}#concrete-installation">Concrete Installation</a></li>
                        <li><a href="{{ route('service') }}#sidewalk-replacement">Sidewalk Replacement</a></li>
                        <li><a href="{{ route('service') }}#driveway-installation">Driveway Installation</a></li>
                        <li><a href="{{ route('service') }}#curb-gutter">Curb & Gutter</a></li>
                        <li><a href="{{ route('service') }}#ada-ramps">ADA Ramps</a></li>
                    </ul>
                </div>

                <!-- Service Areas Column -->
                <div class="col-6 col-lg-2">
                    <h6 class="footer-heading">Service Areas</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact') }}?borough=manhattan">Manhattan</a></li>
                        <li><a href="{{ route('contact') }}?borough=brooklyn">Brooklyn</a></li>
                        <li><a href="{{ route('contact') }}?borough=queens">Queens</a></li>
                        <li><a href="{{ route('contact') }}?borough=bronx">The Bronx</a></li>
                        <li><a href="{{ route('contact') }}?borough=staten-island">Staten Island</a></li>
                    </ul>
                </div>

                <!-- Certifications Column -->
                <div class="col-lg-4">
                    <h6 class="footer-heading">Certifications</h6>
                    <div class="footer-certs">
                        <div class="cert-item">
                            <div class="cert-icon"><i class="bi bi-patch-check-fill"></i></div>
                            <div class="cert-text">
                                <span class="cert-title">Fully Licensed & Insured</span>
                                <span class="cert-sub">NYC DOB Licensed Contractor</span>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-icon"><i class="bi bi-shield-check"></i></div>
                            <div class="cert-text">
                                <span class="cert-title">DOT Certified</span>
                                <span class="cert-sub">Approved NYC DOT Contractor</span>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-icon"><i class="bi bi-award-fill"></i></div>
                            <div class="cert-text">
                                <span class="cert-title">25+ Years Experience</span>
                                <span class="cert-sub">Serving NYC Since 1998</span>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-icon"><i class="bi bi-star-fill"></i></div>
                            <div class="cert-text">
                                <span class="cert-title">A+ BBB Rating</span>
                                <span class="cert-sub">Better Business Bureau Accredited</span>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="btn-footer-cta">
                            Get Free Estimate
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p>{!! $company->copyright ?? '&copy; <span id="currentYear"></span> NYC Sidewalk Pros. All rights reserved.' !!}</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-bottom-links">
                        <a href="{{ route('privacyPolicy') }}">Privacy Policy</a>
                        <span class="footer-sep">|</span>
                        <a href="{{ route('termsOfService') }}">Terms of Service</a>
                        <span class="footer-sep">|</span>
                        <a href="{{ route('sitemap') }}">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
