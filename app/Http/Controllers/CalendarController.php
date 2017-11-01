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

        return view('calendars.index', compact('calendar'));
    }

    public function create()
    {
        return view('calendars.create');
    }

    public function store()
    {
        $request=Request::all();
        Calendar::create(["name"=>$request["taskName"],"description"=>$request["description"],"task_date"=>$request["taskDate"]]);
        return redirect()->route('calendars.index')
                         ->with('success','Task Created Successfully');
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
        return redirect()->route('calendars.index')
            ->with('success','Task Deleted Successfully');
    }
}
