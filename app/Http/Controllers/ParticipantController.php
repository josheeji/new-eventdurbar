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
        $participant = Participant::findOrFail($id);
        $participant->delete();

        return redirect('/admin/participants')->with('message', 'Participant Deleted Successfully..');
    }


    public function importExcel()
    {
        $events = Event::all();
        $participantTypes = ParticipantType::all();

        return view('pages.backend.participant.import', compact('events', 'participantTypes'));
    }

    public function storeExcel(Request $request)
    {
        $eventId = $request->input('event_id');
        $participantTypeId = $request->input('participantType_id');

        $file = $request->file('excel_file');
        Excel::import(new ParticipantsImport($eventId, $participantTypeId), $file);
        return redirect('/admin/participants')->with('message', 'File Uploaded Successfully');
    }


    public function generatePdf(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);
        $participantType = $participant->participantType;
        $resourcePath = public_path('/assets/backend//images/certificates/' .  $participantType->id . '/');
    
        $height = $participantType->template_height;
        $widht = $participantType->template_width;
        $customPaper = array(0, 0, $height ?: 667.00, $widht ?: 954.80);
    
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('certificates.' . $participantType->id . '.index', compact('participant', 'resourcePath'))
            ->setPaper($customPaper, 'potrait');
        // ->setPaper('A4', 'portrait');
        // return $pdf->stream('certificate.pdf');
        return $pdf->download('certificate.pdf');    
    }
    
}
