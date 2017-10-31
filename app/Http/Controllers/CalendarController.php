<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        Calendar::create($request->all());
        return redirect()->route('calendars.index');
    }
}
