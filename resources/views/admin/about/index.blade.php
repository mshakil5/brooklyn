@extends('admin.pages.master')
@section('title', 'About Us Management')
@section('content')

<!-- Tab Navigation -->
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="aboutTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabHero" type="button">
                        <i class="ri-home-4-line me-1"></i> Hero Section
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabStats" type="button">
                        <i class="ri-bar-chart-box-line me-1"></i> Stats
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabStory" type="button">
                        <i class="ri-book-open-line me-1"></i> Our Story
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabHighlights" type="button">
                        <i class="ri-check-double-line me-1"></i> Highlights
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabMilestones" type="button">
                        <i class="ri-time-line me-1"></i> Milestones
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabValues" type="button">
                        <i class="ri-heart-2-line me-1"></i> Core Values
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabCerts" type="button">
                        <i class="ri-shield-check-line me-1"></i> Certifications
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="aboutTabContent">

                <!-- ========== TAB: HERO SECTION ========== -->
                <div class="tab-pane fade show active" id="tabHero">
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="heroForm">
                                @csrf
                                <div class="mb-3">
                                    <label>Tag Line <span class="text-danger">*</span></label>
                                    <input type="text" name="hero_tag" value="{{ $aboutPage->hero_tag ?? 'Our Story' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="hero_title" value="{{ $aboutPage->hero_title ?? '' }}" class="form-control" placeholder="25+ Years Building NYC's Sidewalks">
                                    <small class="text-muted">Use &lt;span class="text-blue"&gt; for blue text</small>
                                </div>
                                <div class="mb-3">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea name="hero_description" rows="4" class="form-control summernote">{!! $aboutPage->hero_description ?? '' !!}</textarea>
                                </div>
                                <button type="button" class="btn btn-primary" id="saveHeroBtn">
                                    <i class="ri-save-line me-1"></i> Save Hero Section
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: STATS ========== -->
                <div class="tab-pane fade" id="tabStats">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Hero Stats</h5>
                        <button class="btn btn-primary btn-sm" id="newStatBtn">
                            <i class="ri-add-line me-1"></i> Add Stat
                        </button>
                    </div>
                    
                    <!-- Stat Form (Hidden) -->
                    <div id="statFormContainer" style="display:none;" class="mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 id="statFormTitle" class="mb-0">Add Stat</h6>
                            </div>
                            <div class="card-body">
                                <form id="statForm">
                                    @csrf
                                    <input type="hidden" id="stat_id" name="id">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label>Icon Class <span class="text-danger">*</span></label>
                                            <input type="text" id="stat_icon" name="icon" class="form-control" placeholder="bi-building">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Number <span class="text-danger">*</span></label>
                                            <input type="text" id="stat_number" name="number" class="form-control" placeholder="5,000+">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Label <span class="text-danger">*</span></label>
                                            <input type="text" id="stat_label" name="label" class="form-control" placeholder="Projects Done">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100" id="saveStatBtn">Save</button>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-light" id="cancelStatBtn">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table id="statTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Icon</th>
                                <th>Number</th>
                                <th>Label</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!-- ========== TAB: OUR STORY ========== -->
                <div class="tab-pane fade" id="tabStory">
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="storyForm">
                                @csrf
                                <div class="mb-3">
                                    <label>Tag Line <span class="text-danger">*</span></label>
                                    <input type="text" name="story_tag" value="{{ $aboutPage->story_tag ?? 'Our Journey' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="story_title" value="{{ $aboutPage->story_title ?? '' }}" class="form-control">
                                    <small class="text-muted">Use &lt;span class="text-blue"&gt; for blue text</small>
                                </div>
                                <div class="mb-3">
                                    <label>Content <span class="text-danger">*</span></label>
                                    <textarea name="story_content" rows="10" class="form-control summernote">{!! $aboutPage->story_content ?? '' !!}</textarea>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label>Badge Rating</label>
                                        <input type="text" name="badge_rating" value="{{ $aboutPage->badge_rating ?? 'A+' }}" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Badge Label</label>
                                        <input type="text" name="badge_label" value="{{ $aboutPage->badge_label ?? 'BBB Accredited' }}" class="form-control">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="saveStoryBtn">
                                    <i class="ri-save-line me-1"></i> Save Story Section
                                </button>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label>Story Image</label>
                                <div class="story-image-preview border rounded p-2 mb-2">
                                    @if($aboutPage->story_image)
                                        <img src="{{ Storage::url($aboutPage->story_image) }}" alt="Story" class="img-fluid rounded">
                                    @else
                                        <div class="text-center p-4 text-muted">
                                            <i class="ri-image-line fs-1"></i>
                                            <p class="mb-0">No image uploaded</p>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" id="storyImage" accept="image/*" class="form-control">
                                <small class="text-muted">Max: 2MB (JPG, PNG, WebP)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: HIGHLIGHTS ========== -->
                <div class="tab-pane fade" id="tabHighlights">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Story Highlights</h5>
                        <button class="btn btn-primary btn-sm" id="newHighlightBtn">
                            <i class="ri-add-line me-1"></i> Add Highlight
                        </button>
                    </div>
                    
                    <div id="highlightFormContainer" style="display:none;" class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                <form id="highlightForm">
                                    @csrf
                                    <input type="hidden" id="highlight_id" name="id">
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <label>Text <span class="text-danger">*</span></label>
                                            <input type="text" id="highlight_text" name="text" class="form-control" placeholder="Family-owned & operated since 1998">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100" id="saveHighlightBtn">Save</button>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-light w-100" id="cancelHighlightBtn">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table id="highlightTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Text</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!-- ========== TAB: MILESTONES ========== -->
                <div class="tab-pane fade" id="tabMilestones">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Company Milestones</h5>
                        <button class="btn btn-primary btn-sm" id="newMilestoneBtn">
                            <i class="ri-add-line me-1"></i> Add Milestone
                        </button>
                    </div>
                    
                    <div id="milestoneFormContainer" style="display:none;" class="mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 id="milestoneFormTitle" class="mb-0">Add Milestone</h6>
                            </div>
                            <div class="card-body">
                                <form id="milestoneForm">
                                    @csrf
                                    <input type="hidden" id="milestone_id" name="id">
                                    <div class="row g-3">
                                        <div class="col-md-2">
                                            <label>Year <span class="text-danger">*</span></label>
                                            <input type="text" id="milestone_year" name="year" class="form-control" placeholder="1998">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <input type="text" id="milestone_title" name="title" class="form-control" placeholder="Founded in Brooklyn">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <input type="text" id="milestone_description" name="description" class="form-control" placeholder="Short description...">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end gap-1">
                                            <button type="button" class="btn btn-primary flex-grow-1" id="saveMilestoneBtn">Save</button>
                                            <button type="button" class="btn btn-light" id="cancelMilestoneBtn"><i class="ri-close-line"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table id="milestoneTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Year</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!-- ========== TAB: CORE VALUES ========== -->
                <div class="tab-pane fade" id="tabValues">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Core Values</h5>
                        <button class="btn btn-primary btn-sm" id="newValueBtn">
                            <i class="ri-add-line me-1"></i> Add Value
                        </button>
                    </div>
                    
                    <div id="valueFormContainer" style="display:none;" class="mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 id="valueFormTitle" class="mb-0">Add Value</h6>
                            </div>
                            <div class="card-body">
                                <form id="valueForm">
                                    @csrf
                                    <input type="hidden" id="value_id" name="id">
                                    <div class="row g-3">
                                        <div class="col-md-2">
                                            <label>Icon <span class="text-danger">*</span></label>
                                            <input type="text" id="value_icon" name="icon" class="form-control" placeholder="bi-gem">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <input type="text" id="value_title" name="title" class="form-control" placeholder="Quality">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <input type="text" id="value_description" name="description" class="form-control" placeholder="Short description...">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end gap-1">
                                            <button type="button" class="btn btn-primary flex-grow-1" id="saveValueBtn">Save</button>
                                            <button type="button" class="btn btn-light" id="cancelValueBtn"><i class="ri-close-line"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table id="valueTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Icon</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!-- ========== TAB: CERTIFICATIONS ========== -->
                <div class="tab-pane fade" id="tabCerts">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Certifications</h5>
                        <button class="btn btn-primary btn-sm" id="newCertBtn">
                            <i class="ri-add-line me-1"></i> Add Certification
                        </button>
                    </div>
                    
                    <div id="certFormContainer" style="display:none;" class="mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 id="certFormTitle" class="mb-0">Add Certification</h6>
                            </div>
                            <div class="card-body">
                                <form id="certForm">
                                    @csrf
                                    <input type="hidden" id="cert_id" name="id">
                                    <div class="row g-3">
                                        <div class="col-md-2">
                                            <label>Icon <span class="text-danger">*</span></label>
                                            <input type="text" id="cert_icon" name="icon" class="form-control" placeholder="bi-patch-check-fill">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <input type="text" id="cert_title" name="title" class="form-control" placeholder="NYC Licensed Contractor">
                                        </div>
                                        <div class="col-md-2">
                                            <label>License Label <span class="text-danger">*</span></label>
                                            <input type="text" id="cert_license_label" name="license_label" class="form-control" placeholder="License #">
                                        </div>
                                        <div class="col-md-2">
                                            <label>License Number <span class="text-danger">*</span></label>
                                            <input type="text" id="cert_license_number" name="license_number" class="form-control" placeholder="CON-98-4421">
                                        </div>
                                        <div class="col-md-1">
                                            <label>Class</label>
                                            <input type="text" id="cert_license_class" name="license_class" class="form-control" placeholder="approved">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Status Text <span class="text-danger">*</span></label>
                                            <input type="text" id="cert_status_text" name="status_text" class="form-control" placeholder="Active & In Good Standing">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-10">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <input type="text" id="cert_description" name="description" class="form-control" placeholder="Short description...">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end gap-1">
                                            <button type="button" class="btn btn-primary flex-grow-1" id="saveCertBtn">Save</button>
                                            <button type="button" class="btn btn-light" id="cancelCertBtn"><i class="ri-close-line"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table id="certTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>License</th>
                                <th>Status Text</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // ========== HERO SECTION ==========
            $('#saveHeroBtn').click(function() {
                // SYNC SUMMERNOTE CONTENT BEFORE SUBMIT
                $('#heroForm .summernote').each(function() {
                    $(this).val($(this).summernote('code'));
                });

                var fd = new FormData(document.getElementById('heroForm'));
                $.ajax({
                    url: "{{ route('about.content.update') }}",
                    method: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(res) { showSuccess(res.message); },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        } else { showError('Error saving hero section'); }
                    }
                });
            });

            // ========== STORY SECTION ==========
            $('#saveStoryBtn').click(function() {
                // SYNC SUMMERNOTE CONTENT BEFORE SUBMIT
                $('#storyForm .summernote').each(function() {
                    $(this).val($(this).summernote('code'));
                });

                var fd = new FormData(document.getElementById('storyForm'));
                $.ajax({
                    url: "{{ route('about.content.update') }}",
                    method: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(res) { showSuccess(res.message); },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        } else { showError('Error saving story section'); }
                    }
                });
            });

            // Story Image Upload
            $('#storyImage').change(function() {
                var file = this.files[0];
                if (!file) return;
                var fd = new FormData();
                fd.append('image', file);
                $.ajax({
                    url: "{{ route('about.image.upload') }}",
                    method: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        showSuccess(res.message);
                        $('.story-image-preview').html('<img src="' + res.image + '" alt="Story" class="img-fluid rounded">');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        else showError('Error uploading image');
                    }
                });
            });

            // ========== STATS ==========
            var statTable = $('#statTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('about.stats.data') }}",
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'icon', name: 'icon' },
                    { data: 'number', name: 'number' },
                    { data: 'label', name: 'label' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newStatBtn').click(function() {
                $('#statForm')[0].reset();
                $('#stat_id').val('');
                $('#statFormTitle').text('Add Stat');
                $('#statFormContainer').show(300);
            });
            $('#cancelStatBtn').click(function() { $('#statFormContainer').hide(200); });

            $('#saveStatBtn').click(function() {
                var isUpdate = $('#stat_id').val() !== '';
                var url = isUpdate ? "{{ route('about.stat.update') }}" : "{{ route('about.stat.store') }}";
                var fd = new FormData(document.getElementById('statForm'));
                if (isUpdate) fd.append('id', $('#stat_id').val());

                $.ajax({
                    url: url, method: "POST", data: fd, contentType: false, processData: false,
                    success: function(res) {
                        showSuccess(res.message);
                        $('#statFormContainer').hide();
                        statTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]);
                        else showError('Error');
                    }
                });
            });

            $(document).on('click', '.editStatBtn', function() {
                $.get("{{ route('about.stat.edit', '__ID__') }}".replace('__ID__', $(this).data('id')), function(res) {
                    $('#stat_id').val(res.id);
                    $('#stat_icon').val(res.icon);
                    $('#stat_number').val(res.number);
                    $('#stat_label').val(res.label);
                    $('#statFormTitle').text('Edit Stat');
                    $('#statFormContainer').show(300);
                });
            });

            $(document).on('change', '.toggle-stat-status', function() {
                $.post("{{ route('about.stat.toggleStatus') }}", {
                    id: $(this).data('id'), status: $(this).prop('checked') ? 1 : 0
                }, function(res) { showSuccess(res.message); statTable.ajax.reload(null, false); })
                .fail(function() { showError('Failed'); });
            });

            // ========== HIGHLIGHTS ==========
            var highlightTable = $('#highlightTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('about.highlights.data') }}",
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'text', name: 'text' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newHighlightBtn').click(function() {
                $('#highlightForm')[0].reset();
                $('#highlight_id').val('');
                $('#highlightFormContainer').show(300);
            });
            $('#cancelHighlightBtn').click(function() { $('#highlightFormContainer').hide(200); });

            $('#saveHighlightBtn').click(function() {
                var isUpdate = $('#highlight_id').val() !== '';
                var url = isUpdate ? "{{ route('about.highlight.update') }}" : "{{ route('about.highlight.store') }}";
                var fd = new FormData(document.getElementById('highlightForm'));
                if (isUpdate) fd.append('id', $('#highlight_id').val());

                $.ajax({
                    url: url, method: "POST", data: fd, contentType: false, processData: false,
                    success: function(res) { showSuccess(res.message); $('#highlightFormContainer').hide(); highlightTable.ajax.reload(null, false); },
                    error: function(xhr) { if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]); else showError('Error'); }
                });
            });

            $(document).on('click', '.editHighlightBtn', function() {
                $.get("{{ route('about.highlight.edit', '__ID__') }}".replace('__ID__', $(this).data('id')), function(res) {
                    $('#highlight_id').val(res.id);
                    $('#highlight_text').val(res.text);
                    $('#highlightFormContainer').show(300);
                });
            });

            $(document).on('change', '.toggle-highlight-status', function() {
                $.post("{{ route('about.highlight.toggleStatus') }}", { id: $(this).data('id'), status: $(this).prop('checked') ? 1 : 0 }, function(res) { showSuccess(res.message); highlightTable.ajax.reload(null, false); }).fail(function() { showError('Failed'); });
            });

            // ========== MILESTONES ==========
            var milestoneTable = $('#milestoneTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('about.milestones.data') }}",
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'year', name: 'year' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newMilestoneBtn').click(function() {
                $('#milestoneForm')[0].reset();
                $('#milestone_id').val('');
                $('#milestoneFormTitle').text('Add Milestone');
                $('#milestoneFormContainer').show(300);
            });
            $('#cancelMilestoneBtn').click(function() { $('#milestoneFormContainer').hide(200); });

            $('#saveMilestoneBtn').click(function() {
                var isUpdate = $('#milestone_id').val() !== '';
                var url = isUpdate ? "{{ route('about.milestone.update') }}" : "{{ route('about.milestone.store') }}";
                var fd = new FormData(document.getElementById('milestoneForm'));
                if (isUpdate) fd.append('id', $('#milestone_id').val());

                $.ajax({
                    url: url, method: "POST", data: fd, contentType: false, processData: false,
                    success: function(res) { showSuccess(res.message); $('#milestoneFormContainer').hide(); milestoneTable.ajax.reload(null, false); },
                    error: function(xhr) { if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]); else showError('Error'); }
                });
            });

            $(document).on('click', '.editMilestoneBtn', function() {
                $.get("{{ route('about.milestone.edit', '__ID__') }}".replace('__ID__', $(this).data('id')), function(res) {
                    $('#milestone_id').val(res.id);
                    $('#milestone_year').val(res.year);
                    $('#milestone_title').val(res.title);
                    $('#milestone_description').val(res.description);
                    $('#milestoneFormTitle').text('Edit Milestone');
                    $('#milestoneFormContainer').show(300);
                });
            });

            $(document).on('change', '.toggle-milestone-status', function() {
                $.post("{{ route('about.milestone.toggleStatus') }}", { id: $(this).data('id'), status: $(this).prop('checked') ? 1 : 0 }, function(res) { showSuccess(res.message); milestoneTable.ajax.reload(null, false); }).fail(function() { showError('Failed'); });
            });

            // ========== VALUES ==========
            var valueTable = $('#valueTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('about.values.data') }}",
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'icon', name: 'icon' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newValueBtn').click(function() {
                $('#valueForm')[0].reset();
                $('#value_id').val('');
                $('#valueFormTitle').text('Add Value');
                $('#valueFormContainer').show(300);
            });
            $('#cancelValueBtn').click(function() { $('#valueFormContainer').hide(200); });

            $('#saveValueBtn').click(function() {
                var isUpdate = $('#value_id').val() !== '';
                var url = isUpdate ? "{{ route('about.value.update') }}" : "{{ route('about.value.store') }}";
                var fd = new FormData(document.getElementById('valueForm'));
                if (isUpdate) fd.append('id', $('#value_id').val());

                $.ajax({
                    url: url, method: "POST", data: fd, contentType: false, processData: false,
                    success: function(res) { showSuccess(res.message); $('#valueFormContainer').hide(); valueTable.ajax.reload(null, false); },
                    error: function(xhr) { if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]); else showError('Error'); }
                });
            });

            $(document).on('click', '.editValueBtn', function() {
                $.get("{{ route('about.value.edit', '__ID__') }}".replace('__ID__', $(this).data('id')), function(res) {
                    $('#value_id').val(res.id);
                    $('#value_icon').val(res.icon);
                    $('#value_title').val(res.title);
                    $('#value_description').val(res.description);
                    $('#valueFormTitle').text('Edit Value');
                    $('#valueFormContainer').show(300);
                });
            });

            $(document).on('change', '.toggle-value-status', function() {
                $.post("{{ route('about.value.toggleStatus') }}", { id: $(this).data('id'), status: $(this).prop('checked') ? 1 : 0 }, function(res) { showSuccess(res.message); valueTable.ajax.reload(null, false); }).fail(function() { showError('Failed'); });
            });

            // ========== CERTS ==========
            var certTable = $('#certTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('about.certs.data') }}",
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'license_number', name: 'license_number' },
                    { data: 'status_text', name: 'status_text' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#newCertBtn').click(function() {
                $('#certForm')[0].reset();
                $('#cert_id').val('');
                $('#certFormTitle').text('Add Certification');
                $('#certFormContainer').show(300);
            });
            $('#cancelCertBtn').click(function() { $('#certFormContainer').hide(200); });

            $('#saveCertBtn').click(function() {
                var isUpdate = $('#cert_id').val() !== '';
                var url = isUpdate ? "{{ route('about.cert.update') }}" : "{{ route('about.cert.store') }}";
                var fd = new FormData(document.getElementById('certForm'));
                if (isUpdate) fd.append('id', $('#cert_id').val());

                $.ajax({
                    url: url, method: "POST", data: fd, contentType: false, processData: false,
                    success: function(res) { showSuccess(res.message); $('#certFormContainer').hide(); certTable.ajax.reload(null, false); },
                    error: function(xhr) { if (xhr.status === 422) showError(Object.values(xhr.responseJSON.errors)[0][0]); else showError('Error'); }
                });
            });

            $(document).on('click', '.editCertBtn', function() {
                $.get("{{ route('about.cert.edit', '__ID__') }}".replace('__ID__', $(this).data('id')), function(res) {
                    $('#cert_id').val(res.id);
                    $('#cert_icon').val(res.icon);
                    $('#cert_title').val(res.title);
                    $('#cert_license_label').val(res.license_label);
                    $('#cert_license_number').val(res.license_number);
                    $('#cert_license_class').val(res.license_class);
                    $('#cert_description').val(res.description);
                    $('#cert_status_text').val(res.status_text);
                    $('#certFormTitle').text('Edit Certification');
                    $('#certFormContainer').show(300);
                });
            });

            $(document).on('change', '.toggle-cert-status', function() {
                $.post("{{ route('about.cert.toggleStatus') }}", { id: $(this).data('id'), status: $(this).prop('checked') ? 1 : 0 }, function(res) { showSuccess(res.message); certTable.ajax.reload(null, false); }).fail(function() { showError('Failed'); });
            });
        });
    </script>
@endsection