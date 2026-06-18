@extends('admin.pages.master')
@section('title', 'Estimate Requests')

@section('content')
    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Estimate Requests</h4>
            </div>
            <div class="card-body">
                <table id="estimateTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Borough</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Estimate Request Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted text-uppercase fw-semibold fs-11">Personal Info</h6>
                            <p class="mb-1"><strong>Full Name:</strong> <span id="v_name"></span></p>
                            <p class="mb-1"><strong>Phone:</strong> <span id="v_phone"></span></p>
                            <p class="mb-1"><strong>Email:</strong> <span id="v_email"></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted text-uppercase fw-semibold fs-11">Project Info</h6>
                            <p class="mb-1"><strong>Service:</strong> <span id="v_service" class="badge bg-primary"></span></p>
                            <p class="mb-1"><strong>Borough:</strong> <span id="v_borough" class="badge bg-secondary"></span></p>
                            <p class="mb-1"><strong>Submitted:</strong> <span id="v_date"></span></p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted text-uppercase fw-semibold fs-11">Property Address</h6>
                        <p class="border rounded p-2 bg-light" id="v_address"></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted text-uppercase fw-semibold fs-11">Message</h6>
                        <div class="border rounded p-3 bg-light" style="min-height: 60px;" id="v_message"></div>
                    </div>

                    <div class="text-end">
                        <small class="text-muted">IP Address: <span id="v_ip"></span></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @if(!empty($estimate->phone))
                    <a href="tel:{{ $estimate->phone ?? '' }}" class="btn btn-success" id="v_call_btn">
                        <i class="ri-phone-fill me-1"></i> Call Customer
                    </a>
                    @endif
                </div>
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

            var table = $('#estimateTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('estimates.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'date', name: 'date' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'borough', name: 'borough' },
                    { data: 'service', name: 'service' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // View Details
            $(document).on('click', '.viewBtn', function() {
                var id = $(this).data('id');
                $.get("{{ url('/admin/estimates') }}/" + id, {}, function(res) {
                    $('#v_name').text(res.first_name + ' ' + res.last_name);
                    $('#v_phone').text(res.phone);
                    $('#v_email').text(res.email || 'N/A');
                    $('#v_service').text(res.service);
                    $('#v_borough').text(res.borough);
                    $('#v_address').text(res.address);
                    $('#v_date').text(res.formatted_date);
                    $('#v_message').text(res.message || 'No message provided.');
                    $('#v_ip').text(res.ip_address || 'N/A');
                    
                    // Update call button dynamically
                    if(res.phone) {
                        $('#v_call_btn').attr('href', 'tel:' + res.phone).show();
                    } else {
                        $('#v_call_btn').hide();
                    }

                    $('#viewModal').modal('show');
                });
            });

            // Toggle Read/Unread Status
            $(document).on('change', '.toggle-read', function() {
                let id = $(this).data('id');
                let is_read = $(this).prop('checked') ? 1 : 0;
                
                $.post("{{ route('estimates.toggleRead') }}", {
                    id: id,
                    is_read: is_read
                }, function(res) {
                    showSuccess(res.message);
                    table.ajax.reload(null, false);
                }).fail(() => showError('Failed to update status'));
            });
        });
    </script>
@endsection