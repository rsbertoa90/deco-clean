<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
// use Carbon\Carbon;
class SeminarController extends Controller
{
    public function getAll()
    {
        return Seminar::with('events.inscriptions')->get();
    }

    public function edit(Request $request){
        $field = $request->field;
        $seminar = Seminar::find($request->seminarId);
        $seminar->$field = $request->value;
        $seminar->save();

    }

    public function delete($id)
    {
        $seminar = Seminar::find($id);
        foreach($seminar->events as $event){
            $event->delete();
        }
        $seminar->delete();
    }

    public function create(Request $request)
    {
        $seminar = Seminar::create($request->only('title','description'));
        return $seminar;
    }
}
