<?php

namespace App\Http\Controllers\Admin; // Diubah dari App\Http\Controllers\Admin

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification; 
use App\Models\User; 
// use Carbon\Carbon; // Tidak diperlukan di controller ini, bisa dihapus

class NotifikasiController extends Controller
{
    /**
     * Menampilkan daftar notifikasi untuk pengguna yang sedang login.
     */
    public function index(Request $request)
    {
        $user = Auth::user(); 
        $search = $request->query('search');
        $status = $request->query('status', 'semua');

        $query = $user->notifications(); 

        // --- Logika Pencarian ---
        if ($search) {
            $query->where('data', 'like', "%{$search}%");
        }

        // --- Logika Filter Status ---
        if ($status === 'belum_baca') {
            $query->whereNull('read_at');
        } elseif ($status === 'sudah_baca') {
            $query->whereNotNull('read_at');
        }

        $notifikasis = $query->orderBy('created_at', 'desc')
                            ->paginate(15)
                            ->withQueryString();

        // Menggunakan unreadNotifications() untuk query count yang efisien
        $belum_baca_count = $user->unreadNotifications()->count(); 

        // Jika Anda memindahkan controller, pastikan path view ini benar:
        // Jika Anda menargetkan tampilan User/Jastiper, ganti 'admin.notifikasi.index'
        return view('admin.notifikasi.index', compact('notifikasis', 'search', 'status', 'belum_baca_count'));
    }

    // ---

    /**
     * Menandai satu notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(Request $request, DatabaseNotification $notification)
    {
        $user = Auth::user();
        $isOwner = false;

        // Cek kepemilikan berdasarkan tipe notifiable
        if ($notification->notifiable_type === 'App\Models\User' && $notification->notifiable_id == $user->id) {
            $isOwner = true;
        } elseif ($notification->notifiable_type === 'App\Models\Jastiper' && $user->jastiper && $notification->notifiable_id == $user->jastiper->id) {
            $isOwner = true;
        }

        // Validasi kepemilikan notifikasi (Security check)
        if (!$isOwner) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Akses ditolak.'], 403);
            }
            abort(403, 'Akses ditolak.');
        }
        
        $notification->markAsRead();
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Notifikasi berhasil ditandai sudah dibaca.']);
        }
        return back()->with('success', 'Notifikasi berhasil ditandai sudah dibaca.');
    }

    // ---

    /**
     * Menandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $user->unreadNotifications->markAsRead();
        } elseif ($user->role === 'jastiper' && $user->jastiper) {
            $user->jastiper->unreadNotifications->markAsRead();
        } else {
            $user->unreadNotifications->markAsRead();
        }
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Semua notifikasi berhasil ditandai sudah dibaca.']);
        }
        return back()->with('success', 'Semua notifikasi berhasil ditandai sudah dibaca.');
    }
    
    // ---

    /**
     * Menghapus satu notifikasi.
     */
    public function destroy(DatabaseNotification $notification)
    {
        $user = Auth::user();
        $isOwner = false;

        if ($notification->notifiable_type === 'App\Models\User' && $notification->notifiable_id == $user->id) {
            $isOwner = true;
        } elseif ($notification->notifiable_type === 'App\Models\Jastiper' && $user->jastiper && $notification->notifiable_id == $user->jastiper->id) {
            $isOwner = true;
        }

        // Validasi kepemilikan notifikasi (Security check)
        if (!$isOwner) {
            abort(403, 'Akses ditolak.');
        }
        
        $notification->delete();
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}