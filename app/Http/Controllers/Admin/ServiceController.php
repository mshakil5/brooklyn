<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function getService(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::query()->select(['id','title','subtitle','slug','image','icon','serial','status'])->orderBy('serial', 'asc');
            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    return $row->image 
                        ? '<img src="'.asset('uploads/service/'.$row->image).'" class="img-thumbnail" style="width:80px;height:45px;object-fit:cover;">'
                        : '<span class="text-muted">No Image</span>';
                })
                ->addColumn('title_info', function($row){
                    $html = '<div class="d-flex align-items-center gap-2">';
                    $html .= '<i class="'.$row->icon.' text-primary fs-5"></i>';
                    $html .= '<div>';
                    $html .= '<strong>'.$row->title.'</strong>';
                    if($row->subtitle){
                        $html .= '<br><small class="text-muted">'.Str::limit($row->subtitle, 50).'</small>';
                    }
                    $html .= '<br><small class="text-muted" style="font-size:0.7rem;">Slug: '.$row->slug.'</small>';
                    $html .= '</div></div>';
                    return $html;
                })
                ->addColumn('status', function($row){
                    $checked = $row->status ? 'checked' : '';
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
                                        data-delete-url="'.route('service.delete',$row->id).'" 
                                        data-method="DELETE" 
                                        data-table="#serviceTable">
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

        $services = Service::query()->orderBy('serial', 'asc')->get();
        return view('admin.service.index', compact('services'));
    }

    public function serviceStore(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:services,title',
            'subtitle' => 'nullable|string',
            'slug' => 'nullable|unique:services,slug',
            'icon' => 'nullable|string',
            'badge' => 'nullable|string',
            'badge_type' => 'nullable|in:default,urgent,popular,premium',
            'badge_class' => 'nullable|string',
            'heading' => 'required|string',
            'description' => 'required|string',
            'description_two' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*.text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'urgent_tag' => 'nullable|string|max:20',
            'btn_text' => 'nullable|string',
            'btn_link' => 'nullable|string',
        ]);

        $data = new Service();
        $data->title = $request->title;
        $data->subtitle = $request->subtitle;
        $data->slug = $request->slug ? Str::slug($request->slug) : null; // Model booted() handles if null
        $data->icon = $request->icon ?? 'bi bi-wrench';
        $data->badge = $request->badge;
        $data->badge_type = $request->badge_type ?? 'default';
        $data->badge_class = $request->badge_class ?? '';
        $data->heading = $request->heading;
        $data->description = $request->description;
        $data->description_two = $request->description_two;
        $data->urgent_tag = $request->urgent_tag;
        $data->btn_text = $request->btn_text ?? 'Get Free Estimate';
        $data->btn_link = $request->btn_link;

        // Process features
        $features = [];
        if ($request->features) {
            foreach ($request->features as $item) {
                if (!empty($item['text'])) {
                    $features[] = [
                        'icon' => $item['icon'] ?? 'bi bi-check-circle-fill',
                        'text' => $item['text']
                    ];
                }
            }
        }
        $data->features = !empty($features) ? $features : null;

        $lastSerial = Service::max('serial');
        $data->serial = $lastSerial ? $lastSerial + 1 : 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = mt_rand(10000000,99999999).'.webp';
            $path = public_path('uploads/service/');
            if(!file_exists($path)) mkdir($path,0755,true);

            Image::make($file)
                ->resize(800, null, function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 75)
                ->save($path.$name);

            $data->image = $name;
        }

        $data->save();
        Cache::forget('active_services');
        return response()->json(['message' => 'Service created successfully!'], 200);
    }

    public function serviceEdit($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function serviceUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:services,title,'.$request->codeid,
            'subtitle' => 'nullable|string',
            'slug' => 'nullable|unique:services,slug,'.$request->codeid,
            'icon' => 'nullable|string',
            'badge' => 'nullable|string',
            'badge_type' => 'nullable|in:default,urgent,popular,premium',
            'badge_class' => 'nullable|string',
            'heading' => 'required|string',
            'description' => 'required|string',
            'description_two' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*.text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'urgent_tag' => 'nullable|string|max:20',
            'btn_text' => 'nullable|string',
            'btn_link' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->codeid);
        $service->title = $request->title;
        $service->subtitle = $request->subtitle;
        $service->slug = $request->slug ? Str::slug($request->slug) : $service->slug;
        $service->icon = $request->icon ?? 'bi bi-wrench';
        $service->badge = $request->badge;
        $service->badge_type = $request->badge_type ?? 'default';
        $service->badge_class = $request->badge_class ?? '';
        $service->heading = $request->heading;
        $service->description = $request->description;
        $service->description_two = $request->description_two;
        $service->urgent_tag = $request->urgent_tag;
        $service->btn_text = $request->btn_text ?? 'Get Free Estimate';
        $service->btn_link = $request->btn_link;

        // Process features
        $features = [];
        if ($request->features) {
            foreach ($request->features as $item) {
                if (!empty($item['text'])) {
                    $features[] = [
                        'icon' => $item['icon'] ?? 'bi bi-check-circle-fill',
                        'text' => $item['text']
                    ];
                }
            }
        }
        $service->features = !empty($features) ? $features : null;

        if ($request->hasFile('image')) {
            if ($service->image && file_exists(public_path('uploads/service/'.$service->image))) {
                @unlink(public_path('uploads/service/'.$service->image));
            }
            $file = $request->file('image');
            $name = mt_rand(10000000,99999999).'.webp';
            $path = public_path('uploads/service/');
            if(!file_exists($path)) mkdir($path,0755,true);

            Image::make($file)
                ->resize(800, null, function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 75)
                ->save($path.$name);

            $service->image = $name;
        }

        $service->save();
        Cache::forget('active_services');
        return response()->json(['message' => 'Service updated successfully!'], 200);
    }

    public function serviceDelete($id)
    {
        $service = Service::findOrFail($id);
        // Soft delete handles deleted_by automatically via model booted()
        $service->delete();
        Cache::forget('active_services');
        return response()->json(['message' => 'Service deleted successfully.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        $service->status = $request->status;
        $service->save();
        Cache::forget('active_services');
        return response()->json(['message' => 'Service status updated successfully.'], 200);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Service::query()->where('id', $id)->update(['serial' => $index + 1]);
        }
        Cache::forget('active_services');
        return response()->json(['success' => true, 'message' => 'Service order updated successfully!']);
    }
}