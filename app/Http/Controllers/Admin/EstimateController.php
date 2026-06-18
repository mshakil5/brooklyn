<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estimate;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class EstimateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $estimates = Estimate::select(['id','first_name','last_name','phone','borough','service','is_read','created_at'])
                ->orderBy('is_read', 'asc') // Unread estimates show first
                ->orderByDesc('id');

            return DataTables::of($estimates)
                ->addIndexColumn()
                ->addColumn('full_name', fn($row) => $row->first_name . ' ' . $row->last_name)
                ->addColumn('date', fn($row) => Carbon::parse($row->created_at)->format('d-m-Y'))
                ->addColumn('status', function ($row) {
                    $checked = $row->is_read ? 'checked' : '';
                    $label = $row->is_read ? 'Read' : 'New';
                    $color = $row->is_read ? 'text-muted' : 'text-primary fw-bold';
                    
                    return '<div class="d-flex align-items-center gap-2">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input toggle-read" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
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
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('estimates.delete', $row->id) . '" data-method="DELETE" data-table="#estimateTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                          </ul>
                        </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.estimates.index');
    }

    public function show($id)
    {
        $estimate = Estimate::find($id);
        if (!$estimate) return response()->json(['message' => 'Not found'], 404);

        $estimate->formatted_date = $estimate->created_at->format('d-m-Y | H:i:s');
        return response()->json($estimate);
    }

    public function destroy($id)
    {
        $estimate = Estimate::find($id);
        if (!$estimate) return response()->json(['message' => 'Not found'], 404);

        $estimate->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }

    public function toggleRead(Request $request)
    {
        $estimate = Estimate::find($request->id);
        if (!$estimate) return response()->json(['message' => 'Not found'], 404);

        $estimate->is_read = $request->is_read;
        $estimate->save();

        return response()->json(['message' => 'Read status updated successfully.']);
    }
}