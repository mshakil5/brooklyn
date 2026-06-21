<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::latest();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('feature_image', function ($row) {
                        $path = asset('images/banner/' . $row->feature_image);
                        return '<img src="' . $path . '" alt="Image" class="img-thumbnail feature-img" 
                                    style="width: 150px; height: 60px; cursor:pointer; object-fit:cover;" 
                                    data-full="' . $path . '">';
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->status ? 'checked' : '';
                        return '<div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" type="checkbox" id="customSwitch'.$row->id.'" data-id="'.$row->id.'" '.$checked.'>
                                    <label class="form-check-label" for="customSwitch'.$row->id.'"></label>
                                </div>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-sm btn-soft-info" id="EditBtn" rid="'.$row->id.'"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-soft-danger" id="DeleteBtn" rid="'.$row->id.'"><i class="fas fa-trash-alt"></i></button>';
                    })
                    ->rawColumns(['feature_image','status','action'])
                    ->make(true);
        }

        return view('admin.banner.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        $data = new Banner();
        $data->page = $request->page;
        $data->title = $request->title;
        $data->subtitle = $request->subtitle;
        $data->seo_title = $request->seo_title;
        $data->seo_description = $request->seo_description;
        $data->seo_keywords = $request->seo_keywords;
        $data->created_by = auth()->id();

        // Feature Image
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $imageName = mt_rand(10000000, 99999999) . '.webp';
            $destinationPath = public_path('images/banner/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            Image::make($uploadedFile)
                ->fit(1920, 600, function ($constraint) {
                    $constraint->upsize();
                }, 'center')
                ->encode('webp', 80)
                ->save($destinationPath . $imageName);

            $data->feature_image = $imageName;
        }

        // OG Image
        if ($request->hasFile('og_image')) {
            $uploadedFile = $request->file('og_image');
            $ogImageName = 'og_' . mt_rand(10000000, 99999999) . '.webp';
            $destinationPath = public_path('images/banner/og/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            Image::make($uploadedFile)
                ->fit(1200, 630, function ($constraint) {
                    $constraint->upsize();
                }, 'center')
                ->encode('webp', 80)
                ->save($destinationPath . $ogImageName);

            $data->og_image = $ogImageName;
        }

        $data->save();

        return response()->json(['status' => 200, 'message' => 'Data created successfully']);
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Add full URLs for images
        if ($banner->feature_image) {
            $banner->feature_image = asset('images/banner/' . $banner->feature_image);
        }
        if ($banner->og_image) {
            $banner->og_image = asset('images/banner/og/' . $banner->og_image);
        }

        return response()->json($banner);
    }

    public function update(Request $request)
    {
        $request->validate([
            'page' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        $data = Banner::findOrFail($request->id);
        $data->page = $request->page;
        $data->title = $request->title;
        $data->subtitle = $request->subtitle;
        $data->seo_title = $request->seo_title;
        $data->seo_description = $request->seo_description;
        $data->seo_keywords = $request->seo_keywords;
        $data->updated_by = auth()->id();

        // Feature Image
        if ($request->hasFile('image')) {
            if ($data->feature_image && file_exists(public_path('images/banner/' . $data->feature_image))) {
                unlink(public_path('images/banner/' . $data->feature_image));
            }

            $uploadedFile = $request->file('image');
            $imageName = mt_rand(10000000, 99999999) . '.webp';
            $destinationPath = public_path('images/banner/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            Image::make($uploadedFile)
                ->fit(1920, 600, function ($constraint) {
                    $constraint->upsize();
                }, 'center')
                ->encode('webp', 80)
                ->save($destinationPath . $imageName);

            $data->feature_image = $imageName;
        }

        // OG Image
        if ($request->hasFile('og_image')) {
            if ($data->og_image && file_exists(public_path('images/banner/og/' . $data->og_image))) {
                unlink(public_path('images/banner/og/' . $data->og_image));
            }

            $uploadedFile = $request->file('og_image');
            $ogImageName = 'og_' . mt_rand(10000000, 99999999) . '.webp';
            $destinationPath = public_path('images/banner/og/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            Image::make($uploadedFile)
                ->fit(1200, 630, function ($constraint) {
                    $constraint->upsize();
                }, 'center')
                ->encode('webp', 80)
                ->save($destinationPath . $ogImageName);

            $data->og_image = $ogImageName;
        }

        $data->save();

        return response()->json(['status' => 200, 'message' => 'Data updated successfully']);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->feature_image && file_exists(public_path('images/banner/' . $banner->feature_image))) {
            unlink(public_path('images/banner/' . $banner->feature_image));
        }

        if ($banner->og_image && file_exists(public_path('images/banner/og/' . $banner->og_image))) {
            unlink(public_path('images/banner/og/' . $banner->og_image));
        }

        $banner->delete();

        return response()->json(['status' => 200, 'message' => 'Data deleted successfully']);
    }

    public function toggleStatus(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->status = $request->status;
        $banner->save();

        return response()->json(['status' => 200, 'message' => 'Status updated successfully']);
    }
}