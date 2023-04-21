<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use Illuminate\Support\Facades\File;

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
    public function create()
    {
        return view('pages.backend.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventCreateRequest $request)
    {
        $input = $request->all();
        $filename = microtime() . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images/events', $filename, 'public');
        $input['image'] = '/storage/' . $path;

        $event = Event::create($input);
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
        $input = $request->all();

        if ($request->hasFile('image')) {
            $filename = microtime() . $request->file('image')->getClientOriginalName();
            $existing_path = $input['image'];
            if (Storage::disk('public')->exists($existing_path)) {
                Storage::disk('public')->delete($existing_path);
            }
            $path = $request->file('image')->storeAs('images/events', $filename, 'public');
            $input['image'] = '/storage/' . $path;
        }

        $event = Event::findOrFail($request->id);
        $event->update($input);


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
    }
}
