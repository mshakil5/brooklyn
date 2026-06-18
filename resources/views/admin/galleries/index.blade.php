@extends('admin.pages.master')
@section('title', 'Gallery Management')

@section('content')
<div class="container-fluid" id="newBtnSection">
    <button type="button" class="btn btn-primary mb-3" id="newBtn">
        <i class="fas fa-plus me-1"></i> Add New Gallery Item
    </button>
</div>

{{-- ADD / EDIT FORM --}}
<div class="container-fluid" id="addThisFormContainer" style="display: none;">
    <div class="card">
        <div class="card-header"><h4 id="cardTitle">Add New Gallery Item</h4></div>
        <div class="card-body">
            <form id="createThisForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="codeid" name="codeid">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="image">Image (Before/After)</option>
                            <option value="video">Upload Video</option>
                            <option value="youtube">YouTube Link</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Select Category</option>
                            @foreach(App\Models\Gallery::getCategoryOptions() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="e.g. Flushing Main Street Repair" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Location</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="e.g. Flushing, Queens">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Year</label>
                        <input type="text" class="form-control" name="year" id="year" placeholder="e.g. 2024" maxlength="4">
                    </div>

                    {{-- BEFORE / AFTER IMAGES (Only for Image Type) --}}
                    <div class="col-md-4 mb-3" id="beforeWrap">
                        <label class="form-label fw-semibold">Before Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="before_image" id="before_image" accept="image/*">
                        <div id="currentBeforeWrap" class="mt-2" style="display:none;">
                            <small class="text-muted">Current:</small><br>
                            <img id="currentBeforePreview" src="" width="80" class="img-thumbnail mt-1">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3" id="afterWrap">
                        <label class="form-label fw-semibold">After Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="after_image" id="after_image" accept="image/*">
                        <div id="currentAfterWrap" class="mt-2" style="display:none;">
                            <small class="text-muted">Current:</small><br>
                            <img id="currentAfterPreview" src="" width="80" class="img-thumbnail mt-1">
                        </div>
                    </div>

                    {{-- LEGACY YOUTUBE / VIDEO / SINGLE IMAGE --}}
                    <div class="col-md-12 mb-3" id="linkWrap" style="display:none;">
                        <label class="form-label fw-semibold">YouTube Video Link <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" name="video_link" id="video_link" placeholder="https://www.youtube.com/watch?v=xxxxx">
                    </div>

                    <div class="col-md-6 mb-3" id="fileWrap" style="display:none;">
                        <label class="form-label fw-semibold" id="fileLabel">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" id="file">
                        <div id="currentFileWrap" class="mt-2" style="display:none;">
                            <small class="text-muted">Current file:</small><br>
                            <img id="currentFilePreview" src="" width="80" class="img-thumbnail mt-1">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3" id="thumbnailWrap" style="display:none;">
                        <label class="form-label fw-semibold">Thumbnail</label>
                        <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" id="sort_order" value="0" min="0">
                    </div>

                    <div class="col-md-1 mb-3 d-flex align-items-center">
                        <div>
                            <label class="form-label fw-semibold d-block">Active</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="addBtn" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Item</button>
            <button type="button" id="FormCloseBtn" class="btn btn-light ms-2">Cancel</button>
        </div>
    </div>
</div>

{{-- DATA TABLE --}}
<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-body">
            <table id="galleryTable" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Preview</th>
                        <th>Title & Location</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
 $(document).ready(function () {
    var table = $('#galleryTable').DataTable({
        processing: true, serverSide: true,
        ajax: "{{ route('admin.galleries') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'preview', name: 'preview', orderable: false, searchable: false },
            { 
                data: 'title', name: 'title', 
                render: function(data, type, row) {
                    return '<strong>'+data+'</strong><br><small class="text-muted">'+(row.location || '')+'</small>';
                }
            },
            { data: 'sort_order', name: 'sort_order' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    function toggleFields() {
        var type = $('#type').val();
        $('#fileWrap, #thumbnailWrap, #linkWrap, #beforeWrap, #afterWrap').hide();
        $('#file, #thumbnail, #video_link, #before_image, #after_image').prop('required', false);

        if (type === 'image') {
            $('#beforeWrap, #afterWrap').show();
            $('#before_image, #after_image').prop('required', true);
        } else if (type === 'video') {
            $('#fileWrap, #thumbnailWrap').show();
            $('#file').prop('required', true);
            $('#file').attr('accept', 'video/*');
        } else if (type === 'youtube') {
            $('#linkWrap').show();
            $('#video_link').prop('required', true);
        }
    }

    $('#type').on('change', toggleFields);
    toggleFields();

    $('#addBtn').click(function () {
        var id  = $('#codeid').val();
        var url = id ? "{{ url('/admin/galleries-update') }}" : "{{ route('admin.galleries') }}";
        var fd  = new FormData($('#createThisForm')[0]);

        $.ajax({
            url: url, type: 'POST', data: fd,
            contentType: false, processData: false,
            success: function (d) {
                Swal.fire('Success', d.message, 'success');
                $('#addThisFormContainer').slideUp();
                $('#newBtn').show();
                table.draw();
            },
            error: function (xhr) {
                var errors = xhr.responseJSON?.errors;
                if (errors) {
                    var msg = Object.values(errors).flat().join('<br>');
                    Swal.fire('Validation Error', msg, 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            }
        });
    });

    $('#contentContainer').on('click', '#EditBtn', function () {
        var id = $(this).attr('rid');
        $.get('/admin/galleries/' + id + '/edit', function (data) {
            $('#codeid').val(data.id);
            $('#type').val(data.type).trigger('change');
            $('#category').val(data.category);
            $('#title').val(data.title);
            $('#location').val(data.location || '');
            $('#year').val(data.year || '');
            $('#sort_order').val(data.sort_order);
            $('#status').prop('checked', data.status == 1);
            $('#video_link').val(data.video_link || '');

            if (data.before_image) {
                $('#currentBeforePreview').attr('src', '/' + data.before_image);
                $('#currentBeforeWrap').show();
            } else { $('#currentBeforeWrap').hide(); }

            if (data.after_image) {
                $('#currentAfterPreview').attr('src', '/' + data.after_image);
                $('#currentAfterWrap').show();
            } else { $('#currentAfterWrap').hide(); }

            if (data.file_path) {
                $('#currentFilePreview').attr('src', '/' + data.file_path);
                $('#currentFileWrap').show();
            } else { $('#currentFileWrap').hide(); }

            $('#addThisFormContainer').slideDown();
            $('#newBtn').hide();
            $('#cardTitle').text('Edit Gallery Item');
        });
    });

    $('#newBtn').click(function () {
        $('#createThisForm')[0].reset();
        $('#codeid').val('');
        $('#currentBeforeWrap, #currentAfterWrap, #currentFileWrap').hide();
        toggleFields();
        $('#addThisFormContainer').slideDown();
        $(this).hide();
        $('#cardTitle').text('Add New Gallery Item');
    });

    $('#FormCloseBtn').click(function () {
        $('#addThisFormContainer').slideUp();
        $('#newBtn').show();
    });
});
</script>
@endsection