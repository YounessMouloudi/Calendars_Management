<?php

namespace App\Http\Controllers;

use App\Models\Calendrier;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendrierController extends Controller
{
    public function index()
    {
        // $calendars = auth()->user()->calendars;

        // $events = array();

        // $listEvents = Event::all();

        // foreach($listEvents as $event) {
            
        //     $events[] = [
        //         'id'   => $event->id,
        //         'name' => $event->name,
        //         'start_date' => $event->start_date,
        //         'end_date' => $event->end_date,
        //         'description' => $event->description,
        //     ];
        // }        
        // return view("calendriers.index",[
        //     "events" => $events
        // ]);

        $user = Auth::user();
        
        $calendriers = Calendrier::where('user_id', $user->id)->get();
        
        return view("calendriers.calendrier", compact('calendriers'));

        // $events = Event::all();
        
        // return view("calendriers.index",["events" => $events])->with("message","events");
    }

    public function create()
    {
        return view("calendriers.add");
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'name' => "required|string|max:50",
        ]);

        $user = Auth::user();
        $fields['user_id'] = $user->id;

        $calendrier = Calendrier::create($fields);

        // return response()->json([
        //     "message" => "calendrier created successfully",
        //     "calendrier" => $calendrier
        // ]);

        return redirect()->route('calendriers.index')->with('success', 'calendrier created successfully');
    }

    public function show($id)
    {
        $calendrier = Calendrier::with('events')->findOrFail($id);

        $user = Auth::user();
        
        $calendriers = Calendrier::where('user_id', $user->id)->get();

        $events = $calendrier->events;

        return view("calendriers.index",[
            "events" => $events , 
            "calendrier" => $calendrier,
            "calendriers" => $calendriers
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $calendrier = Calendrier::with('events')->findOrFail($id);
                        
        return view("calendriers.edit",[
            "calendrier" => $calendrier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Calendrier $calendrier)
    {

        if (Auth::user()->id !== $calendrier->user_id) {
            return redirect()->route('calendriers.index')
            ->with('error', "Vous n'avez pas l'autorisation de modifier ce calendrier");
        }

        $fields = $request->validate([
            'name' => "required|string|max:50",
        ]);

        if($calendrier->fill($fields)->isDirty()){
            
            $user = Auth::user();
            $fields['user_id'] = $user->id;

            $calendrier->update($fields);

            return redirect()->route('calendriers.index')->with('success', 'calendrier updated successfully');
        }
        else {
            return back()->with('info', 'No changes detected'); 
        }
    }

    public function destroy(Calendrier $calendrier)
    {
        if (Auth::user()->id !== $calendrier->user_id) {
            return redirect()->route('calendriers.index')
            ->with('error', "Vous n'avez pas l'autorisation de supprimer ce calendrier");
        }

        $calendrier->delete();
        return redirect()->route('calendriers.index')->with('success', 'calendrier deleted successfully');
    }

}
