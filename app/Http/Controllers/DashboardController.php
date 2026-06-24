<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function tampil()
    {
        $pengguna = auth()->user();

        $totalPemasukan  = $pengguna->transactions()->where('tipe', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $pengguna->transactions()->where('tipe', 'pengeluaran')->sum('nominal');
        $saldoAktif      = $totalPemasukan - $totalPengeluaran;

        $pemasukanBulanIni = $pengguna->transactions()
            ->where('tipe', 'pemasukan')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('nominal');

        $pengeluaranBulanIni = $pengguna->transactions()
            ->where('tipe', 'pengeluaran')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('nominal');

        $transaksiTerakhir = $pengguna->transactions()
            ->with('category')
            ->latest('tanggal')
            ->latest('id')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'saldoAktif',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'transaksiTerakhir'
        ));
    }
}
