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
                            <div class="perk-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
                            <div class="perk-text">
                                <h6>Free On-Site Assessment</h6>
                                <p>We visit your property and evaluate the sidewalk condition at no cost.</p>
                            </div>
                        </div>
                        <div class="perk-item">
                            <div class="perk-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                            <div class="perk-text">
                                <h6>Detailed Written Estimate</h6>
                                <p>Receive a comprehensive breakdown of all costs before any work begins.</p>
                            </div>
                        </div>
                        <div class="perk-item">
                            <div class="perk-icon"><i class="bi bi-shield-check"></i></div>
                            <div class="perk-text">
                                <h6>No Hidden Fees Ever</h6>
                                <p>Transparent pricing with no surprise charges or hidden costs guaranteed.</p>
                            </div>
                        </div>
                        <div class="perk-item">
                            <div class="perk-icon"><i class="bi bi-lightning-charge-fill"></i></div>
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
