<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Services\FileService;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $gallery = Gallery::all();
        return view('dashboard.gallery.index', compact('gallery'));
    }

    public function create(Request $request)
    {
        return view('dashboard.gallery.edit')->with([
            'action' => route('dashboard.gallery.store'),
            'method' => 'POST',
            'posters' => [],
        ]);
    }

    public function store(Request $request)
    {
        $images = $this->uploadedFiles($request, Gallery::$storagePath);
        $gallery = new Gallery();
        $gallery->image = $images['image'];
        $gallery->save();
        return redirect('dashboard/gallery')
            ->with(
                'success',
                __('dashboard.gallery_created_successfully')
            );
    }

    public function edit(Request $request, Gallery $gallery)
    {
        return view('dashboard.gallery.edit')->with([
            'gallery' => $gallery,
            'method' => 'PUT',
            'action' => route('dashboard.gallery.update', ['gallery' => $gallery]),
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $images = $this->uploadedFiles($request, Gallery::$storagePath);
        $gallery->image = $images['image'];
        $gallery->save();
        return redirect('dashboard/gallery')
            ->with(
                'success',
                __('dashboard.gallery_updated_successfully')
            );
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect('dashboard/gallery')
            ->with(
                'success',
                __('dashboard.gallery_deleted_successfully')
            );
    }

    public function uploadedFiles(Request $request, string $storagePath, int $id = null): array
    {
        $image = '';
        $fileService = new FileService;

        if ($id) {
            $gallery = Gallery::find($id);
            $image = $gallery->image ? $gallery->image : '';

            if ($request->hasFile('image')) {
                $image = $fileService->verifyAndUploadFile($request->file('image'), $image, 'public', $storagePath);
            }
        } else {
            if ($request->hasFile('image')) {
                $image = $fileService->verifyAndUploadFile($request->file('image'), $image, 'public', $storagePath);
            }
        }


        return [
            'image' => $image,
        ];
    }
}
