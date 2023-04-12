<?php

namespace App\Http\Controllers;

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
    public function store(Request $request, $eventid)
    {
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
        // dd($id);

        $file->move(resource_path('/views/certificates/' . $id), $filename);

        if ($request->hasFile('template_files')) {
            foreach ($request->file('template_files') as $file) {
                $filename = $file->getClientOriginalName();
                $file->move(public_path('/assets/backend/images/certificates/' . $id), $filename);
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
    public function update(Request $request, $eventid, $participantTypeId)
    {
        $participantType = ParticipantType::findOrFail($eventid);
        $participantType->name = $request->name;
        $participantType->event_id = $request->event_id;
        $participantType->template_width = $request->template_width;
        $participantType->template_height = $request->template_height;


        $file = $request->file('url');
        $filename = 'index.blade.php';
        $input['url'] = $filename;

        if ($participantType) {
            // Delete the old file
            $old_file_path = resource_path('/views/certificates/' . $eventid . '/' . $participantType->url);
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }
        // Move the new file to the appropriate folder
        $file->move(resource_path('/views/certificates/' . $eventid), $filename);

        $participantType = ParticipantType::updateOrCreate(['id' => $eventid], $input);


        // Delete the old template files
        $old_template_files_path = public_path('/assets/backend/images/certificates/' . $eventid);
        if (file_exists($old_template_files_path)) {
            $old_template_files = File::allFiles($old_template_files_path);
            foreach ($old_template_files as $file) {
                if (in_array($file->getFilename(), $participantType->template_files)) {
                    unlink($file->getPathname());
                }
            }
        }

        // Move the new template files to the appropriate folder
        if ($request->hasFile('template_files')) {
            foreach ($request->file('template_files') as $file) {
                $filename = $file->getClientOriginalName();
                $file->move(public_path('/assets/backend/images/certificates/' . $eventid), $filename);
                $input['template_files'][] = $filename;
            }
        }




        // if ($request->hasFile('url')) {
        //     $destination = '/views/certificates/' . $participantTypeId->file;
        //     if (File::exists($destination)) {
        //         File::delete($destination);
        //     }
        //     $file = $request->file('file');
        //     $filename = 'index.blade.php';
        //     $file->move(resource_path('/views/certificates/' . $participantTypeId), $filename);

        //     $participantType->file = $filename;
        // }

        // if ($request->hasFile('template_files')) {
        //     foreach ($request->file('template_files') as $file) {
        //         $destination = '/assets/backend/images/certificates/' . $participantType->template_files;
        //         if (File::exists($destination)) {
        //             File::delete($destination);
        //         }
        //         $filename = $file->getClientOriginalName();
        //         $file->move(public_path('/assets/backend/images/certificates/' . $participantTypeId), $filename);
        //         $input['template_files'] = $filename;
        //     }
        // }
        $participantType->update();
        return redirect('admin/events/' . $eventid . '/participant-types');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $eventid, $participantTypeId)
    {
        $event = Event::findOrFail($eventid);
        $participantType = ParticipantType::findOrFail($participantTypeId);

        $participantType->delete();

        return redirect('admin/events/' . $eventid . '/participant-types', compact('event'))->with('message', 'Participant Type Deleted Successfully..');
    }
}
