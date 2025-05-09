<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
        // dd($request);
        $data= $request->validate([
            'name'=> 'required',
            'email'=>'email|required',
            'password'=>'required|confirmed',
        ]);
        // dd($data);
        $user = User::create($data);
        if($user){
            return redirect()->route('login');
        }
    }
    public function login(Request $request){
        $data= $request->validate([
            'email'=>'email|required',
            'password'=>'required',
            
        ]);
        if(Auth::guard('web')->attempt($data)){
            return redirect()->route('home');
        }
    }
    public function logout(Request $request){
        // dd($request);

        Auth::guard('web')->logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
    
        return redirect('/login');
    }


    public function showForgotForm() {
        return view('forgot-password');
    }

    public function sendOtp(Request $request) {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        // dd($user->email);
        if (!$user) {
            return back()->withErrors(['email' => 'Email not registered']);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(15);
        $user->save();
        // dd('success');
        // Send OTP via email
        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Password Reset OTP');
        });
        Session::put('reset_email',$user->email);
        // dd(Session::get('reset_email'));
        Session::flash('otp_sent', true);
        return redirect()->back()->with('email', $email);
    }

    public function verifyOtp(Request $request) {
        $request->validate(['otp' => 'required']);

        $user = User::where('email', Session::get('reset_email'))->first();

        if (
            !$user ||
            $user->otp !== $request->otp ||
            !$user->otp_expires_at ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        // Clear OTP
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('reset.form');
    }

    public function showResetForm() {
        return view('reset-password');
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', Session::get('reset_email'))->first();
        if (!$user) {
            return redirect()->route('forgot.form')->withErrors(['email' => 'Something went wrong']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Session::forget('reset_email');
        return redirect()->route('login')->with('message', 'Password reset successfully!');
    }

}
