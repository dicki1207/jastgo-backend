<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Ulasan;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->only([
            'loginForm',
            'login',
            'registerForm',
            'register',
            'verifyOtpForm',
            'verifyOtp',
            'resendOtp',
            'showOtp',
        ]);

        $this->middleware('auth')->except([
            'loginForm',
            'login',
            'registerForm',
            'register',
            'verifyOtpForm',
            'verifyOtp',
            'resendOtp',
            'showOtp',
            'landing',
            'showProductDetail'
        ]);
    }

    /**
     * =========================
     * LANDING PAGE (FILTER STOK)
     * =========================
     */
    public function landing(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard.index');
            }
            // Biarkan Jastiper dan User biasa tetap bisa mengakses halaman beranda (Katalog)
        }

        $kategoris = Kategori::all();

        $query = Barang::with('jastiper')
            ->where('is_available', 'yes')
            ->where('stok', '>', 0);

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhereHas('jastiper', function ($q2) use ($search) {
                      $q2->where('nama_toko', 'like', "%{$search}%");
                  });
            });
        }

        // 🏷️ Filter Kategori
        if ($request->filled('kategori')) {
            $kategoriId = Kategori::where('nama', $request->kategori)->value('id');
            if ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // 🔃 Sorting
        switch ($request->sort) {
            case 'harga_terendah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('harga', 'desc');
                break;
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;
            case 'nama_az':
                $query->orderBy('nama_barang', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $semuaProduk = $query->paginate(15);

        /**
         * =========================
         * PRODUK BULAN INI
         * =========================
         */
        $produkBulanIni = [];
        if (!$request->hasAny(['search', 'kategori', 'sort'])) {
            $now = Carbon::now();

            $produkBulanIni = Barang::with('jastiper')
                ->where('is_available', 'yes')
                ->where('stok', '>', 0)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        }

        return view('user.landing_page', compact(
            'produkBulanIni',
            'semuaProduk',
            'kategoris'
        ));
    }

    /**
     * =========================
     * DETAIL PRODUK (AMAN)
     * =========================
     */
    public function showProductDetail($id)
    {
        $barang = Barang::with('jastiper')
            ->where('stok', '>', 0)
            ->findOrFail($id);

        $jastiper = $barang->jastiper;

        $ulasanCount = $jastiper
            ? Ulasan::where('jastiper_id', $jastiper->id)->count()
            : 0;

        if ($jastiper) {
            $jastiper->total_rating = $jastiper->rating ?? 0;
            $jastiper->total_penilaian = $ulasanCount;
        }

        /**
         * =========================
         * PRODUK SERUPA
         * =========================
         */
        $produkSerupa = Barang::with('jastiper')
            ->where('is_available', 'yes')
            ->where('stok', '>', 0)
            ->where('id', '!=', $id)
            ->where('kategori_id', $barang->kategori_id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        if ($produkSerupa->isEmpty()) {
            $produkSerupa = Barang::with('jastiper')
                ->where('is_available', 'yes')
                ->where('stok', '>', 0)
                ->where('id', '!=', $id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        }

        return view('user.detail_produk', compact(
            'barang',
            'produkSerupa',
            'jastiper'
        ));
    }

    /**
     * =========================
     * AUTH
     * =========================
     */
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $key = 'login:' . $request->ip() . '|' . strtolower($data['email']);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()
                ->withErrors(['email' => 'Terlalu banyak percobaan! Coba lagi nanti.'])
                ->onlyInput('email');
        }

        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            RateLimiter::clear($key);

            // Cek apakah akun di-banned
            if ($user->is_banned) {
                return back()
                    ->withErrors(['email' => 'Akun Anda telah dibekukan karena melanggar aturan kami.'])
                    ->onlyInput('email');
            }

            // Cek apakah akun sudah diverifikasi
            if (is_null($user->email_verified_at)) {
                $otp = rand(100000, 999999);
                $user->otp_code = $otp;
                $user->otp_expires_at = Carbon::now()->addMinutes(5);
                $user->save();
                
                \Illuminate\Support\Facades\Log::info("OTP Login (Belum Verifikasi) untuk {$user->email}: {$otp}");
                session(['otp_display' => $otp]);
                
                return redirect()->route('otp.verify.form')
                    ->with('verify_email', $user->email)
                    ->with('error', 'Akun Anda belum diverifikasi! Silakan lihat kode OTP di tab baru.');
            }

            Auth::login($user);
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard.index');
            }
            if ($user->role === 'jastiper') {
                return redirect()->route('jastiper.dashboard.index');
            }

            return redirect()->route('home');
        }

        RateLimiter::hit($key, 60);

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|regex:/^[a-zA-Z0-9_]+$/|max:100|unique:users,username',
            'nama_lengkap'  => 'nullable|string|max:150',
            'no_hp'         => 'nullable|string|max:30',
            'alamat'        => 'nullable|string',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|confirmed|min:6',
        ], [
            'name.regex' => 'Username hanya boleh berisi huruf, angka, dan garis bawah (_). Tanpa spasi atau simbol lain.',
        ]);

        $otp = rand(100000, 999999);

        $user = User::create([
            'name'         => $data['name'],
            'username'     => $data['name'],
            'nama_lengkap' => $data['nama_lengkap'] ?? null,
            'no_hp'        => $data['no_hp'] ?? null,
            'alamat'       => $data['alamat'] ?? null,
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'role'         => 'pengguna',
            'otp_code'     => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
            'email_verified_at' => null,
        ]);

        \Illuminate\Support\Facades\Log::info("OTP Register untuk {$user->email}: {$otp}");
        session(['otp_display' => $otp]);

        return redirect()
            ->route('otp.verify.form')
            ->with('verify_email', $user->email)
            ->with('success', 'Registrasi berhasil! Klik tombol "Lihat Kode OTP" untuk melihat kode verifikasi Anda.');
    }

    public function verifyOtpForm()
    {
        return view('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        if ($user->otp_code !== $request->otp_code) {
            return back()->with('error', 'Kode OTP salah!')->with('verify_email', $request->email);
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'Kode OTP sudah kadaluwarsa! Silakan minta ulang.')->with('verify_email', $request->email);
        }

        // Jika berhasil
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);
        
        return redirect()->route('home')->with('success', 'Akun berhasil diverifikasi dan Anda telah login!');
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(5);
            $user->save();
            \Illuminate\Support\Facades\Log::info("Resend OTP untuk {$user->email}: {$otp}");
            session(['otp_display' => $otp]);
        }

        return back()->with('success', 'OTP baru telah dibuat! Klik tombol "Lihat Kode OTP" untuk melihat kode baru.')->with('verify_email', $request->email);
    }

    public function showOtp(Request $request)
    {
        $otp = session('otp_display');
        if (!$otp) {
            return redirect()->route('home');
        }
        // Hapus dari session agar hanya bisa dilihat 1 kali
        session()->forget('otp_display');
        return view('show-otp', ['otp_code' => $otp]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
