<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Controllers\Controller;
use App\Models\EventPoster;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::all();
        return view('dashboard.events.index', compact('events'));
    }

    public function create(Request $request)
    {
        return view('dashboard.events.edit')->with([
            'action' => route('dashboard.events.store'),
            'method' => 'POST',
            'posters' => [],
        ]);
    }

    public function store(Request $request)
    {
        $images = $this->uploadedFiles($request, Event::$storagePath);
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->image_card = $images['image_card'];
        $event->main_image = $images['main_image'];
        $event->date = $request->date;
        $event->show_in_home_page = $request->get("show_in_home_page") ? 1 : 0;
        $event->save();
        foreach ($images['posters'] as $poster) {
            EventPoster::create([
                'poster' => $poster,
                'event_id' => $event->id
            ]);
        }
        return redirect('dashboard/events')
            ->with(
                'success',
                __('dashboard.event_created_successfully')
            );
    }

    public function edit(Request $request, Event $event)
    {
        return view('dashboard.events.edit')->with([
            'event' => $event,
            'method' => 'PUT',
            'action' => route('dashboard.events.update', ['event' => $event]),
            'posters' => $event->posters()?->pluck('poster')->toArray(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $images = $this->uploadedFiles($request, Event::$storagePath, $event->id);
        $event->title = $request->title;
        $event->description = $request->description;
        $event->image_card = $images['image_card'];
        $event->main_image = $images['main_image'];
        $event->date = $request->date;
        $event->show_in_home_page = $request->get("show_in_home_page") ? 1 : 0;
        $event->save();
        foreach ($images['posters'] as $poster) {
            EventPoster::create([
                'poster' => $poster,
                'event_id' => $event->id
            ]);
        }
        return redirect('dashboard/events')
            ->with(
                'success',
                __('dashboard.event_updated_successfully')
            );
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect('dashboard/events')
            ->with(
                'success',
                __('dashboard.event_deleted_successfully')
            );
    }

    public function uploadedFiles(Request $request, string $storagePath, int $id = null): array
    {
        $mainImage = $imageCard = '';
        $posters = [];
        $fileService = new FileService;

        if ($id) {
            $event = Event::find($id);
            $mainImage = $event->main_image ? $event->main_image : '';
            $imageCard = $event->image_card ? $event->image_card : '';
            $posters = $event->posters()->pluck('poster')->toArray();

            if ($request->hasFile('main_image')) {
                $mainImage = $fileService->verifyAndUploadFile($request->file('main_image'), $mainImage, 'public', $storagePath);
            }
            if ($request->hasFile('image_card')) {
                $imageCard = $fileService->verifyAndUploadFile($request->file('image_card'), $imageCard, 'public', $storagePath);
            }

            if ($request->hasFile('posters')) {
                foreach ($event->posters()->pluck('poster')->toArray() as $poster) {
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

            if ($request->has('posters')) {
                foreach ($request->file('posters') as $key => $poster) {
                    $posters[] = $fileService->verifyAndUploadFile($request->file('posters')[$key], '', 'public', $storagePath);
                }
            }
        }

        return [
            'image_card' => $imageCard,
            'main_image' => $mainImage,
            'posters' => $posters,
        ];
    }
}
