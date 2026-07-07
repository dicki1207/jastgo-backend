<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048' // max 2MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->getRawOriginal('avatar')) {
                Storage::disk('public')->delete($user->getRawOriginal('avatar'));
            }

            $file = $request->file('avatar');
            $filename = 'avatar_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $filename, 'public');

            $user->avatar = $path;
            $user->save();
        }

        return back()->with('success', 'Avatar berhasil diperbarui.');
    }
}
