<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\ParticipantType;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    
    public function index()
    {
        $events = Event::all();
        $participants = Participant::all();
        return view('pages.backend.participant.index', compact('events', 'participants'));
    }

    
    public function create(Request $request)
    {
        $events = Event::all();
        $participantTypes = ParticipantType::all();

        return view('pages.backend.participant.create', compact('events', 'participantTypes'));
    }

    public function store(Request $request)
    {
        $input = $request->only('name', 'affilated_institute', 'post', 'event_id', 'participantType_id');
        $participant = Participant::create($input);
        $participant->save();

        return redirect('/admin/participants')->with('message', 'Participant created Successfully..');
    }

    public function edit(Request $request, $id)
    {
        $events = Event::all();
        $participantTypes = ParticipantType::all();


        $participant = Participant::findOrFail($id);
        return view('pages.backend.participant.edit', compact('participant', 'events', 'participantTypes'));
    }

    public function update(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->name = $request->name;
        $participant->affilated_institute = $request->affilated_institute;
        $participant->post = $request->post;
        $participant->event_id = $request->event_id;
        $participant->participantType_id = $request->participantType_id;

        $participant->update();

        return redirect('/admin/participants')->with('message', 'Participant Updated Successfully..');
    }


    public function destory($id)
    {
        $participant=Participant::findOrFail($id);
        $participant->delete();

        return redirect('/admin/participants')->with('message', 'Participant Deleted Successfully..');
    }
}
