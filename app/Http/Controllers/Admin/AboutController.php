<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPage;
use App\Models\AboutStat;
use App\Models\AboutHighlight;
use App\Models\AboutMilestone;
use App\Models\AboutValue;
use App\Models\AboutCert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $aboutPage = AboutPage::firstOrCreate([]);
        return view('admin.about.index', compact('aboutPage'));
    }

    // ========== CONTENT (Hero & Story) ==========
    public function updateContent(Request $request)
    {
        // Use 'sometimes' so it only validates fields sent from the active tab
        $request->validate([
            'hero_tag'          => 'sometimes|required|string|max:255',
            'hero_title'        => 'sometimes|required|string|max:500',
            'hero_description'  => 'sometimes|required|string',
            'story_tag'         => 'sometimes|required|string|max:255',
            'story_title'       => 'sometimes|required|string|max:500',
            'story_content'     => 'sometimes|required|string',
            'badge_rating'      => 'sometimes|required|string|max:50',
            'badge_label'       => 'sometimes|required|string|max:255',
        ]);

        $aboutPage = AboutPage::firstOrCreate([]);
        
        // $request->only() safely ignores fields that weren't sent
        $aboutPage->update($request->only([
            'hero_tag',
            'hero_title',
            'hero_description',
            'story_tag',
            'story_title',
            'story_content',
            'badge_rating',
            'badge_label',
        ]));

        return response()->json(['message' => 'Content updated successfully.']);
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $aboutPage = AboutPage::firstOrCreate([]);

        if ($aboutPage->story_image && Storage::disk('public')->exists($aboutPage->story_image)) {
            Storage::disk('public')->delete($aboutPage->story_image);
        }

        $path = $request->file('image')->store('about', 'public');
        $aboutPage->update(['story_image' => $path]);

        return response()->json([
            'message' => 'Image uploaded successfully.',
            'image'   => Storage::url($path),
        ]);
    }

    // ========== STATS ==========
    public function getStatsData()
    {
        $stats = AboutStat::orderBy('sort_order')->orderByDesc('id');
        return DataTables::of($stats)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<div class="form-check form-switch">
                    <input class="form-check-input toggle-stat-status" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
                </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="dropdown">
                        <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item editStatBtn" data-id="' . $row->id . '"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                            <li class="dropdown-divider"></li>
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('about.stat.delete', $row->id) . '" data-method="DELETE" data-table="#statTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function storeStat(Request $request)
    {
        $request->validate([
            'icon'  => 'required|string|max:100',
            'number' => 'required|string|max:50',
            'label' => 'required|string|max:255',
        ]);

        AboutStat::create($request->only(['icon', 'number', 'label']));
        return response()->json(['message' => 'Stat added successfully.']);
    }

    public function editStat($id)
    {
        $stat = AboutStat::findOrFail($id);
        return response()->json($stat);
    }

    public function updateStat(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:about_stats,id',
            'icon'   => 'required|string|max:100',
            'number' => 'required|string|max:50',
            'label'  => 'required|string|max:255',
        ]);

        $stat = AboutStat::findOrFail($request->id);
        $stat->update($request->only(['icon', 'number', 'label']));

        return response()->json(['message' => 'Stat updated successfully.']);
    }

    public function destroyStat($id)
    {
        AboutStat::findOrFail($id)->delete();
        return response()->json(['message' => 'Stat deleted successfully.']);
    }

    public function toggleStatStatus(Request $request)
    {
        $stat = AboutStat::findOrFail($request->id);
        $stat->status = $request->status;
        $stat->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    // ========== HIGHLIGHTS ==========
    public function getHighlightsData()
    {
        $highlights = AboutHighlight::orderBy('sort_order')->orderByDesc('id');
        return DataTables::of($highlights)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<div class="form-check form-switch">
                    <input class="form-check-input toggle-highlight-status" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
                </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="dropdown">
                        <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item editHighlightBtn" data-id="' . $row->id . '"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                            <li class="dropdown-divider"></li>
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('about.highlight.delete', $row->id) . '" data-method="DELETE" data-table="#highlightTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function storeHighlight(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
        ]);

        AboutHighlight::create(['text' => $request->text]);
        return response()->json(['message' => 'Highlight added successfully.']);
    }

    public function editHighlight($id)
    {
        return response()->json(AboutHighlight::findOrFail($id));
    }

    public function updateHighlight(Request $request)
    {
        $request->validate([
            'id'   => 'required|exists:about_highlights,id',
            'text' => 'required|string|max:500',
        ]);

        AboutHighlight::findOrFail($request->id)->update(['text' => $request->text]);
        return response()->json(['message' => 'Highlight updated successfully.']);
    }

    public function destroyHighlight($id)
    {
        AboutHighlight::findOrFail($id)->delete();
        return response()->json(['message' => 'Highlight deleted successfully.']);
    }

    public function toggleHighlightStatus(Request $request)
    {
        $item = AboutHighlight::findOrFail($request->id);
        $item->status = $request->status;
        $item->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    // ========== MILESTONES ==========
    public function getMilestonesData()
    {
        $milestones = AboutMilestone::orderBy('sort_order')->orderBy('year');
        return DataTables::of($milestones)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<div class="form-check form-switch">
                    <input class="form-check-input toggle-milestone-status" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
                </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="dropdown">
                        <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item editMilestoneBtn" data-id="' . $row->id . '"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                            <li class="dropdown-divider"></li>
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('about.milestone.delete', $row->id) . '" data-method="DELETE" data-table="#milestoneTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function storeMilestone(Request $request)
    {
        $request->validate([
            'year'        => 'required|string|max:20',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        AboutMilestone::create($request->only(['year', 'title', 'description']));
        return response()->json(['message' => 'Milestone added successfully.']);
    }

    public function editMilestone($id)
    {
        return response()->json(AboutMilestone::findOrFail($id));
    }

    public function updateMilestone(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:about_milestones,id',
            'year'        => 'required|string|max:20',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        AboutMilestone::findOrFail($request->id)->update($request->only(['year', 'title', 'description']));
        return response()->json(['message' => 'Milestone updated successfully.']);
    }

    public function destroyMilestone($id)
    {
        AboutMilestone::findOrFail($id)->delete();
        return response()->json(['message' => 'Milestone deleted successfully.']);
    }

    public function toggleMilestoneStatus(Request $request)
    {
        $item = AboutMilestone::findOrFail($request->id);
        $item->status = $request->status;
        $item->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    // ========== VALUES ==========
    public function getValuesData()
    {
        $values = AboutValue::orderBy('sort_order')->orderByDesc('id');
        return DataTables::of($values)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<div class="form-check form-switch">
                    <input class="form-check-input toggle-value-status" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
                </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="dropdown">
                        <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item editValueBtn" data-id="' . $row->id . '"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                            <li class="dropdown-divider"></li>
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('about.value.delete', $row->id) . '" data-method="DELETE" data-table="#valueTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function storeValue(Request $request)
    {
        $request->validate([
            'icon'        => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        AboutValue::create($request->only(['icon', 'title', 'description']));
        return response()->json(['message' => 'Value added successfully.']);
    }

    public function editValue($id)
    {
        return response()->json(AboutValue::findOrFail($id));
    }

    public function updateValue(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:about_values,id',
            'icon'        => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        AboutValue::findOrFail($request->id)->update($request->only(['icon', 'title', 'description']));
        return response()->json(['message' => 'Value updated successfully.']);
    }

    public function destroyValue($id)
    {
        AboutValue::findOrFail($id)->delete();
        return response()->json(['message' => 'Value deleted successfully.']);
    }

    public function toggleValueStatus(Request $request)
    {
        $item = AboutValue::findOrFail($request->id);
        $item->status = $request->status;
        $item->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    // ========== CERTS ==========
    public function getCertsData()
    {
        $certs = AboutCert::orderBy('sort_order')->orderByDesc('id');
        return DataTables::of($certs)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<div class="form-check form-switch">
                    <input class="form-check-input toggle-cert-status" data-id="' . $row->id . '" type="checkbox" ' . $checked . '>
                </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="dropdown">
                        <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item editCertBtn" data-id="' . $row->id . '"><i class="ri-pencil-fill me-2"></i>Edit</button></li>
                            <li class="dropdown-divider"></li>
                            <li><button class="dropdown-item deleteBtn" data-delete-url="' . route('about.cert.delete', $row->id) . '" data-method="DELETE" data-table="#certTable"><i class="ri-delete-bin-fill me-2"></i>Delete</button></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function storeCert(Request $request)
    {
        $request->validate([
            'icon'          => 'required|string|max:100',
            'title'         => 'required|string|max:255',
            'license_label' => 'required|string|max:100',
            'license_number' => 'required|string|max:255',
            'description'   => 'required|string',
            'status_text'   => 'required|string|max:255',
        ]);

        AboutCert::create($request->only([
            'icon', 'title', 'license_label', 'license_number',
            'license_class', 'description', 'status_text'
        ]));

        return response()->json(['message' => 'Certification added successfully.']);
    }

    public function editCert($id)
    {
        return response()->json(AboutCert::findOrFail($id));
    }

    public function updateCert(Request $request)
    {
        $request->validate([
            'id'            => 'required|exists:about_certs,id',
            'icon'          => 'required|string|max:100',
            'title'         => 'required|string|max:255',
            'license_label' => 'required|string|max:100',
            'license_number' => 'required|string|max:255',
            'description'   => 'required|string',
            'status_text'   => 'required|string|max:255',
        ]);

        AboutCert::findOrFail($request->id)->update($request->only([
            'icon', 'title', 'license_label', 'license_number',
            'license_class', 'description', 'status_text'
        ]));

        return response()->json(['message' => 'Certification updated successfully.']);
    }

    public function destroyCert($id)
    {
        AboutCert::findOrFail($id)->delete();
        return response()->json(['message' => 'Certification deleted successfully.']);
    }

    public function toggleCertStatus(Request $request)
    {
        $item = AboutCert::findOrFail($request->id);
        $item->status = $request->status;
        $item->save();
        return response()->json(['message' => 'Status updated successfully.']);
    }
}