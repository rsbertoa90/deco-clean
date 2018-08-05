<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    //
    public function inscriptionInterface(){
        return view('admin.inscriptions');
    }

    public function crudInterface(){
        return view('admin.crud');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
