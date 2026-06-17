@extends('admin.pages.master')
@section('title', 'Admin')
@section('content')

    <div class="container-fluid" id="newBtnSection">
        <div class="row mb-3">
            <div class="col-auto">
                <button class="btn btn-primary" id="newBtn">Add New Admin</button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="addThisFormContainer" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 id="cardTitle">Add New Admin</h4>
                    </div>
                    <div class="card-body">
                        <form id="createThisForm">
                            @csrf
                            <input type="hidden" id="codeid" name="id">
                            <div class="mb-3">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control">
                            </div>
                            <div class="mb-3" id="passwordField">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3" id="confirmPasswordField">
                                <label>Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control">
                            </div>
                            <div class="mb-3 text-end">
                                <button type="button" id="addBtn" class="btn btn-primary" value="Create">Create</button>
                                <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Admins</h4>
            </div>
            <div class="card-body">
                <table id="adminTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
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
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#adminTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
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
                    },
                ]
            });

            // Show Create Form
            $('#newBtn').click(function() {
                $('#createThisForm')[0].reset();
                $('#codeid').val('');
                $('#cardTitle').text('Add New Admin');
                $('#addBtn').val('Create').text('Create');
                // Show password fields for create
                $('#passwordField, #confirmPasswordField').show();
                $('#password, #password_confirmation').prop('required', true);
                $('#addThisFormContainer').show(300);
                $('#newBtn').hide();
            });

            // Hide Form
            $('#FormCloseBtn').click(function() {
                $('#addThisFormContainer').hide(200);
                $('#newBtn').show();
                $('#createThisForm')[0].reset();
            });

            // Create/Update Submit
            $('#addBtn').click(function() {
                var btn = this;
                var isUpdate = $(btn).val() !== 'Create';
                var url = isUpdate ? "{{ route('admin.update') }}" : "{{ route('admin.store') }}";
                var fd = new FormData(document.getElementById('createThisForm'));
                
                if (isUpdate) {
                    fd.append('id', $('#codeid').val());
                }

                $.ajax({
                    url: url,
                    method: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        showSuccess(res.message);
                        $('#addThisFormContainer').hide();
                        $('#newBtn').show();
                        table.ajax.reload(null, false);
                        $('#createThisForm')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            let first = Object.values(xhr.responseJSON.errors)[0][0];
                            showError(first);
                        } else {
                            showError(xhr.responseJSON?.message ?? 'Error');
                        }
                    }
                });
            });

            // Edit
            $(document).on('click', '.EditBtn', function() {
                var id = $(this).data('id');
                $.get("{{ route('admin.edit', '__ID__') }}".replace('__ID__', id), {}, function(res) {
                    $('#codeid').val(res.id);
                    $('#name').val(res.name);
                    $('#email').val(res.email);
                    $('#phone').val(res.phone);
                    $('#password').val('');
                    $('#password_confirmation').val('');
                    // Hide password fields for update (optional)
                    $('#passwordField, #confirmPasswordField').hide();
                    $('#password, #password_confirmation').prop('required', false);
                    
                    $('#cardTitle').text('Update Admin');
                    $('#addBtn').val('Update').text('Update');
                    $('#addThisFormContainer').show();
                    $('#newBtn').hide();
                });
            });

            // Toggle Status
            $(document).on('change', '.toggle-status', function() {
                var id = $(this).data('id');
                var status = $(this).prop('checked') ? 1 : 0;
                $.post("{{ route('admin.toggleStatus') }}", {
                    id: id,
                    status: status
                }, function(res) {
                    showSuccess(res.message);
                    table.ajax.reload(null, false);
                }).fail(function() {
                    showError('Failed to update status');
                });
            });
        });
    </script>
@endsection