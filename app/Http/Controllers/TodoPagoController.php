<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TodoPago;


class TodoPagoController extends Controller
{
    public function tp()
    {
        $optionsSAR_comercio = array (
        'Security' =>  '1234567890ABCDEF1234567890ABCDEF', //API Key
        'EncodingMethod'=> 'XML',
        'Merchant'=>  123456, //Número identificador del comercio
        'URL_OK' =>  'exito.php?operationid=123456', //Redirección en caso de transacción aprobada
        'URL_ERROR' =>  'error.php?operationid=123456' //Redirección en caso de transacción rechazada
        );
        
        $optionsSAR_operacion = array(
        'MERCHANT'=>  123456, //Número identificador del comercio
        'OPERATIONID' =>  '123456', //Número único que identifica la operación 'CURRENCYCODE' = 32, //Identificador de moneda
        'AMOUNT'=>  5.00, //Monto a cobrar
        'EMAILCLIENTE'=> 'email_cliente@dominio.com',
        );


        $http_header = array('Authorization'=>'TODOPAGO 0129b065cfb744718166913eba827a2f',
                              'user_agent' => 'PHPSoapClient');

        $connector = new Sdk($http_header, "test");
    }
}
