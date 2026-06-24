<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function indeks()
    {
        $kategoriDefault = Category::whereNull('user_id')->orderBy('nama_kategori')->get();
        $kategoriSaya    = auth()->user()->categories()->orderBy('nama_kategori')->get();

        return view('kategori.indeks', compact('kategoriDefault', 'kategoriSaya'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama_kategori' => [
                'required', 'string', 'max:50',
                Rule::unique('categories')->where('user_id', auth()->id()),
            ],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 50 karakter.',
            'nama_kategori.unique'   => 'Anda sudah memiliki kategori dengan nama ini.',
        ]);

        auth()->user()->categories()->create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.indeks')
            ->with('sukses', 'Kategori berhasil ditambahkan.');
    }

    public function perbarui(Request $request, $id)
    {
        $kategori = auth()->user()->categories()->findOrFail($id);

        $request->validate([
            'nama_kategori' => [
                'required', 'string', 'max:50',
                Rule::unique('categories')->where('user_id', auth()->id())->ignore($id),
            ],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 50 karakter.',
            'nama_kategori.unique'   => 'Anda sudah memiliki kategori dengan nama ini.',
        ]);

        $kategori->update(['nama_kategori' => $request->nama_kategori]);

        return redirect()->route('kategori.indeks')
            ->with('sukses', 'Kategori berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $kategori = auth()->user()->categories()->findOrFail($id);

        if ($kategori->transactions()->exists()) {
            return redirect()->route('kategori.indeks')
                ->with('galat', 'Kategori tidak bisa dihapus karena masih digunakan oleh transaksi.');
        }

        $kategori->delete();

        return redirect()->route('kategori.indeks')
            ->with('sukses', 'Kategori berhasil dihapus.');
    }
}
