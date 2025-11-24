<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request){
        $Incoming = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['name' => $Incoming['loginname'],'password' => $Incoming['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/dashboard');
        }
        return back()->withErrors([
        'loginpassword' => 'Incorrect username or password.'
        ])->withInput();
    }

    public function logout(){
        auth()->logout();   
        return redirect('/');
    }

    public function register(Request $request){
        $Incoming /* variable */ = $request->validate([
            'name' => ['required','min:3', 'max:10', Rule::unique('users','name')],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => ['required', 'min:8', 'max:15']
        ]);

        $Incoming['password'] = bcrypt($Incoming['password']);
        $user = User::create($Incoming); /*add the datas in the database*/
        auth()->login($user);
        return redirect('/');
    }

} 
