<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantTypeCreateRequest;
use App\Http\Requests\ParticipantTypeUpdateeRequest;
use App\Models\Event;
use App\Models\ParticipantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ParticipantTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($eventid)
    {
        $event = Event::findOrFail($eventid);
        // $participantTypes = ParticipantType::all();

        $participantTypes = ParticipantType::where('event_id', '=', $eventid)->get();

        return view('pages.backend.participantType.index', compact('participantTypes', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($eventid)
    {
        $event = Event::findOrFail($eventid);
        return view('pages.backend.participantType.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParticipantTypeCreateRequest $request, $eventid)
    {
        // // $input = $request->all();

        // // if ($request->hasFile('image')) {
        // //     $filename = microtime() . $request->file('image')->getClientOriginalName();
        // //     $existing_path = $input['image'];
        // //     if (Storage::disk('public')->exists($existing_path)) {
        // //         Storage::disk('public')->delete($existing_path);
        // //     }
        // //     $path = $request->file('image')->storeAs('images/events', $filename);
        // //     $input['image'] = '/storage/' . $path;
        // // }

        // $event = Event::findOrFail($request->id);
        // $event->update($input);



        $input = $request->only(
            'name',
            'event_id',
            'template_width',
            'template_height'
        );

        $file = $request->file('url');
        $filename = 'index.blade.php';
        $input['url'] = $filename;


        $participantType = ParticipantType::create($input);

        $id = $participantType->id;

        $file->move(resource_path('/views/certificates/' . $id), $filename);

        if ($request->hasFile('template_files')) {
            foreach ($request->file('template_files') as $file) {
                $filename = $file->getClientOriginalName();
                $file->move(public_path('/assets/backend/templates/' . $id), $filename);
                $input['template_files'] = $filename;
            }
        }

        
        return redirect('admin/events/' . $eventid . '/participant-types')->with('message', 'Participant Type Created Successfully..');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $eventid, $participantTypeId)
    {
        $event = Event::findOrFail($eventid);
        $participantType = ParticipantType::findOrFail($participantTypeId);
        return view('pages.backend.participantType.edit', compact('event', 'participantType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParticipantTypeUpdateeRequest $request, $eventid, $participantTypeId)
    {
        $participantType = ParticipantType::findOrFail($participantTypeId);
        $participantType->name = $request->name;
        $participantType->event_id = $request->event_id;
        $participantType->template_width = $request->template_width;
        $participantType->template_height = $request->template_height;


        $file = $request->file('url');
        $filename = 'index.blade.php';
        // $id = $participantType->id;

        if ($request->hasFile('url')) {
            $destination = '/views/certificates/' . $participantType->url;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('url');
            $filename = 'index.blade.php';
            $file->move(resource_path('views/certificates/' . $participantType->id), $filename);
            $participantType->url = $filename;
        }
        $participantType->update();

        // $file->move(resource_path('/views/certificates/' . $id), $filename);

        if ($request->hasFile('template_files')) {
            $files = '/assets/backend/templates/' . $participantType->template_files;
            if (File::exists($files)) {
                File::delete($files);
            }
            foreach ($request->file('template_files') as $file) {
                $filename = $file->getClientOriginalName();
                $file->move(public_path('/assets/backend/templates/' . $participantType->id), $filename);
                $participantType->template_files = $filename;
            }
        }



        return redirect('admin/events/' . $eventid . '/participant-types')->with('message', 'Participant Type Updated Successfully..');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $eventid, $participantTypeId)
    {
        $event = Event::findOrFail($eventid);
        $participantType = ParticipantType::findOrFail($participantTypeId);

        $participantType->delete();

        return redirect('admin/events/' . $eventid . '/participant-types')->with('message', 'Participant Type Deleted Successfully..');
    }
}
