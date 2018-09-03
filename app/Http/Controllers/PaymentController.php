<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Cart;
use App\Event;
use MercadoPago;
use MP;
use MercadoPago\item;
use App\Payment;
use App\PaymentType;
use App\Inscription;
use App\UnregisteredUser;
use App\User;


class PaymentController extends Controller
{
    

    public function checkout(Request $request)
    {
        $rlist = json_decode($request->list);
        $list =[];
        $user = Auth::user();
        foreach ($rlist as $item)
        {
            $list[]=$item->id;
            Inscription::create([
                'user_type'=>'registered',
                'user_id'=> $user->id,
                'event_id'=>$item->id,
            ]);
        }
        return view('checkout',compact('list'));
    }


    public function index()
    {
        $user = auth()->user();
        $cartItems = Cart::content();
        $events = [];
        foreach($cartItems as $item)
        {
            $events[$item->id] = Event::find($item->id);
        }
        $events=collect($events);
        if(!$user){return redirect('/register');}
        return view('user.payments',compact('user','cartItems','events'));
    }
    
    public function userForm()
    {
        if(!Auth::check()){
            return redirect('/');
        }
        else {
            $user = Auth::user();
            return view('user.register-payment',compact('user'));
        }
    }
    
  
   

    public function create(Request $request)
    {
        
        if ($request->method == 'transferencia'){
            $this->handleTransferPayment($request);
        }
        else if ($request->method == 'mercadopago'){
           $preference = MPController::pay($request);
           $payment = Payment::create([
               'method'=>'mercadopago',
               'amount'=>$request->total,
               'status'=>'waiting'
            ]);
            $list = json_decode($request->list);
            foreach ($list as $id)
            {
                $payment->attach(Event::find($id));
            }
            $payment->save();
           return redirect($preference->init_point);
        }

    }

    public function inscriptions(){
        $events = Event::future('presencial');
        return view('admin/inscriptions',compact('events'));
    }

    
    public function types(){
        return PaymentType::all()->pluck('name');
    }

    public function unregisteredPayment(Request $request)
    {
        // return $request->except('_token');
        // Traje un array de id's de inscripciones.traigo los objetos
        $inscriptions = Inscription::find($request->inscriptions);
        // Actuallizo el mail del usuario
        if ($request->email){
            $user  = $inscriptions[0]->unregisteredUser;
            $user->email = $request->email;
            $user->save();
        }
        // guardo los datos del pago
        $payment = new Payment();
        $payment->amount = $request->amount;
        $payment->ticket = $request->ticket;
        $payment->type = $request->type;
        $payment->comments = $request->comments;
        $payment->status ="revision";

        if ($payment->type == 'saldo a favor'){
            $payment->status = 'confirmado' ;
        }

        $payment->save();
        $payment->inscriptions()->sync($inscriptions);

        // le asigno a las incripciones el monto que les corresponde del pago
        $total = $request->total;
        // dd($request->except('_token'));
        foreach ($inscriptions as $insc){
             $insc->recalculatePayd();
        }
        
    }   

    public function getByUnRUser($user){
        $result = Payment::with('inscriptions.event.seminar')->whereHas('inscriptions', function($query) use($user){
            $query->where('unregistered_user_id',$user);
        })->orderBy('created_at','desc')->get();
        return $result;
    }

    public function changeStatus(Request $request)
    {   
       
        $payment = Payment::find($request->payment);
        $payment->status = $request->status;
        $payment->save();

        if ($payment->status == 'cancelado'){
         return  $payment->cancel() ;
        }
    }
}
