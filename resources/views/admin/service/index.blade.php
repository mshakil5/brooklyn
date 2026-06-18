@extends('admin.pages.master')
@section('title', 'Service Management')

@section('css')
<style>
    .feature-row {
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .dynamic-section {
        border: 1px dashed #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        background: #f8f9fa;
    }
    .dynamic-section .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }
    .dynamic-section .section-header h6 {
        margin: 0;
        font-weight: 600;
    }
    .dynamic-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .feature-row {
        display: flex;
        gap: 10px;
        align-items: center;
        background: #fff;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
    .feature-row .form-control {
        font-size: 0.875rem;
    }
    .btn-remove-item {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #fca5a5;
        background: #fef2f2;
        color: #dc2626;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-remove-item:hover {
        background: #dc2626;
        color: #fff;
    }
    .btn-add-item {
        border: 1px dashed #94a3b8;
        background: transparent;
        color: #64748b;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.2s;
        width: 100%;
    }
    .btn-add-item:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        background: #eff6ff;
    }
    .icon-select {
        width: 200px !important;
        flex-shrink: 0;
    }
    .preview-image-container {
        position: relative;
        display: inline-block;
    }
    .preview-image-container .btn-remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: none;
        background: rgba(220, 38, 38, 0.9);
        color: #fff;
        cursor: pointer;
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .preview-image-container:hover .btn-remove-image {
        opacity: 1;
    }
    .form-section-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section-title i {
        color: #3b82f6;
    }
    .badge-type-options {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .badge-type-option {
        position: relative;
    }
    .badge-type-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .badge-type-option label {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #fff;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .badge-type-option input[type="radio"]:checked + label {
        border-color: #3b82f6;
        background: #eff6ff;
        color: #3b82f6;
    }
    .badge-type-option label.badge-preview-urgent {
        background: #fef2f2;
        border-color: #fca5a5;
        color: #dc2626;
    }
    .badge-type-option input[type="radio"]:checked + label.badge-preview-urgent {
        background: #dc2626;
        color: #fff;
    }
    .badge-type-option label.badge-preview-popular {
        background: #f0fdf4;
        border-color: #86efac;
        color: #16a34a;
    }
    .badge-type-option input[type="radio"]:checked + label.badge-preview-popular {
        background: #16a34a;
        color: #fff;
    }
    .badge-type-option label.badge-preview-premium {
        background: #faf5ff;
        border-color: #d8b4fe;
        color: #9333ea;
    }
    .badge-type-option input[type="radio"]:checked + label.badge-preview-premium {
        background: #9333ea;
        color: #fff;
    }
    .slug-input-group .form-control {
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')

<div class="container-fluid" id="newBtnSection">
    <div class="row mb-3">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" id="newBtn">
                <i class="ri-add-line align-middle me-1"></i> Add New Service
            </button>
        </div>
    </div>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">
                        <i class="ri-service-line me-2"></i>Add New Service
                    </h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">

                        <!-- Accordion Button Info -->
                        <div class="form-section-title">
                            <i class="ri-layout-4-line"></i> Accordion Button Info
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-5">
                                <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="e.g. DOT Violation Removal">
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Subtitle <span class="text-danger">*</span> <small class="text-muted">(Short description for button)</small></label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="e.g. Complete violation resolution from filing to dismissal">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug <small class="text-muted">(Leave blank to auto-generate)</small></label>
                                <div class="input-group slug-input-group">
                                    <span class="input-group-text" style="font-size:0.8rem;">/services/</span>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="dot-violation-removal">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Urgent Tag <small class="text-muted">(e.g. URGENT, NEW)</small></label>
                                <input type="text" class="form-control" id="urgent_tag" name="urgent_tag" placeholder="URGENT" maxlength="20">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Button Icon</label>
                                <select class="form-select" id="icon" name="icon">
                                    <option value="bi bi-shield-exclamation">Shield Exclamation</option>
                                    <option value="bi bi-wrench-adjustable">Wrench Adjustable</option>
                                    <option value="bi bi-bricks">Bricks</option>
                                    <option value="bi bi-tools">Tools</option>
                                    <option value="bi bi-cone-striped">Cone Striped</option>
                                    <option value="bi bi-building">Building</option>
                                    <option value="bi bi-house-door">House Door</option>
                                    <option value="bi bi-hammer">Hammer</option>
                                    <option value="bi bi-truck">Truck</option>
                                    <option value="bi bi-hard-hat">Hard Hat</option>
                                    <option value="bi bi-gear">Gear</option>
                                    <option value="bi bi-check2-circle">Check Circle</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Badge Text <small class="text-muted">(Optional)</small></label>
                                <input type="text" class="form-control" id="badge" name="badge" placeholder="e.g. URGENT, POPULAR">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Badge Style</label>
                                <div class="badge-type-options mt-1">
                                    <div class="badge-type-option">
                                        <input type="radio" name="badge_type" id="badgeDefault" value="default" checked>
                                        <label for="badgeDefault">Default</label>
                                    </div>
                                    <div class="badge-type-option">
                                        <input type="radio" name="badge_type" id="badgeUrgent" value="urgent">
                                        <label for="badgeUrgent" class="badge-preview-urgent">Urgent</label>
                                    </div>
                                    <div class="badge-type-option">
                                        <input type="radio" name="badge_type" id="badgePopular" value="popular">
                                        <label for="badgePopular" class="badge-preview-popular">Popular</label>
                                    </div>
                                    <div class="badge-type-option">
                                        <input type="radio" name="badge_type" id="badgePremium" value="premium">
                                        <label for="badgePremium" class="badge-preview-premium">Premium</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Body Content -->
                        <div class="form-section-title">
                            <i class="ri-file-text-line"></i> Body Content
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label">Heading <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="heading" name="heading" placeholder="e.g. DOT Sidewalk Violation Removal">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Main description paragraph"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Additional Description <small class="text-muted">(Optional)</small></label>
                                <textarea class="form-control" id="description_two" name="description_two" rows="3" placeholder="Second paragraph"></textarea>
                            </div>
                        </div>

                        <!-- Features Section -->
                        <div class="dynamic-section">
                            <div class="section-header">
                                <h6><i class="ri-list-check-2 me-2 text-success"></i>Features List</h6>
                                <span class="badge bg-light text-muted" id="featureCount">0 items</span>
                            </div>
                            <div class="dynamic-items" id="featuresContainer">
                                <!-- Feature items will be added here -->
                            </div>
                            <button type="button" class="btn-add-item mt-2" id="addFeatureBtn">
                                <i class="ri-add-line me-1"></i> Add Feature
                            </button>
                        </div>

                        <!-- Image & Button -->
                        <div class="form-section-title mt-4">
                            <i class="ri-image-line"></i> Image & CTA Button
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Service Image <small class="text-muted">(Recommended: 800x600)</small></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="mt-2">
                                    <div class="preview-image-container">
                                        <img id="preview-image" src="#" alt="" class="img-thumbnail rounded" style="max-width: 300px; display:none;">
                                        <button type="button" class="btn-remove-image" id="removePreviewImage" style="display:none;">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Button Text</label>
                                        <input type="text" class="form-control" id="btn_text" name="btn_text" value="Get Free Estimate" placeholder="Button text">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Button Link</label>
                                        <input type="text" class="form-control" id="btn_link" name="btn_link" placeholder="e.g. /contact or #">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card-footer text-end">
                    <button type="button" id="FormCloseBtn" class="btn btn-light me-2">Cancel</button>
                    <button type="button" id="addBtn" class="btn btn-primary" value="Create">
                        <i class="ri-save-line me-1"></i> Create
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" id="contentContainer">
    <ul class="nav nav-tabs mb-3" id="serviceTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="list-tab" data-bs-toggle="tab" href="#list" role="tab">
                <i class="ri-list-unordered me-1"></i> Service List
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="sort-tab" data-bs-toggle="tab" href="#sort" role="tab">
                <i class="ri-drag-move-line me-1"></i> Sort Services
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="list" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">All Services</h4>
                </div>
                <div class="card-body">
                    <table id="serviceTable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width:50px;">Sl</th>
                                <th>Title & Subtitle</th>
                                <th style="width:100px;">Image</th>
                                <th style="width:60px;">Order</th>
                                <th style="width:80px;">Status</th>
                                <th style="width:80px;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="sort" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sort Services</h4>
                    <small class="text-muted">Drag & drop rows to change display order</small>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:60px;">Order</th>
                                <th>Image</th>
                                <th>Icon</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach ($services as $service)
                                <tr data-id="{{ $service->id }}" style="cursor:grab;">
                                    <td class="text-center">
                                        <i class="ri-draggable text-muted"></i> {{ $service->serial }}
                                    </td>
                                    <td>
                                        @if($service->image)
                                            <img src="{{ asset('uploads/service/'.$service->image) }}" class="img-thumbnail" style="width:60px;height:35px;object-fit:cover;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><i class="{{ $service->icon }} text-primary fs-5"></i></td>
                                    <td>{{ $service->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Available icons for features
const availableIcons = [
    { value: 'bi bi-check-circle-fill', label: 'Check Circle' },
    { value: 'bi bi-check2-circle', label: 'Check Circle 2' },
    { value: 'bi bi-shield-check', label: 'Shield Check' },
    { value: 'bi bi-star-fill', label: 'Star' },
    { value: 'bi bi-lightning-fill', label: 'Lightning' },
    { value: 'bi bi-clock-fill', label: 'Clock' },
    { value: 'bi bi-geo-alt-fill', label: 'Location' },
    { value: 'bi bi-people-fill', label: 'People' },
    { value: 'bi bi-tools', label: 'Tools' },
    { value: 'bi bi-truck', label: 'Truck' },
    { value: 'bi bi-award-fill', label: 'Award' },
    { value: 'bi bi-hand-thumbs-up-fill', label: 'Thumbs Up' },
    { value: 'bi bi-gear-fill', label: 'Gear' },
    { value: 'bi bi-bullseye', label: 'Bullseye' },
];

let featureCounter = 0;

 $(document).ready(function() {

    // ===== SORTABLE =====
    $("#sortable").sortable({
        placeholder: "ui-state-highlight",
        cursor: "grab",
        forcePlaceholderSize: true,
        opacity: 0.8,
        update: function(event, ui) {
            var order = $(this).sortable('toArray', { attribute: 'data-id' });
            $.ajax({
                url: "{{ route('services.updateOrder') }}",
                method: "POST",
                data: { _token: '{{ csrf_token() }}', order: order },
                success: function(res) {
                    showSuccess(res.message);
                    $("#sortable tr").each(function(index) {
                        $(this).find("td:first").html('<i class="ri-draggable text-muted"></i> ' + (index + 1));
                    });
                    reloadTable('#serviceTable');
                },
                error: function(xhr) {
                    showError(xhr.responseJSON?.message ?? "Something went wrong!");
                }
            });
        }
    });

    // ===== DATATABLE =====
    var serviceTable = $('#serviceTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('allservice') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title_info', name: 'title', orderable: true, searchable: true },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'serial', name: 'serial', orderable: true, searchable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // ===== TOGGLE STATUS =====
    $(document).on('change', '.toggle-status', function() {
        var service_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.post('/admin/service-status', {
            _token: '{{ csrf_token() }}',
            service_id: service_id,
            status: status
        }, function(d) {
            showSuccess(d.message);
        }).fail(function() {
            showError('Failed to update status');
        });
    });

    // ===== FORM SHOW/HIDE =====
    $("#newBtn").click(function() {
        clearform();
        $("#addThisFormContainer").slideDown(300);
        $("#newBtnSection").hide();
        $("html, body").animate({ scrollTop: 0 }, 300);
    });

    $("#FormCloseBtn").click(function() {
        $("#addThisFormContainer").slideUp(300);
        setTimeout(function() {
            $("#newBtnSection").show();
        }, 300);
    });

    // ===== AUTO SLUG GENERATION =====
    $('#title').on('input', function() {
        if (!$('#slug').data('manuallyEdited')) {
            var slug = $(this).val().toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            $('#slug').val(slug);
        }
    });

    $('#slug').on('input', function() {
        $(this).data('manuallyEdited', true);
        var val = $(this).val().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        $(this).val(val);
    });

    // ===== IMAGE PREVIEW =====
    $('#image').on('change', function(e) {
        previewImage(e, '#preview-image');
        if (e.target.files && e.target.files[0]) {
            $('#preview-image').show();
            $('#removePreviewImage').show();
        }
    });

    $('#removePreviewImage').click(function() {
        $('#image').val('');
        $('#preview-image').attr('src', '#').hide();
        $(this).hide();
    });

    // ===== ADD FEATURE =====
    $('#addFeatureBtn').click(function() {
        addFeatureRow();
    });

    // ===== REMOVE DYNAMIC ITEM =====
    $(document).on('click', '.btn-remove-item', function() {
        $(this).closest('.feature-row').fadeOut(200, function() {
            $(this).remove();
            updateCounts();
        });
    });

    // ===== SUBMIT FORM =====
    var url = "{{ URL::to('/admin/service') }}";
    var upurl = "{{ URL::to('/admin/service-update') }}";

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $("#addBtn").click(function() {
        var btnValue = $(this).val();
        var form_data = new FormData();
        
        form_data.append("title", $("#title").val());
        form_data.append("subtitle", $("#subtitle").val());
        form_data.append("slug", $("#slug").val());
        form_data.append("icon", $("#icon").val());
        form_data.append("badge", $("#badge").val());
        form_data.append("badge_type", $('input[name="badge_type"]:checked').val());
        form_data.append("badge_class", $('input[name="badge_type"]:checked').val() === 'urgent' ? 'urgent' : '');
        form_data.append("urgent_tag", $("#urgent_tag").val());
        form_data.append("heading", $("#heading").val());
        form_data.append("description", $("#description").val());
        form_data.append("description_two", $("#description_two").val());
        form_data.append("btn_text", $("#btn_text").val());
        form_data.append("btn_link", $("#btn_link").val());

        // Collect features - send as array format for Laravel
        $('.feature-row').each(function(index) {
            var icon = $(this).find('.feature-icon').val();
            var text = $(this).find('.feature-text').val();
            if (text.trim()) {
                form_data.append("features[" + index + "][icon]", icon);
                form_data.append("features[" + index + "][text]", text);
            }
        });

        // Image
        var featureImgInput = document.getElementById('image');
        if (featureImgInput.files && featureImgInput.files[0]) {
            form_data.append("image", featureImgInput.files[0]);
        }

        if (btnValue === 'Create') {
            $.ajax({
                url: url,
                type: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success: function(d) {
                    showSuccess(d.message);
                    closeForm();
                    reloadTable('#serviceTable');
                    clearform();
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON?.errors;
                    if (errors) {
                        var firstError = Object.values(errors)[0][0];
                        showError(firstError);
                    } else {
                        showError(xhr.responseJSON?.message ?? "Something went wrong!");
                    }
                }
            });
        }

        if (btnValue === 'Update') {
            form_data.append("codeid", $("#codeid").val());
            $.ajax({
                url: upurl,
                type: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success: function(d) {
                    showSuccess(d.message);
                    closeForm();
                    reloadTable('#serviceTable');
                    clearform();
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON?.errors;
                    if (errors) {
                        var firstError = Object.values(errors)[0][0];
                        showError(firstError);
                    } else {
                        showError(xhr.responseJSON?.message ?? "Something went wrong!");
                    }
                }
            });
        }
    });

    // ===== EDIT BUTTON =====
    $("#contentContainer").on('click', '#EditBtn', function() {
        var codeid = $(this).attr('rid');
        $.get(url + '/' + codeid + '/edit', {}, function(d) {
            populateForm(d);
        });
    });

    // ===== HELPER FUNCTIONS =====
    function closeForm() {
        $("#addThisFormContainer").slideUp(300);
        setTimeout(function() {
            $("#newBtnSection").show();
        }, 300);
    }

    function populateForm(data) {
        $("#cardTitle").html('<i class="ri-edit-line me-2"></i>Update Service');
        $("#title").val(data.title);
        $("#subtitle").val(data.subtitle || '');
        
        // Slug
        $('#slug').data('manuallyEdited', true); // Prevent auto-overwrite while editing
        $("#slug").val(data.slug || '');
        
        $("#icon").val(data.icon || 'bi bi-wrench-adjustable');
        $("#badge").val(data.badge || '');
        $("#urgent_tag").val(data.urgent_tag || '');
        
        // Set badge type radio
        var badgeType = data.badge_type || 'default';
        $('input[name="badge_type"][value="' + badgeType + '"]').prop('checked', true);
        
        $("#heading").val(data.heading);
        $("#description").val(data.description);
        $("#description_two").val(data.description_two || '');
        $("#btn_text").val(data.btn_text || 'Get Free Estimate');
        $("#btn_link").val(data.btn_link || '');
        $("#codeid").val(data.id);
        $("#addBtn").val('Update').html('<i class="ri-save-line me-1"></i> Update');

        // Show image preview
        if (data.image) {
            $('#preview-image').attr('src', '/uploads/service/' + data.image).show();
            $('#removePreviewImage').show();
        } else {
            $('#preview-image').hide();
            $('#removePreviewImage').hide();
        }

        // Load features
        $('#featuresContainer').empty();
        featureCounter = 0;
        if (data.features && data.features.length > 0) {
            data.features.forEach(function(item) {
                addFeatureRow(item.icon, item.text);
            });
        }

        updateCounts();
        $("#addThisFormContainer").slideDown(300);
        $("#newBtnSection").hide();
        $("html, body").animate({ scrollTop: 0 }, 300);
    }

    function clearform() {
        $('#createThisForm')[0].reset();
        $("#addBtn").val('Create').html('<i class="ri-save-line me-1"></i> Create');
        $("#cardTitle").html('<i class="ri-service-line me-2"></i>Add New Service');
        $("#icon").val('bi bi-shield-exclamation');
        $("#btn_text").val('Get Free Estimate');
        $('input[name="badge_type"][value="default"]').prop('checked', true);
        $('#slug').removeData('manuallyEdited'); // Reset slug auto-generation
        $('#preview-image').attr('src', '#').hide();
        $('#removePreviewImage').hide();
        $('#featuresContainer').empty();
        featureCounter = 0;
        updateCounts();
    }

    function addFeatureRow(icon, text) {
        featureCounter++;
        var iconOptions = availableIcons.map(function(i) {
            var selected = (icon && i.value === icon) ? 'selected' : '';
            return '<option value="' + i.value + '" ' + selected + '>' + i.label + '</option>';
        }).join('');

        var html = `
            <div class="feature-row">
                <select class="form-select form-select-sm feature-icon icon-select">
                    ${iconOptions}
                </select>
                <input type="text" class="form-control form-control-sm feature-text" 
                       placeholder="Feature text" value="${text || ''}">
                <button type="button" class="btn-remove-item">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        `;
        $('#featuresContainer').append(html);
        updateCounts();
    }

    function updateCounts() {
        $('#featureCount').text($('.feature-row').length + ' items');
    }
});

function previewImage(event, imgSelector) {
    if (event.target.files && event.target.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(imgSelector).attr('src', e.target.result).show();
        };
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>

@endsection