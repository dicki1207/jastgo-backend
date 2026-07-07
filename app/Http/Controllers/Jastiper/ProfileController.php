<?php

namespace App\Http\Controllers\Jastiper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Jastiper;

class ProfileController extends Controller
{
    public function index()
    {
        $jastiper = Auth::user()->jastiper;
        if (!$jastiper) abort(403, 'Anda bukan jastiper.');

        $rekening = $jastiper->rekening;

        return view('Jastiper.profile.index', compact('jastiper', 'rekening'));
    }

    public function edit()
    {
        $jastiper = Auth::user()->jastiper;
        if (!$jastiper) abort(403, 'Anda bukan jastiper.');

        $rekening = $jastiper->rekening;

        return view('Jastiper.profile.edit', compact('jastiper', 'rekening'));
    }

    public function update(Request $request)
    {
        // ==== VALIDASI ====
        $request->validate([
            'nama_toko'       => 'required|string|max:100',
            'no_hp'           => 'nullable|string|max:30',
            'kota_toko'       => 'required|string|max:100',
            'alamat_toko'     => 'required|string',
            'jangkauan'       => 'nullable|string',
            'tipe_rekening'   => 'nullable|in:bank,e-wallet',
            'nama_penyedia'   => 'nullable|string|max:100',
            'nama_pemilik'    => 'nullable|string|max:100',
            'nomor_akun'      => 'nullable|string|max:50',
            'profile_toko'    => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // 2MB
        ]);

        $jastiper = Auth::user()->jastiper;

        // ==== FOTO PROFIL TOKO ====
        if ($request->hasFile('profile_toko')) {
            // Hapus foto lama kalau ada
            if ($jastiper->profile_toko && Storage::disk('public')->exists($jastiper->profile_toko)) {
                Storage::disk('public')->delete($jastiper->profile_toko);
            }

            // Simpan foto baru
            $path = $request->file('profile_toko')->store('jastipers/profile', 'public');
            $jastiper->profile_toko = $path;

        } elseif ($request->has('hapus_foto')) { // checkbox kirim nilai "on"
            if ($jastiper->profile_toko && Storage::disk('public')->exists($jastiper->profile_toko)) {
                Storage::disk('public')->delete($jastiper->profile_toko);
            }
            $jastiper->profile_toko = null;
        }

        // ==== DATA UTAMA JASTIPER ====
        $jastiper->nama_toko = $request->nama_toko;
        $jastiper->no_hp     = $request->no_hp;
        $jastiper->kota_toko = $request->kota_toko;
        $jastiper->alamat_toko = $request->alamat_toko;
        $jastiper->jangkauan = $request->jangkauan;
        $jastiper->save(); 

        return redirect()
            ->route('jastiper.profile.index')
            ->with('success', 'Profil Jastiper berhasil diperbarui!');
    }
}