<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function inscriptionInterface(){
        return view('admin.inscriptions');
    }

    public function crudInterface(){
        return view('admin.crud');
    }
}
