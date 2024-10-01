<?php

namespace App\Http\Controllers;

use App\Models\Calendrier;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $events = Event::where('user_id', $user->id)->get();

        return view('events.index', compact('events'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $calendriers = Calendrier::all();

        return view('events.add',compact("calendriers"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'calendrier_id' => 'required|exists:calendriers,id',
        ]);
        
        $user = Auth::user();
        $fields['user_id'] = $user->id;

        $fields['start_date'] = Carbon::parse($fields['start_date']);
        $fields['end_date'] = Carbon::parse($fields['end_date']);

        $event = Event::create($fields);        

        if($request->ajax()) {
            return response()->json([
                'message' => 'Event created successfully',
                "event" => $event
            ]);
        }
        else {
            return redirect()->route('events.index',compact("event"))->with("message","Event created successfully");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $calendriers = Calendrier::all();

        $event = Event::findOrFail($id);

        return view('events.edit',compact("calendriers","event"));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {        
        if (Auth::user()->id !== $event->user_id) {
            return redirect()->route('events.index')
            ->with('error', "Vous n'avez pas l'autorisation de modifier cette event");
        }

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'calendrier_id' => 'required|exists:calendriers,id',
        ]);

        if($event->fill($fields)->isDirty()) {

            $event->update($fields);

            if($request->ajax()){

                return response()->json([
                    'message' => 'Event updated successfully',
                ]);
            }
            else {
                return redirect()->route('events.index')->with("message","Event updated successfully");
            }    
        }
        else {
            if($request->ajax()){
                return response()->json([
                    'info' => 'No changes detected',
                ],422);
            }
            else {
                return back()->with('info', 'No changes detected'); 
            }
        }    

        // if($request->ajax()){

        //     return response()->json([
        //         'message' => 'Event updated successfully',
        //     ]);
        // }
        // else {

        //     if($event->fill($fields)->isDirty()) {
        //         $event->update($fields);
        //         return redirect()->route('events.index')->with("message","Event updated successfully");
        //     }
        //     else {
        //         return back()->with('info', 'No changes detected'); 
        //     }    
        // }

    }

    public function destroy(Event $event,Request $request)
    {
        if (Auth::user()->id !== $event->user_id) {
            return redirect()->route('calendriers.index')
            ->with('error', "Vous n'avez pas l'autorisation de supprimer cette event");
        }

        $event->delete();

        if($request->ajax()){
            return response()->json([
                'message' => 'Event deleted successfully',
            ]);
        }
        else {
            return redirect()->route('events.index')->with("message","Event updated successfully");
        }

    }

    public function updateDate(Request $request,$id)
    {
        $event = Event::findOrFail($id);

        if (Auth::user()->id !== $event->user_id) {
            return redirect()->route('calendriers.index')
            ->with('error', "Vous n'avez pas l'autorisation de modifier la date de cette event");
        }

        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;

        $event->save();

        return response()->json([
            'message' => 'Event date updated successfully',
            'event' => $event
        ]);
    }

    // public function storeEvent(Request $request)
    // {        

    //     $fields = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'start_date' => 'date',
    //         'end_date' => 'date|after_or_equal:start_date',
    //         'description' => 'nullable|string',
    //         'calendrier_id' => 'required|exists:calendriers,id',
    //     ]);
        
    //     $user = Auth::user();
    //     $fields['user_id'] = $user->id;

    //     $fields['start_date'] = Carbon::parse($fields['start_date']);
    //     $fields['end_date'] = Carbon::parse($fields['end_date']);

    //     $event = Event::create($fields);        


    // }

    // public function updateEvent(Request $request, Event $event)
    // {        
    //     if (Auth::user()->id !== $event->user_id) {
    //         return redirect()->route('events.index')
    //         ->with('error', "Vous n'avez pas l'autorisation de modifier cette event");
    //     }

    //     $fields = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:start_date',
    //         'description' => 'nullable|string',
    //         'calendrier_id' => 'required|exists:calendriers,id',
    //     ]);

    //     $fields['start_date'] = Carbon::parse($fields['start_date']);
    //     $fields['end_date'] = Carbon::parse($fields['end_date']);

    //     $event->update($fields);


    // }

    // public function destroyEvent(Event $event)
    // {   
    //     if (Auth::user()->id !== $event->user_id) {
    //         return redirect()->route('calendriers.index')
    //         ->with('error', "Vous n'avez pas l'autorisation de supprimer cette event");
    //     }

    //     $event->delete();


    // }
}
