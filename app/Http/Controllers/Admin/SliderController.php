<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class SliderController extends Controller
{
    public function getSlider(Request $request)
    {
        if ($request->ajax()) {
            $sliders = Slider::query()->select(['id','title','subtitle','image','serial','status'])->orderBy('serial', 'asc');
            return DataTables::of($sliders)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    return $row->image 
                        ? '<img src="'.asset('uploads/slider/'.$row->image).'" class="img-thumbnail" style="width:80px;height:45px;object-fit:cover;">'
                        : '<span class="text-muted">No Image</span>';
                })
                ->addColumn('title_info', function($row){
                    $html = '<strong>'.$row->title.'</strong>';
                    if($row->subtitle){
                        $html .= '<br><small class="text-muted">'.Str::limit($row->subtitle, 50).'</small>';
                    }
                    return $html;
                })
                ->addColumn('status', function($row){
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch" dir="ltr">
                                <input type="checkbox" class="form-check-input toggle-status" 
                                       id="customSwitchStatus'.$row->id.'" data-id="'.$row->id.'" '.$checked.'>
                                <label class="form-check-label" for="customSwitchStatus'.$row->id.'"></label>
                            </div>';
                })
                ->addColumn('serial', function($row){
                    return '<span class="badge bg-secondary">'.$row->serial.'</span>';
                })
                ->addColumn('action', function($row){
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item" id="EditBtn" rid="'.$row->id.'">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn" 
                                        data-delete-url="'.route('slider.delete',$row->id).'" 
                                        data-method="DELETE" 
                                        data-table="#sliderTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->rawColumns(['image','title_info','status','serial','action'])
                ->make(true);
        }

        $sliders = Slider::query()->orderBy('serial', 'asc')->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function sliderStore(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:sliders,title',
            'subtitle' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*.icon' => 'nullable|string',
            'highlights.*.text' => 'nullable|string',
            'stats' => 'nullable|array',
            'stats.*.number' => 'nullable|string',
            'stats.*.label' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $data = new Slider();
        $data->title = $request->title;
        $data->subtitle = $request->subtitle;
        $data->link = $request->link;
        $data->created_by = Auth::id();

        // Process highlights - filter out empty items
        $highlights = [];
        if ($request->highlights) {
            foreach ($request->highlights as $item) {
                if (!empty($item['text'])) {
                    $highlights[] = [
                        'icon' => $item['icon'] ?? 'bi bi-check-circle-fill',
                        'text' => $item['text']
                    ];
                }
            }
        }
        $data->highlights = !empty($highlights) ? $highlights : null;

        // Process stats - filter out empty items
        $stats = [];
        if ($request->stats) {
            foreach ($request->stats as $item) {
                if (!empty($item['number']) && !empty($item['label'])) {
                    $stats[] = [
                        'number' => $item['number'],
                        'label' => $item['label']
                    ];
                }
            }
        }
        $data->stats = !empty($stats) ? $stats : null;

        $lastSerial = Slider::max('serial');
        $data->serial = $lastSerial ? $lastSerial + 1 : 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = mt_rand(10000000,99999999).'.webp';
            $path = public_path('uploads/slider/');
            if(!file_exists($path)) mkdir($path,0755,true);

            Image::make($file)
                ->resize(1920, null, function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 70)
                ->save($path.$name);

            $data->image = $name;
        }

        $data->save();
        Cache::forget('active_sliders');
        return response()->json(['message' => 'Slider created successfully!'], 200);
    }

    public function sliderEdit($id)
    {
        $slider = Slider::findOrFail($id);
        return response()->json($slider);
    }

    public function sliderUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:sliders,title,'.$request->codeid,
            'subtitle' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*.icon' => 'nullable|string',
            'highlights.*.text' => 'nullable|string',
            'stats' => 'nullable|array',
            'stats.*.number' => 'nullable|string',
            'stats.*.label' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $slider = Slider::findOrFail($request->codeid);
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->link = $request->link;
        $slider->updated_by = Auth::id();

        // Process highlights
        $highlights = [];
        if ($request->highlights) {
            foreach ($request->highlights as $item) {
                if (!empty($item['text'])) {
                    $highlights[] = [
                        'icon' => $item['icon'] ?? 'bi bi-check-circle-fill',
                        'text' => $item['text']
                    ];
                }
            }
        }
        $slider->highlights = !empty($highlights) ? $highlights : null;

        // Process stats
        $stats = [];
        if ($request->stats) {
            foreach ($request->stats as $item) {
                if (!empty($item['number']) && !empty($item['label'])) {
                    $stats[] = [
                        'number' => $item['number'],
                        'label' => $item['label']
                    ];
                }
            }
        }
        $slider->stats = !empty($stats) ? $stats : null;

        if ($request->hasFile('image')) {
            if ($slider->image && file_exists(public_path('uploads/slider/'.$slider->image))) {
                @unlink(public_path('uploads/slider/'.$slider->image));
            }
            $file = $request->file('image');
            $name = mt_rand(10000000,99999999).'.webp';
            $path = public_path('uploads/slider/');
            if(!file_exists($path)) mkdir($path,0755,true);

            Image::make($file)
                ->resize(1920, null, function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 70)
                ->save($path.$name);

            $slider->image = $name;
        }

        $slider->save();
        Cache::forget('active_sliders');
        return response()->json(['message' => 'Slider updated successfully!'], 200);
    }

    public function sliderDelete($id)
    {
        $slider = Slider::findOrFail($id);
        if ($slider->image && file_exists(public_path('uploads/slider/'.$slider->image))) {
            @unlink(public_path('uploads/slider/'.$slider->image));
        }
        $slider->delete();
        Cache::forget('active_sliders');
        return response()->json(['message' => 'Slider deleted successfully.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $slider = Slider::findOrFail($request->slider_id);
        $slider->status = $request->status;
        $slider->save();
        Cache::forget('active_sliders');
        return response()->json(['message' => 'Slider status updated successfully.'], 200);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Slider::query()->where('id', $id)->update(['serial' => $index + 1]);
        }
        Cache::forget('active_sliders');
        return response()->json(['success' => true, 'message' => 'Slider order updated successfully!']);
    }
}