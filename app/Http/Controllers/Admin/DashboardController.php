<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Jastiper; 
use App\Models\Pesanan;
use App\Models\AlurDana;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Log::info("DASHBOARD HIT");
        $lastTwelveMonths = Carbon::now()->subMonths(11)->startOfMonth();
        
        
        $totalUsers = User::count(); 

        $totalJastipers = Jastiper::count();
        
        $pembayaranDitinjau = Pesanan::where('status_pesanan', 'MENUNGGU_KONFIRMASI_ADMIN')->count(); 
        
        $pendapatanAdminTotal = AlurDana::where('jenis_transaksi', 'PELEPASAN_DANA')
                                        ->where('status_konfirmasi', 'DIKONFIRMASI')
                                        ->sum('biaya_admin'); 
                                        
        $danaDitahan = Pesanan::where('status_pesanan', 'SELESAI')
                              ->where('status_dana_jastiper', 'TERTAHAN')
                              ->sum('total_harga'); 

        $totalTransaksiSelesai = Pesanan::where('status_pesanan', 'SELESAI')->count();



        $pendapatanAdminRaw = AlurDana::where('jenis_transaksi', 'PELEPASAN_DANA')
                                     ->where('status_konfirmasi', 'DIKONFIRMASI')
                                     ->where('created_at', '>=', $lastTwelveMonths)
                                     ->select(
                                         DB::raw('YEAR(created_at) as tahun'),
                                         DB::raw('MONTH(created_at) as bulan'),
                                         DB::raw('SUM(biaya_admin) as total')
                                     )
                                     ->groupBy('tahun', 'bulan')
                                     ->orderBy('tahun', 'asc')
                                     ->orderBy('bulan', 'asc') 
                                     ->get()
                                     ->keyBy(function ($item) {
                                         return $item->tahun . '-' . $item->bulan;
                                     })
                                     ->toArray();

        $dataPendapatan = [];
        $labelsPendapatan = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths(11 - $i);
            $key = $date->year . '-' . $date->month;
            
            $dataPendapatan[] = $pendapatanAdminRaw[$key]['total'] ?? 0;
            $labelsPendapatan[] = $date->translatedFormat('M'); 
        }

        $menungguKonfirmasi = Pesanan::where('status_pesanan', 'MENUNGGU_KONFIRMASI_ADMIN')->count();
        $pembayaranSelesaiCount = Pesanan::where('status_pesanan', '!=', 'MENUNGGU_KONFIRMASI_ADMIN')->count();
                                      
        $konfirmasiChartData = [
            'MENUNGGU' => $menungguKonfirmasi,
            'SELESAI'  => $pembayaranSelesaiCount,
        ];

        $danaTertahanCount = Pesanan::where('status_pesanan', 'SELESAI')
                                    ->whereIn('status_dana_jastiper', ['TERTAHAN', 'TERSEDIA_DI_DOMPET', 'MENUNGGU_PELEPASAN'])
                                    ->count();
        $danaDilepas = Pesanan::where('status_pesanan', 'SELESAI')
                               ->where('status_dana_jastiper', 'DILEPASKAN')
                               ->count();

        $danaChartData = [
            'BELUM DITARIK' => $danaTertahanCount,
            'SUDAH DITARIK'  => $danaDilepas,
        ];
        
        $danaDitahanPerJastiper = Pesanan::whereIn('status_dana_jastiper', ['TERTAHAN', 'TERSEDIA_DI_DOMPET', 'MENUNGGU_PELEPASAN'])
                                         ->whereIn('status_pesanan', ['DIPROSES', 'SIAP_DIKIRIM', 'SELESAI'])
                                         ->select('jastiper_id', DB::raw('SUM(total_harga) as total_ditahan'))
                                         ->groupBy('jastiper_id')
                                         ->with('jastiper.user')
                                         ->get();
                                         
        // Modify existing $danaDitahan to sum across the same statuses
        $danaDitahan = Pesanan::whereIn('status_dana_jastiper', ['TERTAHAN', 'TERSEDIA_DI_DOMPET', 'MENUNGGU_PELEPASAN'])
                              ->whereIn('status_pesanan', ['DIPROSES', 'SIAP_DIKIRIM', 'SELESAI'])
                              ->sum('total_harga');
        
        $userRaw = User::where('created_at', '>=', $lastTwelveMonths)
                        ->select(
                            DB::raw('YEAR(created_at) as tahun'),
                            DB::raw('MONTH(created_at) as bulan'),
                            DB::raw('COUNT(id) as total')
                        )
                        ->groupBy('tahun', 'bulan')
                        ->orderBy('tahun', 'asc')
                        ->orderBy('bulan', 'asc')
                        ->get()
                        ->keyBy(function ($item) {
                            return $item->tahun . '-' . $item->bulan;
                        })
                        ->toArray();
        
        $jastiperRaw = Jastiper::where('created_at', '>=', $lastTwelveMonths)
                                ->select(
                                    DB::raw('YEAR(created_at) as tahun'),
                                    DB::raw('MONTH(created_at) as bulan'),
                                    DB::raw('COUNT(id) as total')
                                )
                                ->groupBy('tahun', 'bulan')
                                ->orderBy('tahun', 'asc')
                                ->orderBy('bulan', 'asc')
                                ->get()
                                ->keyBy(function ($item) {
                                    return $item->tahun . '-' . $item->bulan;
                                })
                                ->toArray();


        $dataPelanggan = [];
        $dataJastiper = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths(11 - $i);
            $key = $date->year . '-' . $date->month;
            
            $dataPelanggan[] = $userRaw[$key]['total'] ?? 0;
            $dataJastiper[] = $jastiperRaw[$key]['total'] ?? 0;
        }

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalJastipers',
            'pembayaranDitinjau',
            'danaDitahan',
            'totalTransaksiSelesai',
            'pendapatanAdminTotal',
            'dataPendapatan',
            'labelsPendapatan',
            'konfirmasiChartData',
            'danaChartData',
            'dataPelanggan',
            'dataJastiper',
            'danaDitahanPerJastiper'
        ));
    }
}