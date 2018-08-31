<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;


class MPController extends Controller
{
    public static function init()
    {
        MercadoPago\SDK::setClientId("5911500288474745");
        MercadoPago\SDK::setClientSecret("fGIYRF1djkqY8CvLaLVuVj0b7FFbsdja");
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
        $payer->email = "dino.kertzmann@gmail.com";
        # Setting preference properties
        $preference->items = array($item);
        $preference->payer = $payer;
        # Save and posting preference
        $preference->save();

        return redirect($preference->init_point);
    }

    public function getResponse(Request $request)
    {
        return response('ok',200);
    }
}
