<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;
use App\Payment;
use App\Event;
use Auth;
use App\User;
class MPController extends Controller
{
    public static function init()
    {
        MercadoPago\SDK::setClientId("6176449208003945");
        MercadoPago\SDK::setClientSecret("mlv1QPapkc6AACeZ19X9OBB4apRQeSAg");
        MercadoPago\SDK::setAccessToken("TEST-6176449208003945-083118-de0bc124b116addfb9faf597bebcc116-281069766");

    }

    

    public static function pay($request = null)
    {

        MercadoPago\SDK::setClientId("6176449208003945");
        MercadoPago\SDK::setClientSecret("mlv1QPapkc6AACeZ19X9OBB4apRQeSAg");
        
        $user = Auth::user();
        $preference = new MercadoPago\Preference();
        # Create an item object
        $itemsArray =[];
        $recargo = 0;
        foreach(json_decode($request->list) as $li)
        {
            $event = Event::find($li);
            $item = new MercadoPago\Item();
            $item->id = $event->id;
            $item->title = $event->seminar->title;
            $item->quantity = 1;
            $item->currency_id = "ARS";
            $item->unit_price = $event->price;
            if($request->half){
                $item->unit_price /= 2;
                $item->title += '-seña';
            }
            $recargo+= $item->unit_price * 0.1;
            $itemsArray[] =$item;
        }

        /* Recargo mercadopago */
          $item = new MercadoPago\Item();
          $item->id=9999;
          $item->title="Recargo por uso de Mercadopago";
          $item->quantity = 1;
          $item->currency_id = "ARS";
          $item->unit_price = $recargo;
          $itemsArray[] =$item;

        # Create a payer object
        $payer = new MercadoPago\Payer();
        $payer->email = $user->email;
        # Setting preference properties
       
        $preference->items = $itemsArray;
        $preference->payer = $payer;
        # Save and posting preference
        $preference->save();

        return $preference;
    }

    public function getResponse(Request $request)
    {
        MercadoPago\SDK::setAccessToken("TEST-6176449208003945-083118-de0bc124b116addfb9faf597bebcc116-281069766");
        if (isset($request->topic) && $request->topic == 'payment')
        {
            $id = $request->id;
            $payment = Payment::create([
                'type'=>'mercadopago',
                'transaction_id'=>$id,
                'comments'=>'Callback entra']);
            
            $mpPay = MercadoPago\Payment::find_by_id($id);
            if ($mpPay['status'] == 'approved')
            {
                $payment->status = 'confirmado';
                $payment->amount = $mpPay['transaction_amount']; 
                $payment->comments = json_encode($mpPay);
                $user = User::where('email',$mpPay['payer']['email'])->get()->first();
                $inscription = $user->inscriptions;
                foreach ($inscriptions as $i)
                {
                  foreach( $i->payments as $p)
                  {
                    if ($p->status == 'waiting')
                    {
                        $p->status = 'confirmado';
                        $p->save();
                    }
                  }

                }

            }
        }
        
        return response()->json(['success'=>true],200);

    }
}
