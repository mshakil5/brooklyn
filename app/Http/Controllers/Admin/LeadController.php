<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $leads = Lead::select([
                    'id', 
                    'address', 
                    'first_name', 
                    'phone', 
                    'status', 
                    'risk_score', 
                    'is_contacted', 
                    'created_at'
                ])
                ->orderBy('is_contacted', 'asc') // Uncontacted leads show first
                ->orderByDesc('id');

            return DataTables::of($leads)
                ->addIndexColumn()
                ->addColumn('date', fn($row) => Carbon::parse($row->created_at)->format('d-m-Y'))
                ->addColumn('risk_badge', function ($row) {
                    if ($row->status === 'danger') {
                        return '<span class="badge bg-danger">High Risk (' . $row->risk_score . ')</span>';
                    } elseif ($row->status === 'warning') {
                        return '<span class="badge bg-warning text-dark">At Risk (' . $row->risk_score . ')</span>';
                    }
                    return '<span class="badge bg-success">All Clear (' . $row->risk_score . ')</span>';
                })
                ->addColumn('contacted_status', function ($row) {
                    $checked = $row->is_contacted ? 'checked' : '';
                    $label = $row->is_contacted ? 'Contacted' : 'Pending';
                    $color = $row->is_contacted ? 'text-muted' : 'text-warning fw-bold';
                    
                    return '<div class="d-flex align-items-center gap-2">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input toggle-contacted" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
                                </div>
                                <span class="' . $color . '">' . $label . '</span>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                          <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item viewBtn" data-id="' . $row->id . '"><i class="ri-eye-fill me-2"></i>View Details</button></li>
                            <li class="dropdown-divider"></li>
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('leads.delete', $row->id) . '" data-method="DELETE" data-table="#leadTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                          </ul>
                        </div>';
                })
                ->rawColumns(['risk_badge', 'contacted_status', 'action'])
                ->make(true);
        }

        return view('admin.leads.index');
    }

    public function show($id)
    {
        $lead = Lead::find($id);
        if (!$lead) return response()->json(['message' => 'Not found'], 404);

        $lead->formatted_date = $lead->created_at->format('d-m-Y | H:i:s');
        
        // Format the raw API data safely for the modal
        $lead->api_raw_pretty = $lead->api_raw_data ? json_encode($lead->api_raw_data, JSON_PRETTY_PRINT) : null;

        return response()->json($lead);
    }

    public function destroy($id)
    {
        $lead = Lead::find($id);
        if (!$lead) return response()->json(['message' => 'Not found'], 404);

        $lead->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }

    public function toggleContacted(Request $request)
    {
        $lead = Lead::find($request->id);
        if (!$lead) return response()->json(['message' => 'Not found'], 404);

        $lead->is_contacted = $request->is_contacted;
        $lead->save();

        return response()->json(['message' => 'Contacted status updated successfully.']);
    }
}