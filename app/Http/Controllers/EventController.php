<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $input = $request->only(
            'name',
            'short_description'
        );
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('/assets/backend/images/events'), $filename);
            $input['image'] = $filename;
        }
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
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $event->name = $request->name;
        $event->short_description = $request->short_description;

        if ($request->hasFile('image')) {
            $destination = '/assets/backend/images/events/' . $event->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('/assets/backend/images/events'), $filename);
            $event->image = $filename;
        }
        $event->update();

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
