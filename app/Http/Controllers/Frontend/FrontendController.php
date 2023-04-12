<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){

        $events = Event::all();
        return view('pages/frontend/home', compact('events'));

    }

    public function downloadPdf($id){
        $events = Event::findOrFail($id);
        $participants = Participant::where('event_id', '=', $id)->get();
        
        return view('pages.frontend.event.index', compact('events', 'participants'));

    }
}
