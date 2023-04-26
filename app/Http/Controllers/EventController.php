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

    /**
     * Show the form for creating a new resource.
     */

    public function trash()
    {
        $events = Event::onlyTrashed()->get();
        return view('pages.backend.event.trash', compact('events'));
    }





    public function create()
    {
        return view('pages.backend.event.create');
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(EventCreateRequest $request)
    {

        $input = new Event;
        $input->event_slug = Str::slug($request->event_slug);
        $input->name = $request->name;
        $input->short_description = $request->short_description;

        // $input = $request->only(
        //     'event_slug',
        //     'name',
        //     'short_description'
        // );
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = microtime() . '.' . $extension;
            $path = $file->storeAs('public/events', $filename);
            $input['image'] = $filename;
        }



        // $input = $request->all();

        // $filename = microtime() . '.' . $request->file('image')->getClientOriginalExtension();
        // $path = $request->file('image')->storeAs('events', $filename, 'public');
        // $input['image'] = '/storage/' . $path;
        // $event = Event::create($input);

        $input->save();
        return redirect('/admin/events')->with('message', 'Event Created Successfullyy..');
    }






    public function edit(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        return view('pages.backend.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->name = $request->name;
        $event->event_slug = $request->event_slug;

        $oldImage = $event['image'];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = microtime() . '.' . $extension;
            $path = $file->storeAs('public/events', $filename);
            if ($oldImage && Storage::exists('public/events/' . $oldImage)) {
                Storage::delete('public/events/' . $oldImage);
            }
            $event['image'] = $filename;
        }
        $event->update();

        // $event = Event::findOrFail($id);

        // $event->name = $request->name;
        // $event->short_description = $request->short_description;

        // if ($request->hasFile('image')) {
        //     $destination = '/assets/backend/images/events/' . $event->image;
        //     if (File::exists($destination)) {
        //         File::delete($destination);
        //     }
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $extension;
        //     $file->move(public_path('/assets/backend/images/events'), $filename);
        //     $event->image = $filename;
        // }
        // $event->update();

        return redirect('/admin/events')->with('meaasge', 'Event Updated Successfully..');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();


        return redirect('/admin/events')
            ->with('message', 'Event Deleted successfully..');



        // $event = Event::withTrashed()->findOrFail($id);
        // $event->delete();

        // if ($event->trashed()) {
        //     $event->restore();
        // }
        // return redirect('/admin/events')
        //     ->with('message', 'Event Deleted successfully..');

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
