<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request, $pesananId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
            'foto_ulasan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pesanan = Pesanan::where('id', $pesananId)
                          ->where('user_id', Auth::id())
                          ->where('status_pesanan', 'SELESAI')
                          ->firstOrFail();

        if ($pesanan->has_reviewed) {
            return back()->with('error', 'Pesanan ini sudah diulas.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto_ulasan')) {
            $fotoPath = $request->file('foto_ulasan')->store('ulasans', 'public');
        }

        $ulasan = Ulasan::create([
            'pesanan_id' => $pesanan->id,
            'user_id' => Auth::id(),
            'jastiper_id' => $pesanan->jastiper_id, 
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'foto_ulasan' => $fotoPath,
            'tanggal_ulasan' => now(),
        ]);

        $pesanan->has_reviewed = true;
        $pesanan->save();

        // Update rating Jastiper
        if ($pesanan->jastiper_id) {
            $jastiper = \App\Models\Jastiper::find($pesanan->jastiper_id);
            if ($jastiper) {
                $avgRating = \App\Models\Ulasan::where('jastiper_id', $jastiper->id)->avg('rating');
                $jastiper->rating = $avgRating;
                $jastiper->save();
            }
        }

        return back()->with('success', 'Ulasan Anda berhasil disimpan!');
    }
}