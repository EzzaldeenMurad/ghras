<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:seller,buyer,consultant',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Generate verification code
        $verificationCode = sprintf("%05d", mt_rand(0, 99999));

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->account_type,
            'verification_code' => $verificationCode,
            'email_verified_at' => null,
        ]);

        // Send verification email
        // Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));
        Auth::login($user);
        // Store user ID in session for verification
        session(['user_id_for_verification' => $user->id]);

        // return redirect()->route('verification.show');
        return redirect()->route('home')->with('success', 'تم إنشاء الحساب بنجاح');
    }

    /**
     * Show verification code form
     */
    public function showVerificationForm()
    {
        if (!session('user_id_for_verification')) {
            return redirect()->route('register');
        }

        return view('auth.verification-code');
    }

    /**
     * Verify user's email with code
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $userId = session('user_id_for_verification');
        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::findOrFail($userId);
        $code = implode('', $request->code);

        if ($user->verification_code === $code) {
            $user->email_verified_at = now();
            $user->save();

            session()->forget('user_id_for_verification');

            return redirect()->route('verification.success');
        }

        return redirect()->back()->withErrors(['code' => 'رمز التحقق غير صحيح']);
    }

    /**
     * Show verification success page
     */
    public function showVerificationSuccess()
    {
        return view('auth.success-verification');
    }
}
