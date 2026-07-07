<?php

namespace App\Http\Controllers\Jastiper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\User;
use App\Models\ValidasiProduk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $jastiper = $user->jastiper; 
        $q = $request->query('q');

        if (!$jastiper) {
            $query = Barang::with(['kategori'])->orderBy('created_at', 'desc');
        } else {
            $query = Barang::where('jastiper_id', $jastiper->id)
                ->with(['kategori'])
                ->orderBy('created_at', 'desc');
        }

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('nama_barang', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        $barangs = $query->paginate(15)->withQueryString();

        $isJastiper = $jastiper ? true : false;

        return view('Jastiper.barang.index', compact('barangs', 'q', 'isJastiper'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('Jastiper.barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user = User::find($user->id);
        $jastiper = $user->jastiper;

        if (!$jastiper)
            abort(403, 'Anda belum terdaftar sebagai jastiper.');

        $data = $request->validate([
            'kategori_id' => 'nullable|exists:kategoris,id',
            'nama_barang' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'is_available' => ['required', Rule::in(['yes', 'no'])],
            'foto_barang' => 'nullable|image|max:2048',
            'foto_barang_2' => 'nullable|image|max:2048',
            'foto_barang_3' => 'nullable|image|max:2048',
            'tanggal_input' => 'nullable|date',
        ]);

        $data['jastiper_id'] = $jastiper->id;

        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = $request->file('foto_barang')->store('barangs', 'public');
        }
        if ($request->hasFile('foto_barang_2')) {
            $data['foto_barang_2'] = $request->file('foto_barang_2')->store('barangs', 'public');
        }
        if ($request->hasFile('foto_barang_3')) {
            $data['foto_barang_3'] = $request->file('foto_barang_3')->store('barangs', 'public');
        }

        $barang = Barang::create($data);


        return redirect()->route('jastiper.barang.index')->with('success', 'Barang berhasil ditambahkan dan menunggu validasi admin.');
    }

    public function edit(Barang $barang)
    {
        $user = Auth::user();
        $jastiper = $user->jastiper;
        if (!$jastiper || $barang->jastiper_id !== $jastiper->id) {
            abort(403, 'Akses ditolak.');
        }

        $kategoris = Kategori::orderBy('nama')->get();
        return view('Jastiper.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $user = Auth::user();
        $jastiper = $user->jastiper;
        if (!$jastiper || $barang->jastiper_id !== $jastiper->id) {
            abort(403, 'Akses ditolak.');
        }

        $data = $request->validate([
            'kategori_id' => 'nullable|exists:kategoris,id',
            'nama_barang' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'is_available' => ['required', Rule::in(['yes', 'no'])],
            'foto_barang' => 'nullable|image|max:2048',
            'foto_barang_2' => 'nullable|image|max:2048',
            'foto_barang_3' => 'nullable|image|max:2048',
            'tanggal_input' => 'nullable|date',
        ]);

        // Proses remove foto
        if ($request->remove_foto) {
            if ($barang->foto_barang && Storage::disk('public')->exists($barang->foto_barang)) {
                Storage::disk('public')->delete($barang->foto_barang);
            }
            $data['foto_barang'] = null;
        }
        if ($request->remove_foto_2) {
            if ($barang->foto_barang_2 && Storage::disk('public')->exists($barang->foto_barang_2)) {
                Storage::disk('public')->delete($barang->foto_barang_2);
            }
            $data['foto_barang_2'] = null;
        }
        if ($request->remove_foto_3) {
            if ($barang->foto_barang_3 && Storage::disk('public')->exists($barang->foto_barang_3)) {
                Storage::disk('public')->delete($barang->foto_barang_3);
            }
            $data['foto_barang_3'] = null;
        }

        // Proses upload foto baru
        if ($request->hasFile('foto_barang')) {
            if ($barang->foto_barang && Storage::disk('public')->exists($barang->foto_barang)) {
                Storage::disk('public')->delete($barang->foto_barang);
            }
            $data['foto_barang'] = $request->file('foto_barang')->store('barangs', 'public');
        }
        if ($request->hasFile('foto_barang_2')) {
            if ($barang->foto_barang_2 && Storage::disk('public')->exists($barang->foto_barang_2)) {
                Storage::disk('public')->delete($barang->foto_barang_2);
            }
            $data['foto_barang_2'] = $request->file('foto_barang_2')->store('barangs', 'public');
        }
        if ($request->hasFile('foto_barang_3')) {
            if ($barang->foto_barang_3 && Storage::disk('public')->exists($barang->foto_barang_3)) {
                Storage::disk('public')->delete($barang->foto_barang_3);
            }
            $data['foto_barang_3'] = $request->file('foto_barang_3')->store('barangs', 'public');
        }

        $barang->update($data);
        return redirect()->route('jastiper.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $user = Auth::user();
        $jastiper = $user->jastiper;
        if (!$jastiper || $barang->jastiper_id !== $jastiper->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($barang->foto_barang && Storage::disk('public')->exists($barang->foto_barang)) {
            Storage::disk('public')->delete($barang->foto_barang);
        }
        if ($barang->foto_barang_2 && Storage::disk('public')->exists($barang->foto_barang_2)) {
            Storage::disk('public')->delete($barang->foto_barang_2);
        }
        if ($barang->foto_barang_3 && Storage::disk('public')->exists($barang->foto_barang_3)) {
            Storage::disk('public')->delete($barang->foto_barang_3);
        }
        
        $barang->delete();

        return redirect()->route('jastiper.barang.index')->with('success', 'Barang dihapus.');
    }
}
