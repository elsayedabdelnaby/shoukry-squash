<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Press;
use App\Models\PressPoster;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Controllers\Controller;

class PressController extends Controller
{
    public function index(Request $request)
    {
        $press = Press::all();
        return view('dashboard.press.index', compact('press'));
    }

    public function create(Request $request)
    {
        return view('dashboard.press.edit')->with([
            'action' => route('dashboard.press.store'),
            'method' => 'POST',
            'posters' => [],
        ]);
    }

    public function store(Request $request)
    {
        $images = $this->uploadedFiles($request, Press::$storagePath);
        $press = new Press();
        $press->title = $request->title;
        $press->video_url = $request->video_url;
        $press->image_card = $images['image_card'];
        $press->main_image = $images['main_image'];
        $press->show_in_home_page = $request->get("show_in_home_page") ? 1 : 0;
        $press->save();
        foreach ($images['posters'] as $poster) {
            PressPoster::create([
                'poster' => $poster,
                'press_id' => $press->id
            ]);
        }
        return redirect('dashboard/press')
            ->with(
                'success',
                __('dashboard.press_created_successfully')
            );
    }

    public function edit(Request $request, Press $press)
    {
        return view('dashboard.press.edit')->with([
            'press' => $press,
            'method' => 'PUT',
            'action' => route('dashboard.press.update', ['press' => $press]),
            'posters' => $press->posters()?->pluck('poster')->toArray(),
        ]);
    }

    public function update(Request $request, Press $press)
    {
        $images = $this->uploadedFiles($request, Press::$storagePath, $press->id);
        $press->title = $request->title;
        $press->video_url = $request->video_url;
        $press->image_card = $images['image_card'];
        $press->main_image = $images['main_image'];
        $press->show_in_home_page = $request->get("show_in_home_page") ? 1 : 0;
        $press->save();
        foreach ($images['posters'] as $poster) {
            PressPoster::create([
                'poster' => $poster,
                'press_id' => $press->id
            ]);
        }
        return redirect('dashboard/press')
            ->with(
                'success',
                __('dashboard.press_updated_successfully')
            );
    }

    public function destroy(Press $press)
    {
        $press->delete();
        return redirect('dashboard/press')
            ->with(
                'success',
                __('dashboard.press_deleted_successfully')
            );
    }

    public function uploadedFiles(Request $request, string $storagePath, int $id = null): array
    {
        $mainImage = $imageCard = '';
        $posters = [];
        $fileService = new FileService;

        if ($id) {
            $press = Press::find($id);
            $mainImage = $press->main_image ? $press->main_image : '';
            $imageCard = $press->image_card ? $press->image_card : '';
            $posters = $press->posters()->pluck('poster')->toArray();

            if ($request->hasFile('main_image')) {
                $mainImage = $fileService->verifyAndUploadFile($request->file('main_image'), $mainImage, 'public', $storagePath);
            }
            if ($request->hasFile('image_card')) {
                $imageCard = $fileService->verifyAndUploadFile($request->file('image_card'), $imageCard, 'public', $storagePath);
            }

            if ($request->hasFile('posters')) {
                foreach ($press->posters()->pluck('poster')->toArray() as $poster) {
                    $fileService->deleteFile($poster, $storagePath);
                }
            } else {
                $posters = [];
            }
        } else {
            if ($request->hasFile('main_image')) {
                $mainImage = $fileService->verifyAndUploadFile($request->file('main_image'), $mainImage, 'public', $storagePath);
            }
            if ($request->hasFile('image_card')) {
                $imageCard = $fileService->verifyAndUploadFile($request->file('image_card'), $imageCard, 'public', $storagePath);
            }
        }

        if ($request->has('posters')) {
            foreach ($request->file('posters') as $key => $poster) {
                $posters[] = $fileService->verifyAndUploadFile($request->file('posters')[$key], '', 'public', $storagePath);
            }
        }

        return [
            'image_card' => $imageCard,
            'main_image' => $mainImage,
            'posters' => $posters,
        ];
    }
}
