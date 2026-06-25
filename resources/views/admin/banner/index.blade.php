@extends('admin.pages.master')
@section('title', 'Banner')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button type="button" class="btn btn-primary" id="newBtn">
                    Add New Banner
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Banner</h4>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm">
                            @csrf
                            <input type="hidden" id="codeid" name="codeid">

                            <!-- Basic Info -->
                            <h6 class="fw-semibold mb-3 text-primary">
                                <i class="fas fa-info-circle me-1"></i> Basic Information
                            </h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Page <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="page" name="page">
                                        <option value="">Select Page</option>
                                        <option value="Home">Home</option>
                                        <option value="About">About</option>
                                        <option value="Contact">Contact</option>
                                        <option value="Service">Service</option>
                                        <option value="Gallery">Gallery</option>
                                        <option value="Testimonial">Testimonial</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter subtitle">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Feature Image</label>
                                    <input type="file" class="form-control" id="image" accept="image/*"
                                        onchange="previewImage(event, '#preview-image')">
                                    <small class="text-muted">Recommended: 1920x600 px</small>
                                    <img id="preview-image" src="#" alt="" class="img-thumbnail rounded mt-2"
                                        style="max-width: 300px; display: none;">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Existing Feature Image</label>
                                    <div id="existingImageContainer" style="display: none;">
                                        <img id="existingImage" src="#" alt="" class="img-thumbnail rounded"
                                            style="max-width: 300px;">
                                    </div>
                                    <p id="noExistingImage" class="text-muted mb-0" style="padding-top: 8px;">No image uploaded</p>
                                </div>
                            </div>

                            <!-- SEO Section -->
                            <h6 class="fw-semibold mb-3 text-primary">
                                <i class="fas fa-search me-1"></i> SEO Settings
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">SEO Title</label>
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" 
                                        placeholder="Enter SEO title" maxlength="255"
                                        oninput="updateCharCount(this, '#seoTitleCount', 255)">
                                    <small class="text-muted"><span id="seoTitleCount">0</span>/255 characters</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">SEO Description</label>
                                    <textarea class="form-control" id="seo_description" name="seo_description" 
                                        rows="3" placeholder="Enter SEO description" maxlength="500"
                                        oninput="updateCharCount(this, '#seoDescCount', 500)"></textarea>
                                    <small class="text-muted"><span id="seoDescCount">0</span>/500 characters</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">SEO Keywords</label>
                                    <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" 
                                        placeholder="keyword1, keyword2, keyword3">
                                    <small class="text-muted">Separate keywords with commas</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">OG Image</label>
                                    <input type="file" class="form-control" id="og_image" accept="image/*"
                                        onchange="previewImage(event, '#preview-og-image')">
                                    <small class="text-muted">For social sharing (1200x630 px)</small>
                                    <img id="preview-og-image" src="#" alt="" class="img-thumbnail rounded mt-2"
                                        style="max-width: 250px; display: none;">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Existing OG Image</label>
                                    <div id="existingOgImageContainer" style="display: none;">
                                        <img id="existingOgImage" src="#" alt="" class="img-thumbnail rounded"
                                            style="max-width: 250px;">
                                    </div>
                                    <p id="noExistingOgImage" class="text-muted mb-0" style="padding-top: 8px;">No image uploaded</p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" id="addBtn" class="btn btn-primary">
                            Create
                        </button>
                        <button type="button" id="FormCloseBtn" class="btn btn-light">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Banners</h4>
            </div>
            <div class="card-body">
                <table id="bannerTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Page</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>SEO Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid rounded" alt="Full Image">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        // Character count function
        function updateCharCount(input, counterSelector, max) {
            $(counterSelector).text($(input).val().length);
        }

        // Image preview function (if not already defined globally)
        function previewImage(event, previewSelector) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(previewSelector).attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                $(previewSelector).hide();
            }
        }

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select Page",
                allowClear: true,
                width: '100%'
            });

            // Hide form initially
            $("#addThisFormContainer").hide();

            // Show form
            $("#newBtn").click(function() {
                clearform();
                $("#newBtn").hide(100);
                $("#addThisFormContainer").show(300);

                // Re-initialize Select2 when form is shown
                $('#page').select2({
                    placeholder: "Select Page",
                    allowClear: true,
                    width: '100%'
                });
            });

            // Hide form
            $("#FormCloseBtn").click(function() {
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var url = "{{ URL::to('/admin/banner') }}";
            var upurl = "{{ URL::to('/admin/banner-update') }}";

            // DataTable
            $('#bannerTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: "{{ route('banner.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'page',
                        name: 'page'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'feature_image',
                        name: 'feature_image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'seo_title',
                        name: 'seo_title'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Show full image in modal
            $(document).on('click', '.feature-img', function() {
                let imgSrc = $(this).data('full');
                $('#modalImage').attr('src', imgSrc);
                new bootstrap.Modal(document.getElementById('imageModal')).show();
            });

            // Status Toggle
            $(document).on('change', '.toggle-status', function() {
                var banner_id = $(this).data('id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: '/admin/banner-status',
                    method: "POST",
                    data: {
                        id: banner_id,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(d) {
                        reloadTable('#bannerTable');
                        showSuccess(d.message);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        showError('Failed to update status');
                    }
                });
            });

            // CREATE & UPDATE
            $("#addBtn").click(function() {
                var form_data = new FormData();
                form_data.append("page", $("#page").val());
                form_data.append("title", $("#title").val());
                form_data.append("subtitle", $("#subtitle").val());
                form_data.append("seo_title", $("#seo_title").val());
                form_data.append("seo_description", $("#seo_description").val());
                form_data.append("seo_keywords", $("#seo_keywords").val());

                // Feature Image
                var featureImgInput = document.getElementById('image');
                if (featureImgInput.files && featureImgInput.files[0]) {
                    form_data.append("image", featureImgInput.files[0]);
                }

                // OG Image
                var ogImgInput = document.getElementById('og_image');
                if (ogImgInput.files && ogImgInput.files[0]) {
                    form_data.append("og_image", ogImgInput.files[0]);
                }

                // Create
                if ($(this).val() == 'Create') {
                    $.ajax({
                        url: url,
                        method: "POST",
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function(d) {
                            showSuccess(d.message);
                            $("#addThisFormContainer").slideUp(300);
                            setTimeout(() => {
                                $("#newBtn").show(200);
                            }, 300);
                            reloadTable('#bannerTable');
                            clearform();
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                let firstError = Object.values(xhr.responseJSON.errors)[0][0];
                                showError(firstError);
                            } else {
                                showError(xhr.responseJSON?.message ?? "Something went wrong!");
                            }
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Update
                if ($(this).val() == 'Update') {
                    form_data.append("id", $("#codeid").val());

                    $.ajax({
                        url: upurl,
                        type: "POST",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function(d) {
                            showSuccess(d.message);
                            $("#addThisFormContainer").slideUp(300);
                            setTimeout(() => {
                                $("#newBtn").show(200);
                            }, 300);
                            reloadTable('#bannerTable');
                            clearform();
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                let firstError = Object.values(xhr.responseJSON.errors)[0][0];
                                showError(firstError);
                            } else {
                                showError(xhr.responseJSON?.message ?? "Something went wrong!");
                            }
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Edit
            $("#contentContainer").on('click', '#EditBtn', function() {
                $("#cardTitle").text('Update this data');
                codeid = $(this).attr('rid');
                info_url = url + '/' + codeid + '/edit';
                $.get(info_url, {}, function(d) {
                    populateForm(d);
                    pagetop();
                });
            });

            // Delete
            $("#contentContainer").on('click', '#DeleteBtn', function() {
                if (!confirm('Are you sure you want to delete this banner?')) return;
                codeid = $(this).attr('rid');
                delete_url = url + '/' + codeid + '/delete';
                $.get(delete_url, function(d) {
                    showSuccess(d.message);
                    reloadTable('#bannerTable');
                });
            });

            // Populate form for edit
            function populateForm(data) {
                $("#page").val(data.page);
                $("#title").val(data.title || '');
                $("#subtitle").val(data.subtitle || '');
                $("#seo_title").val(data.seo_title || '');
                $("#seo_description").val(data.seo_description || '');
                $("#seo_keywords").val(data.seo_keywords || '');
                $("#codeid").val(data.id);
                $("#addBtn").val('Update');
                $("#addBtn").html('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);

                // Set Select2 value
                setTimeout(function() {
                    if (data.page) {
                        $('#page').val(data.page).trigger('change');
                    } else {
                        $('#page').val(null).trigger('change');
                    }
                }, 300);

                // Update character counters
                $('#seoTitleCount').text((data.seo_title || '').length);
                $('#seoDescCount').text((data.seo_description || '').length);

                // Show existing feature image
                var featureImagePreview = document.getElementById('preview-image');
                if (data.feature_image) {
                    $('#existingImage').attr('src', data.feature_image);
                    $('#existingImageContainer').show();
                    $('#noExistingImage').hide();
                    featureImagePreview.style.display = 'none';
                } else {
                    $('#existingImageContainer').hide();
                    $('#noExistingImage').show();
                    featureImagePreview.style.display = 'none';
                }

                // Show existing OG image
                var ogImagePreview = document.getElementById('preview-og-image');
                if (data.og_image) {
                    $('#existingOgImage').attr('src', data.og_image);
                    $('#existingOgImageContainer').show();
                    $('#noExistingOgImage').hide();
                    ogImagePreview.style.display = 'none';
                } else {
                    $('#existingOgImageContainer').hide();
                    $('#noExistingOgImage').show();
                    ogImagePreview.style.display = 'none';
                }
            }

            // Clear form
            function clearform() {
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
                $("#addBtn").html('Create');
                $("#cardTitle").text('Add New Banner');

                // Hide preview images
                $('#preview-image').attr('src', '#').hide();
                $('#preview-og-image').attr('src', '#').hide();

                // Hide existing images
                $('#existingImageContainer').hide();
                $('#existingOgImageContainer').hide();
                $('#noExistingImage').show();
                $('#noExistingOgImage').show();

                // Reset character counters
                $('#seoTitleCount').text('0');
                $('#seoDescCount').text('0');

                // Clear Select2
                $('#page').val(null).trigger('change');
            }
        });
    </script>
@endsection