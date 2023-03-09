<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Traits\EventTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    use GeneralTrait, EventTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $events = Event::with(['user'])->get();
        return view('home', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'subject' => 'required|min:5',
            'attendees' => 'required',
            'date' => 'required',
        ], [
            'subject.required' => 'Subject is must.',
            'subject.min' => 'Name must have 5 char.',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }
        $this->createEventOnGoogleCalendar($request->except('_token'));
        // $validateEmails = $this->validateEmail($request->get('attendees'));
        // $data = $request->all();
        Event::create($validate);
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        // WIP : Work In Progress
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        // WIP : Work In Progress
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        // WIP : Work In Progress
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id)->delete();
            return redirect()->back()->with('message', __("Resource has been deleted successfully"));
        } catch (\Exception $e) {
            return back()->withErrors(['Unable to find resource']);
        }
    }
}
