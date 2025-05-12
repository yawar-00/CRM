<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    /**
     * Handle the initial registration step (collecting user data and sending OTP)
     */
    public function register(Request $request)
    {   

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        // Store registration data in session
        Session::put('registration_data', [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        
        // Generate OTP
        $otp = rand(100000, 999999);
        
        // Create a temporary user record with the OTP
        // This will be updated with complete details after verification
        $tempUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);
        
        // Send OTP via email
        Mail::raw("Your registration OTP is: $otp. It will expire in 15 minutes.", function ($message) use ($data) {
            $message->to($data['email'])->subject('Registration OTP Verification');
        });
        
        return redirect()->route('verify.registration.form')->with('email', $data['email']);
    }
    
    /**
     * Show OTP verification form
     */
    public function showVerifyRegistrationForm()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }
        
        $email = Session::get('registration_data')['email'];
        return view('verify-registration', compact('email'));
    }
    
    /**
     * Verify OTP and complete registration
     */
    public function verifyRegistration(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);
        
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }
        
        $email = Session::get('registration_data')['email'];
        $user = User::where('email', $email)->first();
        
        if (
            !$user ||
            $user->otp != $request->otp ||
            !$user->otp_expires_at ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }
        
        // Mark OTP as used and complete registration
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->email_verified_at = now(); // Mark email as verified
        $user->save();
        
        // Clear session data
        Session::forget('registration_data');
        
        return redirect()->route('login')->with('success', 'Registration completed successfully! You can now login.');
    }
    
    /**
     * Resend OTP for registration
     */
    public function resendRegistrationOtp()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }
        
        $email = Session::get('registration_data')['email'];
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return redirect()->route('register');
        }
        
        // Generate new OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(15);
        $user->save();
        
        // Send OTP via email
        Mail::raw("Your registration OTP is: $otp. It will expire in 15 minutes.", function ($message) use ($user) {
            $message->to($user->email)->subject('Registration OTP Verification');
        });
        
        return back()->with('message', 'OTP has been resent to your email address.');
    }
    
    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($data)) {
            // Check if email is verified (has completed OTP verification)
            $user = Auth::user();
            if (!$user->email_verified_at) {
                Auth::logout();
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->otp_expires_at = now()->addMinutes(15);
                $user->save();
                Mail::raw("Your registration OTP is: $otp. It will expire in 15 minutes.", function ($message) use ($data) {
                $message->to($data['email'])->subject('Registration OTP Verification');
            });
             return redirect()->route('verify.registration.form')->with('email', $data['email']);
            }
            return redirect()->route('home');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
    
    /**
     * Handle user logout
     */
    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
    
        return redirect('/login');
    }

    /**
     * Show forgot password form
     */
    public function showForgotForm() {
        return view('forgot-password');
    }

    /**
     * Send OTP for password reset
     */
    public function sendOtp(Request $request) {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email not registered']);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(15);
        $user->save();
        
        // Send OTP via email
        Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Password Reset OTP');
        });
        Session::put('reset_email',$user->email);
        Session::flash('otp_sent', true);
        return redirect()->back()->with('email', $email);
    }

    /**
     * Verify OTP for password reset
     */
    public function verifyOtp(Request $request) {
        $request->validate(['otp' => 'required']);
        $email=Session::get('reset_email');
        $user = User::where('email', $email)->first();

        if (
            !$user ||
            $user->otp !== $request->otp ||
            !$user->otp_expires_at ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            Session::put('reset_email',$user->email);
            Session::flash('otp_sent', true);
            
            return back()->with('email', $email)->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        // Clear OTP
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('reset.form');
    }

    /**
     * Show password reset form
     */
    public function showResetForm() {
        return view('reset-password');
    }

    /**
     * Reset password
     */
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