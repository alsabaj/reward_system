<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('name', 'asc')->get();

        return view('users.index', compact('users'));
    }

    public function create(Request $request){
        $users = User::orderBy('id', 'desc')->get();

        return view('users', compact('users'));
    }

    public function rewards($user_id, Request $request)
    {

        $user = User::findOrFail($user_id);
        $rewards = $user->rewards()->orderBy('id', 'desc')->get();

        return view('users.rewards',compact('rewards', 'user'));
    }
}
