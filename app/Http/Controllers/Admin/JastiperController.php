<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jastiper;
use App\Models\User;
use App\Models\Rekening; 

class JastiperController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        
        $query = Jastiper::with(['user', 'rekening'])->orderBy('id', 'desc');
        
        if ($q) {
            $query->where(function($w) use ($q) {
                $w->where('id', $q)
                  ->orWhere('nama_toko', 'like', "%{$q}%")
                  ->orWhereHas('user', fn($u) => $u->where('username', 'like', "%{$q}%")->orWhere('name', 'like', "%{$q}%"));
            });
        }
        
        $jastipers = $query->paginate(15)->withQueryString();
        
        return view('admin.jastiper.index', compact('jastipers', 'q'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $rekenings = Rekening::orderBy('nama_bank')->get();
        
        return view('admin.jastiper.create', compact('users', 'rekenings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nama_toko' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:30',
            'rekening_id' => 'nullable|exists:rekenings,id', 
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);
        
        $data['tanggal_daftar'] = now(); 
        $data['rating'] = $data['rating'] ?? 0.0;
        
        Jastiper::create($data);

        return redirect()->route('admin.jastiper.index')->with('success', 'Jastiper berhasil dibuat.');
    }

    public function edit(Jastiper $jastiper)
    {
        $users = User::orderBy('name')->get();
        $rekenings = Rekening::orderBy('nama_bank')->get();
        
        return view('admin.jastiper.edit', compact('jastiper','users', 'rekenings'));
    }

    public function update(Request $request, Jastiper $jastiper)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nama_toko' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:30',
            'jangkauan' => 'nullable|string', 
            'rekening_id' => 'nullable|exists:rekenings,id', 
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $data['rating'] = $data['rating'] ?? 0.0;
        $jastiper->update($data);

        return redirect()->route('admin.jastiper.index')->with('success', 'Jastiper berhasil diperbarui.');
    }

    public function destroy(Jastiper $jastiper)
    {
        $jastiper->delete();
        return redirect()->route('admin.jastiper.index')->with('success', 'Jastiper berhasil dihapus.');
    }

    public function ban(Jastiper $jastiper)
    {
        if ($jastiper->user) {
            $jastiper->user->is_banned = !$jastiper->user->is_banned;
            $jastiper->user->save();
            
            // Apabila dibanned, revoke token dan batalkan pesanan aktif
            if ($jastiper->user->is_banned) {
                $jastiper->user->fcm_token = null;
                $jastiper->user->save();
                if (method_exists($jastiper->user, 'tokens')) {
                    $jastiper->user->tokens()->delete();
                }
            }

            $status = $jastiper->user->is_banned ? 'dibekukan' : 'diaktifkan kembali';
            return back()->with('success', "Akun jastiper berhasil $status.");
        }
        return back()->with('error', "User jastiper tidak ditemukan.");
    }

    public function show(Jastiper $jastiper)
    {
        return view('admin.jastiper.show', compact('jastiper'));
    }
}
