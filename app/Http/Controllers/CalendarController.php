<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Calendar;
class CalendarController extends Controller
{
    public function index()
    {
        $calendar = Calendar::all();
//        return response()->json([
//            'event' => $calendar
//        ]);
   return view('calendars.index', compact('calendar'));
    }

    public function get()
    {
        $calendar = Calendar::all();

        return $calendar;
//        return response()->json([
//            'event' => $calendar
//        ]);

    }

    public function create()
    {
        return view('calendars.create');
    }

    public function store(Request $request)
    {

        $request=Request::all();

        $calendar=Calendar::create(["name"=>$request["name"],"description"=>$request["des"],"task_date"=>$request["dt"]]);
        $c=Calendar::all();
        return $c;
//        return redirect()->route('calendars.index')
//                         ->with('success','Task Created Successfully');
    }

    public function update()
    {
        $request=Request::all();
// return $request;
        $event =Calendar::find($request['id']);
        $event->name = $request["name"];
        $event->description = $request["des"];
        $event->task_date = $request["dt"];
        $event->save();

        $c=Calendar::all();
        return $c;
    }

    public function drop(){
        $request=Request::all();
        $event =Calendar::find($request['id']);
        $event->task_date = $request["dt"];
        $event->save();

        $c=Calendar::all();
        return $c;

    }

    public function destroy()
    {
        $request=Request::all();
//        dd(Request::all());
        Calendar::destroy($request['id']);
        $c=Calendar::all();
        return $c;
//        return redirect()->route('index')
//            ->with('success','Task Deleted Successfully');
    }
}
