<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UnregisteredUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function user()
    {
        $user = Auth::user();
        return User::with('role')->find($user->id);         
    }

    public function getLoggedUser()
    {
        $user = Auth::user();
        if ($user){
            return $user;
        }
        else return null;

    }

    public function getUnregistered($id)
    {
        return UnregisteredUser::with('inscriptions.event.seminar')->find($id);
    }
}
