@extends('layouts.app')

@section('content')

    <app-checkout list="{{ json_encode($list) }}"> 
    </app-checkout>
@endsection