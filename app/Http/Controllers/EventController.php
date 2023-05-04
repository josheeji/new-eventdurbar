<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return view('pages.backend.event.index', compact('events'));
    }



    public function create()
    {
        return view('pages.backend.event.create');
    }

    public function store(EventCreateRequest $request)
    {

        $input = new Event;
        $input->event_slug = Str::slug($request->event_slug);
        $input->name = $request->name;
        $input->short_description = $request->short_description;


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = microtime() . '.' . $extension;
            // $path = $file->store('events', 'public');
            $path = $file->storeAs('public/events', $filename);
            $input['image'] = $filename;
        }
        $input->save();
        return redirect('/admin/events')->with('message', 'Event Created Successfullyy..');
    }

    public function edit(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        return view('pages.backend.event.edit', compact('event'));
    }

    public function update(EventUpdateRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->name = $request->name;

        $event->event_slug = Str::slug($request->event_slug);
        $event->short_description = $request->short_description;

        if ($request->hasFile('image')) {
            Storage::delete('public/events/' . $event->image);

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $extension;
            $path = $file->storeAs('public/events', $filename);
            $event->image = $filename;
        }

        $event->update();
        return redirect('/admin/events')->with('meaasge', 'Event Updated Successfully..');
    }

    public function trash()
    {
        $events = Event::onlyTrashed()->get();
        return view('pages.backend.event.trash', compact('events'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect('/admin/events')
            ->with('message', 'Event Deleted successfully..');
    }

    public function restore($id)
    {
        $event = Event::withTrashed()->findOrFail($id);
        if ($event->trashed()) {
            $event->restore();
        }

        return redirect('/admin/events/trash/')
            ->with('message', 'Event Restored successfully..');
    }

    public function forceDelete($id)
    {
        $event = Event::withTrashed()->findOrFail($id);
        if ($event->trashed()) {
            $event->forceDelete();
        }

        return redirect('/admin/events/trash/')
            ->with('message', 'Event Deleted successfully..');
    }
}
