<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
use App\Event;

class CityController extends Controller
{
    public function countrys()
    {
        $countrys = [
            'argentina', 'brasil','chile','uruguay','paraguay'
        ];

        return $countrys->toJson();
    }

    public function states()
    {
        return State::with('cities')->get();
    }
    public function cities()
    {
        return City::with('state')->get();
    }

    public function citiesFrom($state)
    {
        $state = State::find($state);
        return $state->cities;
    }

    public function getActiveCitys(){
        $citys = Event::where('date','>=', now()
            )->where('city','<>','')->groupBy('city');
        // $citys->pluck('city');
        return $citys->pluck('city');
    }
}
