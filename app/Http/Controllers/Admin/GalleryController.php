<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('preview', function ($row) {
                    $img = $row->preview_image;
                    $categoryLabel = Gallery::getCategoryOptions()[$row->category] ?? $row->category;
                    $badge = '<span class="badge bg-secondary ms-1">' . $categoryLabel . '</span>';
                    
                    return '<img src="/' . $img . '" width="60" class="img-thumbnail rounded" onerror="this.src=\'https://via.placeholder.com/60\'">' . $badge;
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox"
                                    data-id="' . $row->id . '" ' . $checked . '>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<button id="EditBtn" rid="' . $row->id . '" class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn"
                                data-delete-url="' . route('galleries.destroy', $row->id) . '"
                                data-table="#galleryTable">Delete</button>';
                })
                ->rawColumns(['preview', 'status', 'action'])
                ->make(true);
        }

        return view('admin.galleries.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'type'      => 'required|in:image,video,youtube',
            'category'  => 'required|string',
            'title'     => 'required|string|max:255',
            'location'  => 'nullable|string|max:255',
            'year'      => 'nullable|string|max:10',
            'sort_order'=> 'nullable|integer|min:0',
        ];

        // Explicitly check for each type
        if ($request->type === 'youtube') {
            $rules['video_link'] = 'required|url';
        } elseif ($request->type === 'video') {
            $rules['file'] = 'required|file|mimes:mp4,mov,avi,mkv|max:51200';
            $rules['thumbnail'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
        } elseif ($request->type === 'image') {
            $rules['before_image'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
            $rules['after_image']  = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
        }

        $request->validate($rules);
        $gallery = new Gallery();
        $this->saveData($gallery, $request);

        return response()->json(['message' => 'Gallery item added successfully!']);
    }

    public function edit($id)
    {
        return Gallery::findOrFail($id);
    }

    public function update(Request $request)
    {
        $rules = [
            'type'      => 'required|in:image,video,youtube',
            'category'  => 'required|string',
            'title'     => 'required|string|max:255',
            'location'  => 'nullable|string|max:255',
            'year'      => 'nullable|string|max:10',
            'sort_order'=> 'nullable|integer|min:0',
        ];

        // Explicitly check for each type (use 'nullable' for update so they don't have to re-upload)
        if ($request->type === 'youtube') {
            $rules['video_link'] = 'required|url';
        } elseif ($request->type === 'video') {
            $rules['file'] = 'nullable|file|mimes:mp4,mov,avi,mkv|max:51200';
            $rules['thumbnail'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
        } elseif ($request->type === 'image') {
            $rules['before_image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
            $rules['after_image']  = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
        }

        $request->validate($rules);
        $gallery = Gallery::findOrFail($request->codeid);
        $this->saveData($gallery, $request);

        return response()->json(['message' => 'Gallery item updated successfully!']);
    }

    private function saveData(Gallery $gallery, Request $request)
    {
        $gallery->type       = $request->type;
        $gallery->category   = $request->category;
        $gallery->title      = $request->title;
        $gallery->subtitle   = $request->subtitle;
        $gallery->location   = $request->location;
        $gallery->year       = $request->year;
        $gallery->sort_order = $request->sort_order ?? 0;
        $gallery->status     = $request->has('status') ? 1 : 0;
        $gallery->video_link = $request->video_link ?? null;

        // Handle Before Image
        if ($request->hasFile('before_image')) {
            if ($gallery->before_image && File::exists(public_path($gallery->before_image))) {
                File::delete(public_path($gallery->before_image));
            }
            $file = $request->file('before_image');
            $filename = time() . '_before.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery/images'), $filename);
            $gallery->before_image = 'uploads/gallery/images/' . $filename;
        }

        // Handle After Image
        if ($request->hasFile('after_image')) {
            if ($gallery->after_image && File::exists(public_path($gallery->after_image))) {
                File::delete(public_path($gallery->after_image));
            }
            $file = $request->file('after_image');
            $filename = time() . '_after.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery/images'), $filename);
            $gallery->after_image = 'uploads/gallery/images/' . $filename;
        }

        // Handle local file upload (Legacy)
        if ($request->hasFile('file')) {
            if ($gallery->file_path && File::exists(public_path($gallery->file_path))) {
                File::delete(public_path($gallery->file_path));
            }
            $file     = $request->file('file');
            $folder   = $gallery->type === 'video' ? 'uploads/gallery/videos' : 'uploads/gallery/images';
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $gallery->file_path = $folder . '/' . $filename;
        }

        // Handle thumbnail upload (Legacy)
        if ($request->hasFile('thumbnail')) {
            if ($gallery->thumbnail && File::exists(public_path($gallery->thumbnail))) {
                File::delete(public_path($gallery->thumbnail));
            }
            $thumb = $request->file('thumbnail');
            $tname = time() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumb->move(public_path('uploads/gallery/thumbnails'), $tname);
            $gallery->thumbnail = 'uploads/gallery/thumbnails/' . $tname;
        }

        if ($request->type === 'youtube') {
            if ($gallery->file_path && File::exists(public_path($gallery->file_path))) {
                File::delete(public_path($gallery->file_path));
                $gallery->file_path = null;
            }
        }

        $gallery->save();
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete new images
        if ($gallery->before_image && File::exists(public_path($gallery->before_image))) File::delete(public_path($gallery->before_image));
        if ($gallery->after_image && File::exists(public_path($gallery->after_image))) File::delete(public_path($gallery->after_image));
        
        // Delete old images
        if ($gallery->file_path && File::exists(public_path($gallery->file_path))) File::delete(public_path($gallery->file_path));
        if ($gallery->thumbnail && File::exists(public_path($gallery->thumbnail))) File::delete(public_path($gallery->thumbnail));

        $gallery->delete();
        return response()->json(['message' => 'Deleted successfully!']);
    }
}