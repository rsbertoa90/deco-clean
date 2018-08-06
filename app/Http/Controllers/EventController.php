<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Cart;

use App\Seminar;
use App\Http\Controllers\InscriptionController;

class EventController extends Controller 
{

    public function getBySeminar($id)
    {
        $seminar = Seminar::find($id);
        if ($seminar){
            return $seminar->events;
        }
    }

    public function update(Request $request)
    {
        if(! $request->id){return;}


        // return $request->except('_token');
        $event = Event::find($request->id);
        // return $event->hour;
        $field = trim($request->field);
        
        if ($field == 'date')
        {
            // return $request->value;
            $event->date = Carbon::createFromFormat('Y/m/d',$request->value);
            
        }
      
        else{
      
            $event->$field = $request->value;
        }
        $event->save();
        return $event;
    }


    public function updateCity(Request $request)
    {
        if($request->id && $request->state && $request->city){
            $event = Event::find($request->id);
            $event->state = $request->state;
            $event->city = $request->city;
            $event->save();
        }
    }

    public function updateDate(Request $request)
    {
        if($request->id && $request->date)
        {
            $event = Event::find($request->id);
            $date = Carbon::parse($request->date);
            $date->hour = $event->date->hour;
            $date->minute = $event->date->minute;

            $event->date = $date;
            $event->save();
        
        }
    }

   
   

    public function delete($id)
    {
        $event = Event::find($id);
        $inscriptions = $event->inscriptions;
        $inscriptionController = new InscriptionController();
        foreach ($inscriptions as $i)
        {
            $inscriptionController->delete($i->id);
        }
        $event->delete();
        return;
    }

    public function createForm()
    {
        return view('admin.events.create');
    }


    public function create(Request $request)
    {
        // return $request->all();
        
        $request->validate([
            'seminar_id'=>'required',
            'date' => 'required',
            'hour' => 'required'
            ]);

       
        $data = $request->except('_token');
        // $data->date = Carbon::createFromFormat('Y-m-d',$request->date);

        try{
            $ev = Event::create($data);
            $ev->save();
        }catch(Exception $err){
            return $err;
        };
        
        return $ev;
    }

    public function addToCart($id)
    {
        $event = Event::find($id);
        //$user = auth()->user();
        Cart::add($event,1);
        // Cart::store($user->id);
        return redirect('/');
    }

    public function removeFromCart($id)
    {
        $event = Event::find($id);
        $cartItem = Cart::content()->where('id',$event->id)->first();
        
        //$user = auth()->user();
        
        Cart::remove($cartItem->rowId);
        // Cart::store($user->id);
        return redirect('/');
    }

    public function getAll(){
        return Event::where('date','>=',now())->with('seminar')->with('inscriptions.unregistereduser')->with('inscriptions.payments')->get();
    }



    public function getSeminarName($id)
    {
        if($id){
            $seminar = Seminar::find($id);
            return array($id);
        }
    }

    public function futureBySeminar($id)
    {
        $seminar = Seminar::find($id);
        return $seminar->futureEvents();
    }

    public function getByCity($city){
        return Event::with('seminar')->where('date','>=', now())->where('city',$city)->get();
    }

    public function getOnlineEvents()
    {
        return Event::with('seminar')->where('date','>=', now())->where('mode','online')->get();
    }

}
