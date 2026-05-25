<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SecureResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        // Validasi
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.exists' => 'Email tidak terdaftar',
            'password.confirmed' => 'Konfirmasi password tidak sama',
        ]);

        // Cari user
        $user = User::where('email', $request->email)->first();

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login.');
    }
}
