<!-- ========== REQUEST FREE ESTIMATE ========== -->
<section class="estimate-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="estimate-left">
                    <span class="estimate-tag">Free Estimate</span>
                    <h2 class="estimate-title">Request Your <span class="text-blue">Free Estimate</span> Today</h2>
                    <p class="estimate-desc">Fill out the form and one of our sidewalk specialists will contact you within 24 hours with a detailed, no-obligation estimate.</p>
                    <div class="estimate-perks">
                        <div class="perk-item">
                            <div class="perk-icon">
                                <i class="bi bi-clipboard2-check-fill"></i>
                            </div>
                            <div class="perk-text">
                                <h6>Free On-Site Assessment</h6>
                                <p>We visit your property and evaluate the sidewalk condition at no cost.</p>
                            </div>
                        </div>
                        <div class="perk-item">
                            <div class="perk-icon">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </div>
                            <div class="perk-text">
                                <h6>Detailed Written Estimate</h6>
                                <p>Receive a comprehensive breakdown of all costs before any work begins.</p>
                            </div>
                        </div>
                        <div class="perk-item">
                            <div class="perk-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="perk-text">
                                <h6>No Hidden Fees Ever</h6>
                                <p>Transparent pricing with no surprise charges or hidden costs guaranteed.</p>
                            </div>
                        </div>
                        <div class="perk-item">
                            <div class="perk-icon">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>
                            <div class="perk-text">
                                <h6>Fast 24-Hour Response</h6>
                                <p>Our team responds to every estimate request within 24 hours or less.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="estimate-form-card">
                    <h4><i class="bi bi-send-fill"></i> Get Your Free Estimate</h4>
                    <p>Fill in your details below — no obligation</p>
                    <form id="estimateForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name *" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name *" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number *" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Property Address *" value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <select name="borough" class="form-select @error('borough') is-invalid @enderror" required>
                                    <option value="" {{ !old('borough') ? 'selected disabled' : '' }}>Select Borough *</option>
                                    <option value="Manhattan" {{ old('borough') == 'Manhattan' ? 'selected' : '' }}>Manhattan</option>
                                    <option value="Brooklyn" {{ old('borough') == 'Brooklyn' ? 'selected' : '' }}>Brooklyn</option>
                                    <option value="Queens" {{ old('borough') == 'Queens' ? 'selected' : '' }}>Queens</option>
                                    <option value="Bronx" {{ old('borough') == 'Bronx' ? 'selected' : '' }}>Bronx</option>
                                    <option value="Staten Island" {{ old('borough') == 'Staten Island' ? 'selected' : '' }}>Staten Island</option>
                                </select>
                                @error('borough')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <select name="service" class="form-select @error('service') is-invalid @enderror" required>
                                    <option value="" {{ !old('service') ? 'selected disabled' : '' }}>Service Needed *</option>
                                    <option value="DOT Violation Repair" {{ old('service') == 'DOT Violation Repair' ? 'selected' : '' }}>DOT Violation Repair</option>
                                    <option value="Sidewalk Replacement" {{ old('service') == 'Sidewalk Replacement' ? 'selected' : '' }}>Sidewalk Replacement</option>
                                    <option value="Concrete Installation" {{ old('service') == 'Concrete Installation' ? 'selected' : '' }}>Concrete Installation</option>
                                    <option value="Driveway Installation" {{ old('service') == 'Driveway Installation' ? 'selected' : '' }}>Driveway Installation</option>
                                    <option value="Curb & Gutter" {{ old('service') == 'Curb & Gutter' ? 'selected' : '' }}>Curb & Gutter</option>
                                    <option value="ADA Ramp" {{ old('service') == 'ADA Ramp' ? 'selected' : '' }}>ADA Ramp</option>
                                    <option value="Other" {{ old('service') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('service')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <textarea name="message" class="form-control" rows="3" placeholder="Tell us about your project or violation...">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-estimate">
                                    Get My Free Estimate
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="estimate-trust">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Your information is secure and will never be shared</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                            @if($company->facebook)
                                <a href="{{ $company->facebook }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            @else
                                <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            @endif
                            @if($company->instagram)
                                <a href="{{ $company->instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            @else
                                <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            @endif
                            @if($company->youtube)
                                <a href="{{ $company->youtube }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                            @else
                                <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                            @endif
                            <a href="#" aria-label="Google"><i class="bi bi-google"></i></a>
                            @if($company->linkedin)
                                <a href="{{ $company->linkedin }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            @else
                                <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Services Column -->
                <div class="col-6 col-lg-2">
                    <h6 class="footer-heading">Services</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('service') }}#dot-violation">DOT Violation Removal</a></li>
                        <li><a href="{{ route('service') }}#sidewalk-repair">Sidewalk Repair</a></li>
                        <li><a href="{{ route('service') }}#concrete-installation">Concrete Installation</a></li>
                        <li><a href="{{ route('service') }}#sidewalk-replacement">Sidewalk Replacement</a></li>
                        <li><a href="{{ route('service') }}#driveway">Driveway Installation</a></li>
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
                            <div class="cert-icon">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>
                            <div class="cert-text">
                                <span class="cert-title">Fully Licensed & Insured</span>
                                <span class="cert-sub">NYC DOB Licensed Contractor</span>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="cert-text">
                                <span class="cert-title">DOT Certified</span>
                                <span class="cert-sub">Approved NYC DOT Contractor</span>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-icon">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <div class="cert-text">
                                <span class="cert-title">25+ Years Experience</span>
                                <span class="cert-sub">Serving NYC Since 1998</span>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-icon">
                                <i class="bi bi-star-fill"></i>
                            </div>
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