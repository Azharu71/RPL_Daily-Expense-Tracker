@extends('layouts.aplikasi')

@section('judul', 'Tambah Transaksi')

@section('konten')

<div class="max-w-xl">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('transaksi.indeks') }}" class="hover:text-gray-700 transition-colors">Riwayat Transaksi</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Tambah</span>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-8">

        <h2 class="text-base font-semibold text-gray-900 mb-6">Catat Transaksi Baru</h2>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-xs font-semibold text-red-700 mb-1.5">Mohon perbaiki kesalahan berikut:</p>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start gap-2 text-sm text-red-600">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('transaksi.simpan') }}" class="space-y-5">
            @csrf

            {{-- Toggle Jenis Transaksi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="tipe" value="pemasukan" class="sr-only peer"
                               {{ old('tipe', 'pemasukan') === 'pemasukan' ? 'checked' : '' }}>
                        <div class="flex items-center justify-center gap-2.5 p-3.5 border-2 rounded-xl text-sm font-semibold transition-all
                                    border-gray-200 text-gray-500
                                    peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700">
                            {{-- lucide: arrow-down-left --}}
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            Pemasukan
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="tipe" value="pengeluaran" class="sr-only peer"
                               {{ old('tipe') === 'pengeluaran' ? 'checked' : '' }}>
                        <div class="flex items-center justify-center gap-2.5 p-3.5 border-2 rounded-xl text-sm font-semibold transition-all
                                    border-gray-200 text-gray-500
                                    peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700">
                            {{-- lucide: minus --}}
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                            Pengeluaran
                        </div>
                    </label>
                </div>
            </div>

            {{-- Nominal --}}
            <div>
                <label for="nominal" class="block text-sm font-medium text-gray-700 mb-1.5">Nominal (Rp)</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-400">Rp</span>
                    <input
                        type="number"
                        id="nominal"
                        name="nominal"
                        value="{{ old('nominal') }}"
                        min="1"
                        step="1"
                        placeholder="0"
                        required
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent placeholder-gray-400 transition-shadow"
                    >
                </div>
            </div>

            {{-- Kategori --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                <select
                    id="category_id"
                    name="category_id"
                    required
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent bg-white text-gray-800"
                >
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ old('category_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                    required
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent text-gray-800"
                >
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="flex-1 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-lg transition-colors">
                    Simpan Transaksi
                </button>
                <a href="{{ route('transaksi.indeks') }}"
                   class="flex-1 py-2.5 text-center text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

@endsection
