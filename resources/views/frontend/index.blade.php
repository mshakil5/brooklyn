@extends('frontend.layouts.master')

@section('content')

<!-- ========== HERO SECTION ========== -->
<section class="hero-section">
    <!-- Background Image -->
    <div class="hero-bg-image">
        @if($slider && $slider->image)
            <img src="{{ asset('uploads/slider/' . $slider->image) }}" alt="NYC streets">
        @else
            <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=1800&q=85&fit=crop" alt="NYC streets">
        @endif
    </div>
    
    <!-- Dark Gradient Overlay -->
    <div class="hero-bg-overlay"></div>
    
    <!-- Grid Pattern Overlay -->
    <div class="hero-grid-overlay"></div>
    
    <!-- Main Content -->
    <div class="container">
        <div class="hero-row">
            <!-- Left Content -->
            <div class="hero-left">
                <span class="amber-tag">DOT Certified · Licensed & Insured Since 1998</span>
                
                <p class="hero-subtitle-small">FREE INSTANT CHECK</p>
                
                <h1 class="hero-title">
                    @php
                        $defaultTitle = 'Does Your Sidewalk<br>Have <span class="text-blue">Violations?</span>';
                        $title = $slider->title ?? $defaultTitle;
                        
                        // If title doesn't contain HTML span, wrap the last word in blue
                        if (strpos($title, '<span') === false) {
                            // Split by spaces and wrap last word
                            $words = explode(' ', $title);
                            if (count($words) > 0) {
                                $lastWord = array_pop($words);
                                $words[] = '<span class="text-blue">' . $lastWord . '</span>';
                                $title = implode(' ', $words);
                            }
                        }
                        
                        // Handle line breaks - convert \n to <br> if present
                        $title = nl2br($title);
                    @endphp
                    {!! $title !!}
                </h1>
                
                <p class="hero-desc">
                    {{ $slider->subtitle ?? 'Enter your NYC property details below to quickly check if your sidewalk may have DOT violations. Our experts respond within 2 business hours.' }}
                </p>
                
                @php
                    $highlights = is_array($slider->highlights) ? $slider->highlights : [];
                    $defaultHighlights = [
                        ['icon' => 'bi bi-lightning-charge-fill', 'text' => 'Fast Response'],
                        ['icon' => 'bi bi-currency-dollar', 'text' => 'Free Estimate'],
                        ['icon' => 'bi bi-hand-thumbs-up-fill', 'text' => 'No Obligation'],
                    ];
                    $highlights = !empty($highlights) ? $highlights : $defaultHighlights;
                @endphp
                <div class="hero-highlights">
                    @foreach($highlights as $item)
                        <div class="highlight-item">
                            <div class="highlight-icon-circle">
                                <i class="{{ $item['icon'] ?? 'bi bi-lightning-charge-fill' }}"></i>
                            </div>
                            <span>{{ $item['text'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Form -->
            <div class="hero-right">
                @if(session('success'))
                    <!-- Success State -->
                    <div class="hero-form-card" style="text-align: center; padding: 2.5rem;">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(34, 197, 94, 0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <i class="bi bi-check-circle-fill" style="font-size: 2rem; color: #22C55E;"></i>
                        </div>
                        <h3 style="color: #fff; font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem;">Request Submitted!</h3>
                        <p style="color: #94A3B8; font-size: 0.95rem; line-height: 1.6;">{{ session('success') }}</p>
                        <button type="button" class="btn-submit" style="margin-top: 1.5rem;" onclick="location.reload()">
                            Check Another Property
                        </button>
                    </div>
                @else
                    <!-- Original Form -->
                    <div class="hero-form-card">
                        <h2 class="form-card-title">Check My Property</h2>
                        <p class="form-card-subtitle">Free · Takes 30 seconds · No obligation</p>
                        
                        <!-- STEP 1: Address Lookup -->
                        <div id="step-one">
                            <div class="form-group">
                                <label class="form-label-custom">Property Address <span class="required">*</span></label>
                                <input type="text" id="lookup-address" class="form-control" placeholder="e.g. 123 Atlantic Ave, Brooklyn, NY" required>
                            </div>
                            <button type="button" id="btn-check" class="btn-submit" onclick="checkProperty()">
                                <span id="btn-text">Check Now</span>
                                <span id="btn-loader" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span> Checking...
                                </span>
                            </button>
                        </div>

                        <!-- STEP 2: Results & Lead Capture -->
                        <div id="step-two" class="d-none mt-4 pt-4 border-t border-white/10">
                            <div id="result-container" class="mb-4 p-3 rounded-md" style="background: rgba(255,255,255,0.05);">
                            </div>
                            
                            <p class="text-sm text-[#94A3B8] mb-3 font-semibold">Send this report & get a Free Repair Estimate:</p>
                            
                            <form id="lead-form" action="{{ route('violation.lead.store') }}" method="POST">
                                @csrf
                                
                                <input type="hidden" name="address" id="hidden-address" value="">
    
                                <!-- NEW: API Data Hidden Fields -->
                                <input type="hidden" name="status" id="hidden-status" value="">
                                <input type="hidden" name="risk_score" id="hidden-score" value="">
                                <input type="hidden" name="dot_tickets_count" id="hidden-dot" value="">
                                <input type="hidden" name="dob_complaints_count" id="hidden-dob" value="">
                                <input type="hidden" name="risk_details" id="hidden-details" value="">
                                <input type="hidden" name="api_raw_data" id="hidden-raw" value="">
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label-custom">Your Name</label>
                                        <input type="text" name="first_name" class="form-control" placeholder="John Smith" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label-custom">Phone</label>
                                        <input type="tel" name="phone" class="form-control" placeholder="(718) 000-0000" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label-custom">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                                </div>
                                <button type="submit" class="btn-submit">
                                    Get Free Estimate →
                                </button>
                            </form>
                        </div>
                        
                        <p class="form-privacy-note mt-4">🔒 Your information is private and never shared.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</section>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="container">
        <div class="row g-0">
            @php
                $stats = is_array($slider->stats) ? $slider->stats : [];
                $defaultStats = [
                    ['number' => '5,000+', 'label' => 'Projects Completed'],
                    ['number' => '25+', 'label' => 'Years in Business'],
                    ['number' => '100%', 'label' => 'DOT Compliant'],
                    ['number' => '24/7', 'label' => 'Emergency Service'],
                ];
                $stats = !empty($stats) ? $stats : $defaultStats;
            @endphp
            @foreach($stats as $stat)
                <div class="col-6 col-md-2">
                    <div class="stat-item">
                        <span class="stat-number">{{ $stat['number'] ?? '' }}</span>
                        <span class="stat-label">{{ $stat['label'] ?? '' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


    
    @include('frontend.inc.index')
    @include('frontend.inc.estimate')


@endsection

@section('script')

<script>
function checkProperty() {
    const address = document.getElementById('lookup-address').value.trim();
    if (!address) {
        document.getElementById('lookup-address').classList.add('is-invalid');
        return;
    }
    document.getElementById('lookup-address').classList.remove('is-invalid');

    // Show loader
    document.getElementById('btn-text').classList.add('d-none');
    document.getElementById('btn-loader').classList.remove('d-none');
    document.getElementById('btn-check').disabled = true;

    // Use the full URL for debugging on localhost
    const apiUrl = window.location.origin + '/api/check-violation?address=' + encodeURIComponent(address);
    
    console.log('Calling API:', apiUrl);

    fetch(apiUrl)
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            
            if (!response.ok) {
                // Try to get error message from response
                return response.json().then(data => {
                    throw new Error(data.error || 'Server error: ' + response.status);
                }).catch(() => {
                    throw new Error('Server error: ' + response.status);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('API Response:', data);
            
            // Hide loader
            document.getElementById('btn-text').classList.remove('d-none');
            document.getElementById('btn-loader').classList.add('d-none');
            document.getElementById('btn-check').disabled = false;

            if (data.error) {
                alert(data.error);
                return;
            }

            // --- POPULATE ALL HIDDEN FIELDS ---
            document.getElementById('hidden-address').value = data.address;
            document.getElementById('hidden-status').value = data.status;
            document.getElementById('hidden-score').value = data.risk_score;
            document.getElementById('hidden-dot').value = data.dot_tickets;
            document.getElementById('hidden-dob').value = data.dob_complaints;
            document.getElementById('hidden-details').value = JSON.stringify(data.risk_details);
            document.getElementById('hidden-raw').value = JSON.stringify(data); // Saves entire API response!
            // -------------------------------------


            // Show Step 2
            document.getElementById('step-two').classList.remove('d-none');
            document.getElementById('hidden-address').value = data.address;

            const resultDiv = document.getElementById('result-container');
            
            // Build detail bullets
            let detailsHtml = '';
            if (data.risk_details && data.risk_details.length > 0) {
                detailsHtml = '<ul class="mt-2 mb-0 text-sm text-gray-300 space-y-1">';
                data.risk_details.forEach(function(detail) {
                    detailsHtml += '<li class="flex items-start gap-2"><span class="mt-0.5">•</span>' + detail + '</li>';
                });
                detailsHtml += '</ul>';
            }

            // Color map
            const colors = {
                red:   { bg: 'rgba(239, 68, 68, 0.1)',  border: 'rgba(239, 68, 68, 0.2)',  text: 'text-red-400',   score: 'text-red-400' },
                amber: { bg: 'rgba(245, 158, 11, 0.1)', border: 'rgba(245, 158, 11, 0.2)', text: 'text-amber-400', score: 'text-amber-400' },
                green: { bg: 'rgba(34, 197, 94, 0.1)',  border: 'rgba(34, 197, 94, 0.2)',  text: 'text-green-400', score: 'text-green-400' },
            };
            const c = colors[data.status_color];

            if (data.status === 'danger') {
                resultDiv.innerHTML = `
                    <div style="background: ${c.bg}; border: 1px solid ${c.border};" class="p-3 rounded-md">
                        <div class="flex items-center gap-2 ${c.text} font-bold mb-1">
                            <i class="bi ${data.status_icon} text-lg"></i> 
                            ${data.status_text} — Active Issues Found!
                        </div>
                        <p class="text-sm text-gray-300 mb-1">Risk Score: <strong class="${c.score}">${data.risk_score}/100</strong></p>
                        ${detailsHtml}
                    </div>
                `;
            } else if (data.status === 'warning') {
                resultDiv.innerHTML = `
                    <div style="background: ${c.bg}; border: 1px solid ${c.border};" class="p-3 rounded-md">
                        <div class="flex items-center gap-2 ${c.text} font-bold mb-1">
                            <i class="bi ${data.status_icon} text-lg"></i> 
                            ${data.status_text}
                        </div>
                        <p class="text-sm text-gray-300 mb-1">Risk Score: <strong class="${c.score}">${data.risk_score}/100</strong></p>
                        ${detailsHtml}
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div style="background: ${c.bg}; border: 1px solid ${c.border};" class="p-3 rounded-md">
                        <div class="flex items-center gap-2 ${c.text} font-bold mb-1">
                            <i class="bi ${data.status_icon} text-lg"></i> 
                            ${data.status_text} — No Active Issues
                        </div>
                        <p class="text-sm text-gray-300">No open DOT sidewalk tickets or DOB complaints found for this address.</p>
                    </div>
                `;
            }

            // Scroll to results
            document.getElementById('step-two').scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        })
        .catch(error => {
            console.error('Fetch Error:', error);
            alert('Error: ' + error.message);
            document.getElementById('btn-text').classList.remove('d-none');
            document.getElementById('btn-loader').classList.add('d-none');
            document.getElementById('btn-check').disabled = false;
        });
}

// Remove invalid class on input
document.getElementById('lookup-address').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});
</script>

@endsection