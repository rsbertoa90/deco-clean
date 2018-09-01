<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;
use App\Payment;

class MPController extends Controller
{
    public static function init()
    {
        MercadoPago\SDK::setClientId("6176449208003945");
        MercadoPago\SDK::setClientSecret("mlv1QPapkc6AACeZ19X9OBB4apRQeSAg");
        MercadoPago\SDK::setAccessToken("TEST-6176449208003945-083118-de0bc124b116addfb9faf597bebcc116-281069766");

    }

    public function pay()
    {
        self::init();

        
        $preference = new MercadoPago\Preference();
        # Create an item object
        $item = new MercadoPago\Item();
        $item->id = "1234";
        $item->title = "Sleek Rubber Bag";
        $item->quantity = 1;
        $item->currency_id = "ARS";
        $item->unit_price = 1800.25;
        # Create a payer object
        $payer = new MercadoPago\Payer();
        $payer->email = "test_user_62611257@testuser.com";
        # Setting preference properties
        $preference->items = array($item);
        $preference->payer = $payer;
        # Save and posting preference
        $preference->save();

        return $preference->init_point;
    }

    public function getResponse(Request $request)
    {
        Payment::create(['type'=>'mercadopago','comments'=>'Callback entra']);
        
        return response()->json(['success'=>true],200);

    }
}
