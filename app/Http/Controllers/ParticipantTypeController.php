<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ParticipantType;
use Illuminate\Http\Request;

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
    public function store(Request $request, $eventid)
    {
        $input = $request->only('name', 'event_id');
        $participantType = ParticipantType::create($input);
        $participantType->save();
        return redirect('admin/events/'. $eventid . '/participant-types');
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $eventid, $participantTypeId)
    {
        $event = Event::findOrFail($eventid);
        $participantType = ParticipantType::findOrFail($participantTypeId);
        return view('pages.backend.participantType.edit', compact('event','participantType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $eventid, $participantTypeId)
    {
        $participantType = ParticipantType::findOrFail($participantTypeId);
        $participantType->name = $request->name;
        $participantType->event_id = $request->event_id;
        $participantType->update();
        return redirect('admin/events/'. $eventid . '/participant-types');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $eventid)
    {
        //
    }
}
