<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SecureResetPasswordController extends Controller
{
    public function form()
    {
        return view('lupa-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        \Illuminate\Support\Facades\Log::info("OTP Lupa Password untuk {$user->email}: {$otp}");
        
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ResetPasswordMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal mengirim email OTP: " . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email. Pastikan konfigurasi SMTP benar.');
        }

        return redirect()->route('lupa.password.verify.form')
            ->with('reset_email', $user->email)
            ->with('success', 'Kode OTP telah dikirim ke email Anda! Silakan cek kotak masuk.');
    }

    public function verifyForm()
    {
        return view('lupa-password-verify');
    }

    public function reset(Request $request)
    {
        // Validasi
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.exists' => 'Email tidak terdaftar',
            'password.confirmed' => 'Konfirmasi password tidak sama',
        ]);

        // Cari user
        $user = User::where('email', $request->email)->first();

        // Validasi OTP
        if ($user->otp_code !== $request->otp_code) {
            return back()->with('error', 'Kode OTP salah!')->with('reset_email', $request->email);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'Kode OTP kadaluwarsa! Silakan minta ulang.')->with('reset_email', $request->email);
        }

        // Update password & hapus OTP
        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}
