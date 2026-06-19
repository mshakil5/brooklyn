@extends('frontend.layouts.master')

@section('page-css')
    <link href="{{ asset('resources/frontend/css/contact.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')


        <!-- ========== PAGE BANNER ========== -->
        <section class="page-banner">
            <div class="banner-overlay"></div>
            <div class="container">
                
    
            <!-- Grid Pattern Overlay -->
            <div class="hero-grid-overlay"></div>
            
                <div class="banner-content">
                    <span class="banner-tag">Contact Us</span>
                    <h1 class="banner-title">Request a <span class="text-blue">Free Estimate</span></h1>
                    <p class="banner-desc">Tell us about your sidewalk or concrete needs and we'll provide a detailed, no-obligation estimate within 24 hours.</p>
                </div>
            </div>
        </section>

        <!-- ========== SERVICE PANELS ========== -->
        <section class="container contact-panels d-none">
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

                <!-- Right Panel — Concrete Maintenance (DYNAMIC) -->
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
                                @foreach($services as $service)
                                    <div class="c-service-item">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>{{ $service }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="panel-c-stats">
                                <div class="c-stat">
                                    <span class="c-stat-num">{{ $stats['Projects Done'] ?? '5,000+' }}</span>
                                    <span class="c-stat-label">Jobs Done</span>
                                </div>
                                <div class="c-stat-divider"></div>
                                <div class="c-stat">
                                    <span class="c-stat-num">{{ $stats['Years Experience'] ?? '25+' }}</span>
                                    <span class="c-stat-label">Yrs Experience</span>
                                </div>
                                <div class="c-stat-divider"></div>
                                <div class="c-stat">
                                    <span class="c-stat-num">{{ $stats['Satisfaction Rate'] ?? '98%' }}</span>
                                    <span class="c-stat-label">Satisfaction</span>
                                </div>
                            </div>

                            <a href="{{ route('service') }}" class="btn-panel-concrete">
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

                    <!-- Left Column (DYNAMIC) -->
                    <div class="col-lg-5">
                        <div class="contact-left">

                            <!-- Current Activity Card -->
                            <div class="activity-card d-none">
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
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company->phone1 ?? '') }}">{{ $company->phone1 ?? '(718) 555-1234' }}</a>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="bi bi-envelope-fill"></i>
                                        <div>
                                            <span class="ci-label">Email</span>
                                            <a href="mailto:{{ $company->email1 ?? 'info@nycsidewalkpros.com' }}">{{ $company->email1 ?? 'info@nycsidewalkpros.com' }}</a>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <div>
                                            <span class="ci-label">Office</span>
                                            <span>{{ $company->address1 ?? '450 W 33rd St, New York, NY 10001' }}</span>
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

                    <!-- Right Column — Form (AJAX ENABLED) -->
                    <div class="col-lg-7">
                        <div class="estimate-form-card">
                            <h4><i class="bi bi-send-fill"></i> Get Your Free Estimate</h4>
                            <p>Fill in your details below — no obligation</p>
                            
                            <!-- Alert Box for Success/Error Messages -->
                            <div id="estimateAlert" class="alert d-none" role="alert"></div>

                            <form id="estimateForm">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <input type="text" name="first_name" class="form-control" placeholder="First Name *" required>
                                        <span class="text-danger small error-msg" id="first_name_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="last_name" class="form-control" placeholder="Last Name *" required>
                                        <span class="text-danger small error-msg" id="last_name_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number *" required>
                                        <span class="text-danger small error-msg" id="phone_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" class="form-control" placeholder="Email Address">
                                        <span class="text-danger small error-msg" id="email_error"></span>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="address" class="form-control" placeholder="Property Address *" required>
                                        <span class="text-danger small error-msg" id="address_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="borough" class="form-select" required>
                                            <option value="" selected disabled>Select Borough *</option>
                                            <option value="Manhattan">Manhattan</option>
                                            <option value="Brooklyn">Brooklyn</option>
                                            <option value="Queens">Queens</option>
                                            <option value="Bronx">Bronx</option>
                                            <option value="Staten Island">Staten Island</option>
                                        </select>
                                        <span class="text-danger small error-msg" id="borough_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="service" class="form-select" required>
                                            <option value="" selected disabled>Service Needed *</option>
                                            <option value="DOT Violation Repair">DOT Violation Repair</option>
                                            <option value="Sidewalk Replacement">Sidewalk Replacement</option>
                                            <option value="Concrete Installation">Concrete Installation</option>
                                            <option value="Driveway Installation">Driveway Installation</option>
                                            <option value="Curb & Gutter">Curb & Gutter</option>
                                            <option value="ADA Ramp">ADA Ramp</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <span class="text-danger small error-msg" id="service_error"></span>
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" class="form-control" rows="3" placeholder="Tell us about your project or violation..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-estimate" id="estimateSubmitBtn">
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



@endsection

@section('script')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactEstimateForm');
    if (!form) return;

    const alertBox = document.getElementById('contactAlert');
    const submitBtn = document.getElementById('contactSubmitBtn');
    
    // Clear errors on focus for floating labels
    form.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('focus', function() {
            this.classList.remove('is-invalid');
            const errorSpan = document.getElementById(this.name + '_error');
            if(errorSpan) errorSpan.textContent = '';
            alertBox.classList.add('d-none');
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        form.querySelectorAll('.error-msg').forEach(el => el.textContent = '');
        form.querySelectorAll('.cf-input').forEach(el => el.classList.remove('is-invalid'));
        alertBox.classList.add('d-none');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Submitting...';

        const formData = new FormData(form);

        // Split "Full Name" into first and last name for the DB
        const fullName = formData.get('full_name').trim();
        const nameParts = fullName.split(/\s+/);
        formData.append('first_name', nameParts[0]);
        formData.append('last_name', nameParts.slice(1).join(' ') || 'N/A');
        formData.append('borough', 'N/A'); // Default since this form lacks a borough dropdown
        formData.delete('full_name'); // Remove the combined name field

        fetch('{{ route("estimate.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw data; }).catch(() => {
                    throw { message: "Server error. Please try again." };
                });
            }
            return response.json();
        })
        .then(data => {
            alertBox.classList.remove('d-none', 'alert-danger');
            alertBox.classList.add('alert-success');
            alertBox.textContent = data.success;
            form.reset();
            // Trigger floating labels to reset visually
            form.querySelectorAll('.cf-input').forEach(el => el.dispatchEvent(new Event('change')));
            alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        })
        .catch(error => {
            console.error(error);
            if (error.errors) {
                // Map backend 'first_name' errors to frontend 'full_name' field
                if (error.errors.first_name) {
                    const full_name_error = document.getElementById('full_name_error');
                    if(full_name_error) full_name_error.textContent = error.errors.first_name[0];
                    form.querySelector('[name="full_name"]').classList.add('is-invalid');
                }
                // Handle other specific fields
                Object.keys(error.errors).forEach(field => {
                    if (field === 'first_name') return; // Handled above
                    const errorSpan = document.getElementById(field + '_error');
                    const inputField = form.querySelector(`[name="${field}"]`);
                    if (errorSpan) errorSpan.textContent = error.errors[field][0];
                    if (inputField) inputField.classList.add('is-invalid');
                });
            } else {
                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = error.message || 'Something went wrong.';
            }
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Get My Free Estimate <i class="bi bi-arrow-right"></i>';
        });
    });
});
</script>
@endsection