@extends('admin.pages.master')
@section('title', 'Violation Leads')

@section('content')
    <div class="container-fluid" id="contentContainer">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Violation Checker Leads</h4>
                <div class="d-flex gap-2">
                    <span class="badge bg-danger fs-6">High Risk = Call Immediately</span>
                    <span class="badge bg-warning text-dark fs-6">At Risk = Follow Up</span>
                </div>
            </div>
            <div class="card-body">
                <table id="leadTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Property Address</th>
                            <th>Risk Score</th>
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
                    <h5 class="modal-title">Lead Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted text-uppercase fw-semibold fs-11">Customer Info</h6>
                            <p class="mb-1"><strong>Name:</strong> <span id="v_name"></span></p>
                            <p class="mb-1"><strong>Phone:</strong> <span id="v_phone"></span></p>
                            <p class="mb-1"><strong>Email:</strong> <span id="v_email"></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted text-uppercase fw-semibold fs-11">Risk Analysis</h6>
                            <p class="mb-1"><strong>Overall Status:</strong> <span id="v_status_badge"></span></p>
                            <p class="mb-1"><strong>Risk Score:</strong> <span id="v_score" class="fw-bold"></span></p>
                            <p class="mb-1"><strong>Submitted:</strong> <span id="v_date"></span></p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted text-uppercase fw-semibold fs-11">Property Address</h6>
                        <p class="border rounded p-2 bg-light" id="v_address"></p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-semibold fs-11">API Findings</h6>
                            <ul class="list-unstyled mb-0 border rounded p-2 bg-light" id="v_details" style="min-height: 40px;"></ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-semibold fs-11">Breakdown</h6>
                            <p class="border rounded p-2 bg-light mb-0"><span id="v_dot"></span></p>
                            <p class="border rounded p-2 bg-light mt-2 mb-0"><span id="v_dob"></span></p>
                        </div>
                    </div>

                    <div class="mb-0">
                        <a class="btn btn-soft-secondary btn-sm w-100" data-bs-toggle="collapse" href="#rawApiCollapse">
                            <i class="ri-code-s-slash-line me-1"></i> View Raw API Data
                        </a>
                        <div class="collapse mt-2" id="rawApiCollapse">
                            <pre class="bg-dark text-light p-3 rounded mb-0" style="font-size: 0.75rem; max-height: 200px; overflow-y: auto;" id="v_raw"></pre>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-success" id="v_call_btn">
                        <i class="ri-phone-fill me-1"></i> Call Customer
                    </a>
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

            var table = $('#leadTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('leads.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'date', name: 'date' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'address', name: 'address' },
                    { data: 'risk_badge', name: 'risk_badge', orderable: false, searchable: false },
                    { data: 'contacted_status', name: 'contacted_status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                // Custom DOM ordering to push 'danger' to the top automatically
                order: [[5, 'asc']]
            });

            // View Details
            $(document).on('click', '.viewBtn', function() {
                var id = $(this).data('id');
                $.get("{{ url('/admin/leads') }}/" + id, {}, function(res) {
                    $('#v_name').text(res.first_name);
                    $('#v_phone').text(res.phone);
                    $('#v_email').text(res.email || 'N/A');
                    $('#v_address').text(res.address);
                    $('#v_date').text(res.formatted_date);
                    $('#v_score').text(res.risk_score + '/100');
                    
                    // Set Status Badge
                    if(res.status === 'danger') {
                        $('#v_status_badge').html('<span class="badge bg-danger">High Risk</span>');
                        $('#v_score').addClass('text-danger').removeClass('text-warning text-success');
                    } else if(res.status === 'warning') {
                        $('#v_status_badge').html('<span class="badge bg-warning text-dark">At Risk</span>');
                        $('#v_score').addClass('text-warning').removeClass('text-danger text-success');
                    } else {
                        $('#v_status_badge').html('<span class="badge bg-success">All Clear</span>');
                        $('#v_score').addClass('text-success').removeClass('text-danger text-warning');
                    }

                    // Set Breakdown Counts
                    $('#v_dot').html('<strong>DOT Tickets:</strong> ' + res.dot_tickets_count);
                    $('#v_dob').html('<strong>DOB Complaints:</strong> ' + res.dob_complaints_count);

                    // Set Findings List
                    let detailsHtml = '<li class="text-muted">No specific details found.</li>';
                    if (res.risk_details && res.risk_details.length > 0) {
                        detailsHtml = '';
                        res.risk_details.forEach(function(detail) {
                            detailsHtml += '<li class="mb-1"><i class="ri-arrow-right-s-line text-primary"></i> ' + detail + '</li>';
                        });
                    }
                    $('#v_details').html(detailsHtml);

                    // Set Raw API Data
                    $('#v_raw').text(res.api_raw_pretty || 'No raw data saved.');

                    // Update call button dynamically
                    if(res.phone) {
                        $('#v_call_btn').attr('href', 'tel:' + res.phone).show();
                    } else {
                        $('#v_call_btn').hide();
                    }

                    $('#viewModal').modal('show');
                });
            });

            // Toggle Contacted Status
            $(document).on('change', '.toggle-contacted', function() {
                let id = $(this).data('id');
                let is_contacted = $(this).prop('checked') ? 1 : 0;
                
                $.post("{{ route('leads.toggleContacted') }}", {
                    id: id,
                    is_contacted: is_contacted
                }, function(res) {
                    showSuccess(res.message);
                    table.ajax.reload(null, false);
                }).fail(() => showError('Failed to update status'));
            });
        });
    </script>
@endsection