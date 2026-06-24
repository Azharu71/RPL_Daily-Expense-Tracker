@extends('layouts.aplikasi')

@section('judul', 'Riwayat Transaksi')

@section('konten')

{{-- ===== HEADER ===== --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Riwayat Transaksi</h2>
        <p class="text-sm text-gray-400 mt-0.5">Semua catatan pemasukan dan pengeluaran Anda.</p>
    </div>
    <a href="{{ route('transaksi.tambah') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors">
        {{-- lucide: plus --}}
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Tambah Transaksi
    </a>
</div>

{{-- ===== FLASH PESAN ===== --}}
@if (session('sukses'))
    <div class="mb-5 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
        {{-- lucide: check-circle --}}
        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('sukses') }}
    </div>
@endif

{{-- ===== FILTER ===== --}}
<form method="GET" action="{{ route('transaksi.indeks') }}" class="flex items-center gap-3 mb-5">
    <select name="tipe"
        class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 bg-white text-gray-700">
        <option value="">Semua Jenis</option>
        <option value="pemasukan"   {{ request('tipe') === 'pemasukan'   ? 'selected' : '' }}>Pemasukan</option>
        <option value="pengeluaran" {{ request('tipe') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
    </select>

    <input type="month" name="bulan" value="{{ request('bulan') }}"
        class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 bg-white text-gray-700">

    <button type="submit"
        class="px-4 py-2 text-sm font-medium bg-gray-900 hover:bg-gray-800 text-white rounded-lg transition-colors">
        Filter
    </button>

    @if (request('tipe') || request('bulan'))
        <a href="{{ route('transaksi.indeks') }}"
           class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 rounded-lg transition-colors">
            Reset
        </a>
    @endif
</form>

{{-- ===== TABEL TRANSAKSI ===== --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    @if ($transaksi->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center px-6">
            {{-- lucide: inbox --}}
            <svg class="w-12 h-12 text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
            <p class="text-sm font-medium text-gray-500 mb-1">Belum ada transaksi</p>
            <p class="text-xs text-gray-400 mb-5">
                @if (request('tipe') || request('bulan'))
                    Tidak ada transaksi yang cocok dengan filter ini.
                @else
                    Mulai catat pemasukan atau pengeluaran Anda.
                @endif
            </p>
            @unless (request('tipe') || request('bulan'))
                <a href="{{ route('transaksi.tambah') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Tambah Transaksi
                </a>
            @endunless
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                    <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($transaksi as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- Tanggal --}}
                        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                            {{ $item->tanggal->translatedFormat('d M Y') }}
                        </td>

                        {{-- Kategori --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div @class([
                                    'w-7 h-7 rounded-lg flex items-center justify-center shrink-0',
                                    'bg-green-100' => $item->tipe === 'pemasukan',
                                    'bg-red-100'   => $item->tipe === 'pengeluaran',
                                ])>
                                    @if ($item->tipe === 'pemasukan')
                                        <svg class="w-3.5 h-3.5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                                    @endif
                                </div>
                                <span class="font-medium text-gray-800">{{ $item->category->nama_kategori }}</span>
                            </div>
                        </td>

                        {{-- Jenis --}}
                        <td class="px-6 py-4">
                            <span @class([
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold',
                                'bg-green-100 text-green-700' => $item->tipe === 'pemasukan',
                                'bg-red-100 text-red-700'     => $item->tipe === 'pengeluaran',
                            ])>
                                {{ ucfirst($item->tipe) }}
                            </span>
                        </td>

                        {{-- Nominal --}}
                        <td class="px-6 py-4 text-right font-semibold whitespace-nowrap @if($item->tipe === 'pemasukan') text-green-600 @else text-red-600 @endif">
                            {{ $item->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Tombol Ubah --}}
                                <a href="{{ route('transaksi.ubah', $item->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    {{-- lucide: pencil --}}
                                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    Ubah
                                </a>

                                {{-- Tombol Hapus --}}
                                <form method="POST" action="{{ route('transaksi.hapus', $item->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        {{-- lucide: trash-2 --}}
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        @if ($transaksi->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $transaksi->links() }}
            </div>
        @endif
    @endif

</div>

@endsection
