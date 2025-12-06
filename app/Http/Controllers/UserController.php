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
            'Username' => 'required',
            'Password' => 'required'
        ]);

        if (auth()->attempt(['name' => $Incoming['Username'],'password' => $Incoming['Password']])){
            $user = auth()->user();
            if ($user->admin == 1) {
            auth()->logout(); // log them out immediately
            return back()->withErrors([
                'Username' => 'Admins cannot login here.'
            ])->withInput();
            }
            $request->session()->regenerate();
            return redirect('/dashboard');
        }
        return back()->withErrors([
        'Password' => 'Incorrect username or password.'
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

        $Incoming['maintenance'] = $request->has('is_maintenance') ? 1 : 0;

        $Incoming['password'] = bcrypt($Incoming['password']);
        $user = User::create($Incoming); /*add the datas in the database*/
        auth()->login($user);

        if ($Incoming['admin'] == 1) {
            return redirect()->route('admindash');
        } elseif ($Incoming['maintenance'] == 1) {
            return redirect()->route('maintenance');
        } else {
            return redirect()->route('dashboard');
        }
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

        
        } else if ($user->maintenance == 1) {
            $request->session()->regenerate();
            return redirect('/maintenancedash');
        
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'contact_number' => 'nullable|string|max:50',
            'tel_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255', // username
            'nationality' => 'nullable|string|max:255',
            'room_no' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'date_of_birth' => $request->date_of_birth,
            'contact_number' => $request->contact_number,
            'tel_number' => $request->tel_number,
            'address' => $request->address,
            'email' => $request->email,
            'name' => $request->name,
            'nationality' => $request->nationality,
            'room_no' => $request->room_no,
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

} 
