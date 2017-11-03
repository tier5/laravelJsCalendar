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
//        dd(Request::all());
        $request=Request::all();
        Calendar::find($request["id"])->update(["name"=>$request["updateTaskName"],"description"=>$request["updateDescription"],"task_date"=>$request["updateTaskDate"]]);

        return redirect()-> route('calendars.index')
                         ->with('success','Task Updated Successfully');
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
