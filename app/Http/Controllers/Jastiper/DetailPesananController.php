<?php

namespace App\Http\Controllers\Jastiper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Barang;

class DetailPesananController extends Controller
{

    protected function getJastiperId()
    {
        if (!Auth::check()) {
            abort(403, 'Akses ditolak: Anda harus login.');
        }

        $user = Auth::user();

        $jastiperId = $user->jastiper->id ?? null;

        if (!$jastiperId) {
            abort(403, 'Akses ditolak: Anda bukan terdaftar sebagai Jastiper.');
        }

        return $jastiperId;
    }
    public function index(Request $request)
    {
        $jastiperId = $this->getJastiperId();

        $pesananIds = Pesanan::where('jastiper_id', $jastiperId)
            ->pluck('id');

        $query = DetailPesanan::with(['pesanan', 'barang'])
            ->whereIn('pesanan_id', $pesananIds);
            
        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('pesanan_id', $search)
                  ->orWhereHas('barang', function($qBarang) use ($search) {
                      $qBarang->where('nama_barang', 'like', '%' . $search . '%');
                  });
            });
        }

        $detailPesanans = $query->paginate(15)->appends(['q' => $request->q]);

        return view('Jastiper.detail_pesanan.index', compact('detailPesanans'));
    }


  

}
