@extends('admin.pages.master')
@section('title', 'Slider Management')

@section('css')
<style>
    .highlight-row, .stat-row {
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
    .highlight-row, .stat-row {
        display: flex;
        gap: 10px;
        align-items: center;
        background: #fff;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
    .highlight-row .form-control, .stat-row .form-control {
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
        width: 180px !important;
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
</style>
@endsection

@section('content')

<div class="container-fluid" id="newBtnSection">
    <div class="row mb-3">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" id="newBtn">
                <i class="ri-add-line align-middle me-1"></i> Add New Slider
            </button>
        </div>
    </div>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">
                        <i class="ri-image-line me-2"></i>Add New Slider
                    </h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">

                        <!-- Basic Information -->
                        <div class="form-section-title">
                            <i class="ri-information-line"></i> Basic Information
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Slider Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter main heading">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slider Link</label>
                                <input type="text" class="form-control" id="link" name="link" placeholder="Enter link (optional)">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Subtitle / Description</label>
                                <textarea class="form-control" id="subtitle" name="subtitle" rows="3" placeholder="Enter subtitle or description text"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slider Image <small class="text-muted">(Recommended: 1920x1080)</small></label>
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
                        </div>

                        <!-- Highlights Section -->
                        <div class="dynamic-section">
                            <div class="section-header">
                                <h6><i class="ri-checkbox-circle-line me-2 text-success"></i>Highlights / Features</h6>
                                <span class="badge bg-light text-muted" id="highlightCount">0 items</span>
                            </div>
                            <div class="dynamic-items" id="highlightsContainer">
                                <!-- Highlight items will be added here -->
                            </div>
                            <button type="button" class="btn-add-item mt-2" id="addHighlightBtn">
                                <i class="ri-add-line me-1"></i> Add Highlight
                            </button>
                        </div>

                        <!-- Stats Section -->
                        <div class="dynamic-section">
                            <div class="section-header">
                                <h6><i class="ri-bar-chart-box-line me-2 text-primary"></i>Statistics Bar</h6>
                                <span class="badge bg-light text-muted" id="statCount">0 items</span>
                            </div>
                            <div class="dynamic-items" id="statsContainer">
                                <!-- Stat items will be added here -->
                            </div>
                            <button type="button" class="btn-add-item mt-2" id="addStatBtn">
                                <i class="ri-add-line me-1"></i> Add Stat
                            </button>
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
    <ul class="nav nav-tabs mb-3" id="sliderTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="list-tab" data-bs-toggle="tab" href="#list" role="tab">
                <i class="ri-list-unordered me-1"></i> Slider List
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="sort-tab" data-bs-toggle="tab" href="#sort" role="tab">
                <i class="ri-drag-move-line me-1"></i> Sort Sliders
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="list" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">All Sliders</h4>
                </div>
                <div class="card-body">
                    <table id="sliderTable" class="table table-bordered table-striped dt-responsive nowrap w-100">
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
                    <h4 class="card-title mb-0">Sort Sliders</h4>
                    <small class="text-muted">Drag & drop rows to change display order</small>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:60px;">Order</th>
                                <th>Image</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach ($sliders as $slider)
                                <tr data-id="{{ $slider->id }}" style="cursor:grab;">
                                    <td class="text-center">
                                        <i class="ri-draggable text-muted"></i> {{ $slider->serial }}
                                    </td>
                                    <td>
                                        @if($slider->image)
                                            <img src="{{ asset('uploads/slider/'.$slider->image) }}" class="img-thumbnail" style="width:60px;height:35px;object-fit:cover;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $slider->title }}</td>
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
// Available icons for highlights
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
];

let highlightCounter = 0;
let statCounter = 0;

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
                url: "{{ route('sliders.updateOrder') }}",
                method: "POST",
                data: { _token: '{{ csrf_token() }}', order: order },
                success: function(res) {
                    showSuccess(res.message);
                    $("#sortable tr").each(function(index) {
                        $(this).find("td:first").html('<i class="ri-draggable text-muted"></i> ' + (index + 1));
                    });
                    reloadTable('#sliderTable');
                },
                error: function(xhr) {
                    showError(xhr.responseJSON?.message ?? "Something went wrong!");
                }
            });
        }
    });

    // ===== DATATABLE =====
    var sliderTable = $('#sliderTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('allslider') }}",
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
        var slider_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.post('/admin/slider-status', {
            _token: '{{ csrf_token() }}',
            slider_id: slider_id,
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

    // ===== ADD HIGHLIGHT =====
    $('#addHighlightBtn').click(function() {
        addHighlightRow();
    });

    // ===== ADD STAT =====
    $('#addStatBtn').click(function() {
        addStatRow();
    });

    // ===== REMOVE DYNAMIC ITEM =====
    $(document).on('click', '.btn-remove-item', function() {
        $(this).closest('.highlight-row, .stat-row').fadeOut(200, function() {
            $(this).remove();
            updateCounts();
        });
    });

    // ===== SUBMIT FORM =====
    var url = "{{ URL::to('/admin/slider') }}";
    var upurl = "{{ URL::to('/admin/slider-update') }}";

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $("#addBtn").click(function() {
        var btnValue = $(this).val();
        var form_data = new FormData();
        
        form_data.append("title", $("#title").val());
        form_data.append("subtitle", $("#subtitle").val());
        form_data.append("link", $("#link").val());

        // Collect highlights - send as array format for Laravel
        $('.highlight-row').each(function(index) {
            var icon = $(this).find('.highlight-icon').val();
            var text = $(this).find('.highlight-text').val();
            if (text.trim()) {
                form_data.append("highlights[" + index + "][icon]", icon);
                form_data.append("highlights[" + index + "][text]", text);
            }
        });

        // Collect stats - send as array format for Laravel
        $('.stat-row').each(function(index) {
            var number = $(this).find('.stat-number').val();
            var label = $(this).find('.stat-label').val();
            if (number.trim() && label.trim()) {
                form_data.append("stats[" + index + "][number]", number);
                form_data.append("stats[" + index + "][label]", label);
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
                    reloadTable('#sliderTable');
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
                    reloadTable('#sliderTable');
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
        $("#cardTitle").html('<i class="ri-edit-line me-2"></i>Update Slider');
        $("#title").val(data.title);
        $("#subtitle").val(data.subtitle || '');
        $("#link").val(data.link || '');
        $("#codeid").val(data.id);
        $("#addBtn").val('Update').html('<i class="ri-save-line me-1"></i> Update');

        // Show image preview
        if (data.image) {
            $('#preview-image').attr('src', '/uploads/slider/' + data.image).show();
            $('#removePreviewImage').show();
        } else {
            $('#preview-image').hide();
            $('#removePreviewImage').hide();
        }

        // Load highlights
        $('#highlightsContainer').empty();
        highlightCounter = 0;
        if (data.highlights && data.highlights.length > 0) {
            data.highlights.forEach(function(item) {
                addHighlightRow(item.icon, item.text);
            });
        }

        // Load stats
        $('#statsContainer').empty();
        statCounter = 0;
        if (data.stats && data.stats.length > 0) {
            data.stats.forEach(function(item) {
                addStatRow(item.number, item.label);
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
        $("#cardTitle").html('<i class="ri-image-line me-2"></i>Add New Slider');
        $('#preview-image').attr('src', '#').hide();
        $('#removePreviewImage').hide();
        $('#highlightsContainer').empty();
        $('#statsContainer').empty();
        highlightCounter = 0;
        statCounter = 0;
        updateCounts();
    }

    function addHighlightRow(icon, text) {
        highlightCounter++;
        var iconOptions = availableIcons.map(function(i) {
            var selected = (icon && i.value === icon) ? 'selected' : '';
            return '<option value="' + i.value + '" ' + selected + '>' + i.label + '</option>';
        }).join('');

        var html = `
            <div class="highlight-row">
                <select class="form-select form-select-sm highlight-icon icon-select">
                    ${iconOptions}
                </select>
                <input type="text" class="form-control form-control-sm highlight-text" 
                       placeholder="Highlight text" value="${text || ''}">
                <button type="button" class="btn-remove-item">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        `;
        $('#highlightsContainer').append(html);
        updateCounts();
    }

    function addStatRow(number, label) {
        statCounter++;
        var html = `
            <div class="stat-row">
                <input type="text" class="form-control form-control-sm stat-number" 
                       placeholder="e.g. 5,000+" value="${number || ''}" style="max-width:150px;">
                <input type="text" class="form-control form-control-sm stat-label" 
                       placeholder="e.g. Projects Completed" value="${label || ''}">
                <button type="button" class="btn-remove-item">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        `;
        $('#statsContainer').append(html);
        updateCounts();
    }

    function updateCounts() {
        $('#highlightCount').text($('.highlight-row').length + ' items');
        $('#statCount').text($('.stat-row').length + ' items');
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