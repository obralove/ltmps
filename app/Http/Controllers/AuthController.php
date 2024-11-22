<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
       
        $request->validate([
            'email' => 'required|string|email',  
            'password' => 'required|string',
        ]);
    
       
        $user = User::where('email', $request->email)->first();
    
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['Invalid Credentials']);
        }
    
        
        Auth::login($user);
        return redirect('/livestocks');
    }


  
    public function apiLogin(Request $request)
    {
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        
        $token = $user->createToken('API Token')->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }



    
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

   
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);

    return redirect('/login');
}

    // Handle Forgot Password
    public function forgotPassword(){
        return view('auth.passwords.reset');
    }

    // Send Email
    public function sendEmailPassword(Request $request) {
        $request->validate([
            'email' => ['email', 'exists:users,email']
        ]);

        $user = User::where('email', $request->email)->first();
        $password = Str::random(6);

        Mail::to($request->email)->send(new ForgotPasswordMail($request->email, $password));

        $user->update([
            'password' => Hash::make($password)
        ]);

        session()->flash('success', 'Email sent! Please check email.');
        return view('auth.passwords.reset');
    }
}
