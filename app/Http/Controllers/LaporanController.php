<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function tampil(Request $request)
    {
        $pengguna     = auth()->user();
        $tahunDipilih = (int) $request->input('tahun', now()->year);
        $bulanDipilih = $request->input('bulan', '');

        // Daftar tahun berdasarkan transaksi yang ada
        $tanggalTerlama = $pengguna->transactions()->min('tanggal');
        $tahunTerlama   = $tanggalTerlama ? (int) substr($tanggalTerlama, 0, 4) : now()->year;
        $daftarTahun    = range(now()->year, $tahunTerlama);

        // Data grafik batang 12 bulan untuk tahun dipilih
        $labelBulan     = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataPemasukan  = [];
        $dataPengeluaran = [];

        for ($b = 1; $b <= 12; $b++) {
            $dataPemasukan[]  = (float) $pengguna->transactions()
                ->where('tipe', 'pemasukan')
                ->whereYear('tanggal', $tahunDipilih)
                ->whereMonth('tanggal', $b)
                ->sum('nominal');
            $dataPengeluaran[] = (float) $pengguna->transactions()
                ->where('tipe', 'pengeluaran')
                ->whereYear('tanggal', $tahunDipilih)
                ->whereMonth('tanggal', $b)
                ->sum('nominal');
        }

        // Closure filter periode agar tidak duplikasi kondisi
        $filterPeriode = function ($q) use ($tahunDipilih, $bulanDipilih) {
            $q->whereYear('tanggal', $tahunDipilih);
            if ($bulanDipilih !== '') {
                $q->whereMonth('tanggal', (int) $bulanDipilih);
            }
        };

        // Ringkasan periode terpilih
        $totalPemasukan  = $pengguna->transactions()->where('tipe', 'pemasukan')->tap($filterPeriode)->sum('nominal');
        $totalPengeluaran = $pengguna->transactions()->where('tipe', 'pengeluaran')->tap($filterPeriode)->sum('nominal');
        $selisih          = $totalPemasukan - $totalPengeluaran;

        // Tabel transaksi dengan filter
        $transaksi = $pengguna->transactions()
            ->with('category')
            ->tap($filterPeriode)
            ->latest('tanggal')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('laporan.indeks', compact(
            'transaksi',
            'labelBulan',
            'dataPemasukan',
            'dataPengeluaran',
            'tahunDipilih',
            'bulanDipilih',
            'totalPemasukan',
            'totalPengeluaran',
            'selisih',
            'daftarTahun'
        ));
    }
}
