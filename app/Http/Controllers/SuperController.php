<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SuperController extends Controller
{

    public function usersPanel()
    {
        return view('super.users');
    }
    
    public function getUsers()
    {
        return User::with('role')->get();
    }

    public function changeRole($user, $role)
    {
        $user = User::find($user);
        $user->role_id = $role;
        $user->save();
        return $user;
    }
}
