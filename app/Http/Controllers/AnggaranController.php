<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function tampil(Request $request)
    {
        $pengguna     = auth()->user();
        $tahunDipilih = (int) $request->input('tahun', now()->year);

        // Ambil semua anggaran user untuk tahun dipilih, di-index per bulan
        $daftarAnggaran = $pengguna->anggarans()
            ->where('tahun', $tahunDipilih)
            ->get()
            ->keyBy('bulan');

        // Hitung pengeluaran aktual per bulan untuk tahun dipilih
        $pengeluaranPerBulan = [];
        for ($b = 1; $b <= 12; $b++) {
            $pengeluaranPerBulan[$b] = (float) $pengguna->transactions()
                ->where('tipe', 'pengeluaran')
                ->whereYear('tanggal', $tahunDipilih)
                ->whereMonth('tanggal', $b)
                ->sum('nominal');
        }

        // Daftar tahun untuk selector
        $tahunSekarang = now()->year;
        $daftarTahun   = range($tahunSekarang + 1, max($tahunSekarang - 3, 2020));
        array_unshift($daftarTahun, $tahunSekarang);
        $daftarTahun = array_unique($daftarTahun);
        sort($daftarTahun);
        $daftarTahun = array_reverse($daftarTahun);

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('anggaran.indeks', compact(
            'daftarAnggaran',
            'pengeluaranPerBulan',
            'tahunDipilih',
            'daftarTahun',
            'namaBulan'
        ));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'bulan'            => ['required', 'integer', 'min:1', 'max:12'],
            'tahun'            => ['required', 'integer', 'min:2020', 'max:' . (now()->year + 1)],
            'nominal_anggaran' => ['required', 'numeric', 'gt:0'],
        ], [
            'bulan.required'            => 'Bulan wajib dipilih.',
            'bulan.min'                 => 'Bulan tidak valid.',
            'bulan.max'                 => 'Bulan tidak valid.',
            'tahun.required'            => 'Tahun wajib dipilih.',
            'tahun.min'                 => 'Tahun tidak valid.',
            'tahun.max'                 => 'Tahun tidak valid.',
            'nominal_anggaran.required' => 'Nominal anggaran wajib diisi.',
            'nominal_anggaran.numeric'  => 'Nominal anggaran harus berupa angka.',
            'nominal_anggaran.gt'       => 'Nominal anggaran harus lebih dari 0.',
        ]);

        auth()->user()->anggarans()->updateOrCreate(
            [
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
            ],
            [
                'nominal_anggaran' => $request->nominal_anggaran,
            ]
        );

        return redirect()
            ->route('anggaran.indeks', ['tahun' => $request->tahun])
            ->with('sukses', 'Anggaran berhasil disimpan.');
    }
}
