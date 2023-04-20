<?php

namespace App\Http\Controllers;

use App\Imports\ParticipantsImport;
use App\Models\Event;
use App\Models\Participant;
use App\Models\ParticipantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;



class ParticipantController extends Controller
{

    public function index(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // $participantType = ParticipantType::where('participant_type_id', $request->participant_type_id)->get();

        $participants = Participant::where('event_id', '=', $eventId)->get();
        // $participants = Participant::all();
        // $participants = $event->participants()->where('event_id', '=', 'eventId')->get();




        return view('pages.backend.participant.index', compact('event', 'participants'));
    }

    public function create(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $participantTypes = ParticipantType::where('event_id', '=', $eventId)->get();

        return view('pages.backend.participant.create', compact('event', 'participantTypes'));
    }

    public function store(Request $request, $eventId)
    {
        $input = $request->only('name', 'affilated_institute', 'post', 'event_id', 'participant_type_id');
        $participant = Participant::create($input);

        return redirect('/admin/events/' . $eventId . '/participants')->with('message', 'Participant created Successfully..');
    }

    public function edit(Request $request, $eventId,  $id)
    {
        $event = Event::findOrFail($eventId);
        $participantTypes = ParticipantType::all();

        $participant = Participant::findOrFail($id);
        return view('pages.backend.participant.edit', compact('participant', 'event', 'participantTypes'));
    }

    public function update(Request $request, $eventId,  $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->name = $request->name;
        $participant->affilated_institute = $request->affilated_institute;
        $participant->post = $request->post;
        $participant->event_id = $request->event_id;
        $participant->participant_type_id = $request->participant_type_id;

        $participant->update();

        return redirect('/admin/events/' . $eventId . '/participants')->with('message', 'Participant Updated Successfully..');
    }


    public function destory($eventId, $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();

        return redirect('/admin/events/' . $eventId . '/participants')->with('message', 'Participant Deleted Successfully..');
    }


    public function importExcel($eventId)
    {
        $event = Event::findOrFail($eventId);
        // $participantTypes = ParticipantType::where('event_id', '=', 'participant_type_id');
        $participantTypes = ParticipantType::where('event_id', '=', $eventId)->get();


        return view('pages.backend.participant.import', compact('event', 'participantTypes'));
    }

    public function storeExcel(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // $eventId = $request->input('event_id');
        $participantTypeId = $request->input('participant_type_id');

        $file = $request->file('excel_file');
        Excel::import(new ParticipantsImport($eventId, $participantTypeId), $file);
        return redirect('/admin/events/' . $eventId . '/participants')->with('message', 'File Uploaded Successfully');
    }


    public function generatePdf(Request $request, $eventId, $participantId)
    {
        $event = Event::findOrFail($eventId);


        $participant = Participant::findOrFail($participantId);
        $participantType = $participant->participantType;
        $resourcePath = public_path('/assets/backend/images/certificates/' .  $participantType->id . '/');

        $height = $participantType->template_height;
        $widht = $participantType->template_width;
        $customPaper = array(0, 0, $height ?: 667.00, $widht ?: 954.80);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('certificates.' . $participantType->id . '.index', compact('participant', 'resourcePath'))
            ->setPaper($customPaper, 'potrait');
        // ->setPaper('A5', 'patroit');
        // return $pdf->stream('certificate.pdf');
        return $pdf->download('certificate.pdf');
    }
}
