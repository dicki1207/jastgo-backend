<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jastiper;

class TokoController extends Controller
{
    /**
     * Halaman Kunjungi Toko (ala Shopee)
     */
    public function show($id)
    {
        // Ambil data toko + produk
        $toko = Jastiper::with('barangs')
            ->withCount('barangs')
            ->findOrFail($id);

        return view('user.toko.show', compact('toko'));
    }
}
