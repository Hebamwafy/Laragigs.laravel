<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class userController extends Controller
{
    //show Register create form 
   public function create()
   {
    return view('users.register');
   }

   //create the new user
   public function store(request $request)
   {
        $formFields=$request->validate([
            'name'=>['required', 'min:3'],
            'email'=>['required','email' ,Rule::unique('users')],
            'password'=>'required|confirmed|min:6',
        ]);
        //hash password 
        $formFields['password'] =bcrypt($formFields['password']);
        $user= User::create($formFields);
        auth()->login($user);
        return redirect('/');
   }

   public function logout(request $request)
   {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
   }

   public function login()
   {
    return view('users.login');
   }
   public function authenticate(request $request)
   {
    $formFields=$request->validate([
        'email'=>['required','email'],
        'password'=>'required',
    ]);
    if (auth()->attempt($formFields))
    {
        $request->session()->regenerate();

        return redirect ('/');
    }
    return back()->withErrors(['email'=>'Invalid credentials'])->onlyInput('email');

   }
}
