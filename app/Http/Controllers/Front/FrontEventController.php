<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;

class FrontEventController extends Controller
{
    //
    public function index (){
        return view("front.index", ["events"=> Event::latest()->get()]);
    }

    public function view (Request $request, $id=null)
    {

        if($request->isMethod("GET"))
        {
            $event = Event::find($id);

            if (is_null($event))
            {
                return redirect()->back()->with("error", "The Event was not found in the database");
            }
            return view("front.view", ["event" => $event]);

        }

        elseif ($request->isMethod("POST")) {
            $this->validate($request,
                [
                    "reserveName" => "required|max:240",
                    "reserveEmail" => "required|email|max:240"
                ]);
            $reserve = new Reservation();
            $reserve->reserve_name = $request->reserveName;
            $reserve->reserve_email = $request->reserveEmail;

            $reserve->event_id = $request->eventId;

            $reserve->save();

            return redirect()->back()->with("status", "Reservation Made succcesfully");
        }

        else {
            return redirect()->back()->with("error", "Invalid Requests");
        }
    }
}
