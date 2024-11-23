<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
        ]);

       $user = new User();
       $user->full_name=$attributes['name'];
       $user->email=$attributes['email'];
       $user->password=$attributes['password'];
       $user->save();
        auth()->login($user);
       // dd($attributes);
        
        return redirect('/dashboard');
    } 
}
