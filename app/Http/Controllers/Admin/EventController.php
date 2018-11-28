<?php

namespace App\Http\Controllers\Admin;

use App\Models\EventState;
use App\Models\EventType;
use App\Models\Reservation;
use App\Models\Months;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    //
    public function index ()
    {
        return view("admin.event.index", ["events"=> Event::latest()->get()]);

    }
    public function add (Request $request)
    {
     if ($request->isMethod("GET"))
     {
         return view("admin.event.add",
             ["event_states"=>EventState::all(),
                 "event_months"=>Months::all(),
                 "event_types"=>EventType::all()]);
     }
     elseif($request->isMethod("POST"))
     {
         $this->validate($request,
             [
                 "eventTitle" => "required|max:240",
                 "eventOrganizer" => "required",
                 "eventDetails" => "required",
                 "eventVenue" => "required",
                 "eventMonth"=>"required",
                 "eventDay" => "required",
                 "eventTime" => "required",
                 "typeId" => "required",
                 "stateId"=> "required"
             ]);

         $event = new Event();
         $event->event_title = $request->eventTitle;
         $event->event_organizer = $request->eventOrganizer;
         $event->event_details = $request->eventDetails;
         $event->event_venue = $request->eventVenue;
         $event->event_month = $request->eventMonth;
         $event->event_day = $request->eventDay;
         $event->event_time = $request->eventTime;

         $event->is_featured = !is_null($request->isFeatured) ? true : false;
         $event->is_public = !is_null($request->isPublic) ? true : false;

         $event->user_id = Auth::id();

         $event->type_id =  $request->typeId;
         $event->state_id = $request->stateId;

         $event->save();

         return redirect()->back()->with("status", "Event Added Successfully");

     }
     else {
        return redirect()->back()->with("error", "Invalid Request");
    }
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
            return view("admin.event.view", ["event" => $event, "event_states"=>EventState::all(),
                "event_types"=>EventType::all(), "months"=>Months::all(), "reservations"=>Reservation::all()->where('event_id', $event->id)]);

        }

        elseif ($request->isMethod("POST")) {
            $this->validate($request,
                [
                    "eventTitle" => "required|max:240",
                    "eventOrganizer" => "required",
                    "eventDetails" => "required",
                    "eventVenue" => "required",
                    "eventMonth"=>"required",
                    "eventDay" => "required",
                    "eventTime" => "required",
                    "typeId" => "required",
                    "stateId" => "required"
                ]);

            $event = Event::find($request->id);
            $event->event_title = $request->eventTitle;
            $event->event_organizer = $request->eventOrganizer;
            $event->event_details = $request->eventDetails;
            $event->event_venue = $request->eventVenue;
            $event->event_month = $request->eventMonth;
            $event->event_day = $request->eventDay;
            $event->event_time = $request->eventTime;

            $event->is_featured = !is_null($request->isFeatured) ? true : false;
            $event->is_public = !is_null($request->isPublic) ? true : false;

            $event->user_id = Auth::id();

            $event->type_id = $request->typeId;
            $event->state_id = $request->stateId;

            $event->save();

            return redirect()->back()->with("status", "Event Updated succcesfully");
        }

        else {
            return redirect()->back()->with("error", "Invalid Requests");
        }
    }

}
