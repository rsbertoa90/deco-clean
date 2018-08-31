@extends('layouts.app')

@section('content')
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <app-checkout list="{{ json_encode($list) }}"> 
    </app-checkout>
@endsection