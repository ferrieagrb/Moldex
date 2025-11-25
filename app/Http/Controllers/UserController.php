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
            $user = auth()->user();
            if ($user->admin == 1) {
            auth()->logout(); // log them out immediately
            return back()->withErrors([
                'loginname' => 'Admins cannot login here.'
            ])->withInput();
            }
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

    public function adminlogout(){
        auth()->logout();   
        return redirect('/adminlogin');
    }

    public function showRegisterForm()
{
    return view('register'); // Blade file with the form
}

    public function register(Request $request){
        $Incoming /* variable */ = $request->validate([
            'name' => ['required','min:3', 'max:10', Rule::unique('users','name')],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => ['required', 'min:8', 'max:15']
        ]);

        $Incoming['admin'] = $request->has('is_admin') ? 1 : 0;

        $Incoming['password'] = bcrypt($Incoming['password']);
        $user = User::create($Incoming); /*add the datas in the database*/
        auth()->login($user);
        return redirect('/dashboard');
            
    }

    public function adminLogin(Request $request)
{
    $credentials = $request->validate([
        'loginname' => 'required',
        'loginpassword' => 'required'
    ]);

    // Attempt login
    if (auth()->attempt(['name' => $credentials['loginname'], 'password' => $credentials['loginpassword']])) {

        $user = auth()->user(); // Get the logged-in user

        // Check if admin column is 1
        if ($user->admin == 1) {
            $request->session()->regenerate();
            return redirect('/admindash');
        } else {
            auth()->logout(); // Logout if not admin
            return back()->withErrors([
                'loginname' => 'You do not have admin access.'
            ])->withInput();
        }
    }

    // Invalid credentials
    return back()->withErrors([
        'loginpassword' => 'Incorrect username or password.'
    ])->withInput();
}

} 
