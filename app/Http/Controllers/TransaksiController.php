<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function indeks(Request $request)
    {
        $kueri = auth()->user()->transactions()->with('category');

        if ($request->filled('tipe') && in_array($request->tipe, ['pemasukan', 'pengeluaran'])) {
            $kueri->where('tipe', $request->tipe);
        }

        if ($request->filled('bulan') && preg_match('/^\d{4}-\d{2}$/', $request->bulan)) {
            [$tahun, $bulan] = explode('-', $request->bulan);
            $kueri->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan);
        }

        $transaksi = $kueri->latest('tanggal')->latest('id')->paginate(15)->withQueryString();

        return view('transaksi.indeks', compact('transaksi'));
    }

    public function tampilTambah()
    {
        $kategori = $this->ambilKategoriUser();

        return view('transaksi.tambah', compact('kategori'));
    }

    public function simpan(Request $request)
    {
        $tervalidasi = $request->validate([
            'tipe'        => ['required', 'in:pemasukan,pengeluaran'],
            'nominal'     => ['required', 'numeric', 'gt:0'],
            'category_id' => ['required', $this->validasiKategoriMilikUser()],
            'tanggal'     => ['required', 'date'],
        ], [
            'tipe.required'        => 'Jenis transaksi wajib dipilih.',
            'tipe.in'              => 'Jenis transaksi tidak valid.',
            'nominal.required'     => 'Nominal wajib diisi.',
            'nominal.numeric'      => 'Nominal harus berupa angka.',
            'nominal.gt'           => 'Nominal harus lebih dari 0.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'tanggal.required'     => 'Tanggal wajib diisi.',
            'tanggal.date'         => 'Format tanggal tidak valid.',
        ]);

        auth()->user()->transactions()->create($tervalidasi);

        return redirect()->route('transaksi.indeks')
            ->with('sukses', 'Transaksi berhasil ditambahkan.');
    }

    public function tampilUbah($id)
    {
        $transaksi = auth()->user()->transactions()->findOrFail($id);
        $kategori  = $this->ambilKategoriUser();

        return view('transaksi.ubah', compact('transaksi', 'kategori'));
    }

    public function perbarui(Request $request, $id)
    {
        $transaksi = auth()->user()->transactions()->findOrFail($id);

        $tervalidasi = $request->validate([
            'tipe'        => ['required', 'in:pemasukan,pengeluaran'],
            'nominal'     => ['required', 'numeric', 'gt:0'],
            'category_id' => ['required', $this->validasiKategoriMilikUser()],
            'tanggal'     => ['required', 'date'],
        ], [
            'tipe.required'        => 'Jenis transaksi wajib dipilih.',
            'tipe.in'              => 'Jenis transaksi tidak valid.',
            'nominal.required'     => 'Nominal wajib diisi.',
            'nominal.numeric'      => 'Nominal harus berupa angka.',
            'nominal.gt'           => 'Nominal harus lebih dari 0.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'tanggal.required'     => 'Tanggal wajib diisi.',
            'tanggal.date'         => 'Format tanggal tidak valid.',
        ]);

        $transaksi->update($tervalidasi);

        return redirect()->route('transaksi.indeks')
            ->with('sukses', 'Transaksi berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $transaksi = auth()->user()->transactions()->findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.indeks')
            ->with('sukses', 'Transaksi berhasil dihapus.');
    }

    private function ambilKategoriUser()
    {
        return Category::where('user_id', auth()->id())
            ->orWhereNull('user_id')
            ->orderBy('nama_kategori')
            ->get();
    }

    private function validasiKategoriMilikUser(): \Closure
    {
        return function ($attribute, $nilai, $fail) {
            $ada = Category::where('id', $nilai)
                ->where(function ($q) {
                    $q->where('user_id', auth()->id())
                      ->orWhereNull('user_id');
                })->exists();

            if (!$ada) {
                $fail('Kategori tidak valid.');
            }
        };
    }
}
