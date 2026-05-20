<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $otp = (string) random_int(100000, 999999);

        $request->session()->put('pending_registration', [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10)->toDateTimeString(),
        ]);

        Mail::raw("Your Satya Interiors registration OTP is {$otp}. It expires in 10 minutes.", function ($message) use ($data) {
            $message->to($data['email'])->subject('Satya Interiors registration OTP');
        });

        return redirect()->route('register.otp')->with('status', 'We sent a 6 digit OTP to your email. Verify it to create your account.');
    }

    public function showRegistrationOtp(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('pending_registration')) {
            return redirect()->route('register')->withErrors(['email' => 'Start registration first to receive an OTP.']);
        }

        return view('auth.verify-otp', [
            'email' => $request->session()->get('pending_registration.email'),
        ]);
    }

    public function verifyRegistrationOtp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $pending = $request->session()->get('pending_registration');

        if (! $pending || now()->greaterThan($pending['expires_at'])) {
            $request->session()->forget('pending_registration');

            return redirect()->route('register')->withErrors(['otp' => 'OTP expired. Please register again.']);
        }

        if (! Hash::check($data['otp'], $pending['otp_hash'])) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please check your email and try again.']);
        }

        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'password' => $pending['password'],
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $request->session()->forget('pending_registration');
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('shop')->with('status', 'Account verified and created. You can place orders now.');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showAdminLogin(): View
    {
        return view('auth.admin-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('shop'));
    }

    public function adminLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'The provided admin credentials do not match our records.'])->onlyInput('email');
        }

        if (! Auth::user()?->is_admin) {
            Auth::logout();

            return back()->withErrors(['email' => 'This account is not allowed to access the admin panel.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->to('/admin');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
