@extends('layouts.aplikasi')

@section('judul', 'Dashboard')

@section('konten')

{{-- ===== HEADER SELAMAT DATANG ===== --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Selamat datang, {{ explode(' ', auth()->user()->nama)[0] }}!</h2>
        <p class="text-sm text-gray-400 mt-0.5">Berikut ringkasan keuangan Anda hari ini.</p>
    </div>
    <a href="{{ route('transaksi.tambah') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors">
        {{-- lucide: plus --}}
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Tambah Transaksi
    </a>
</div>

{{-- ===== NOTIFIKASI ANGGARAN ===== --}}
@if ($persenPengeluaran !== null && $persenPengeluaran >= 80)
    @php
        $melebihi = $persenPengeluaran >= 100;
    @endphp
    <div @class([
        'flex items-center gap-4 px-4 py-3.5 rounded-xl mb-6 border',
        'bg-red-50 border-red-200'    => $melebihi,
        'bg-amber-50 border-amber-200' => !$melebihi,
    ])>
        {{-- lucide: alert-triangle --}}
        <div @class([
            'w-9 h-9 rounded-lg flex items-center justify-center shrink-0',
            'bg-red-100'    => $melebihi,
            'bg-amber-100'  => !$melebihi,
        ])>
            <svg @class(['w-4 h-4', 'text-red-600' => $melebihi, 'text-amber-600' => !$melebihi])
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                <path d="M12 9v4"/><path d="M12 17h.01"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p @class(['text-sm font-semibold', 'text-red-700' => $melebihi, 'text-amber-700' => !$melebihi])>
                @if ($melebihi)
                    Pengeluaran bulan ini telah melampaui anggaran!
                @else
                    Pengeluaran bulan ini mendekati batas anggaran ({{ number_format($persenPengeluaran, 0) }}%).
                @endif
            </p>
            <p @class(['text-xs mt-0.5', 'text-red-500' => $melebihi, 'text-amber-500' => !$melebihi])>
                Anggaran: Rp {{ number_format($anggaranBulanIni->nominal_anggaran, 0, ',', '.') }}
                &nbsp;·&nbsp;
                Terpakai: Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}
            </p>
        </div>
        <a href="{{ route('anggaran.indeks') }}"
           @class([
               'text-xs font-medium whitespace-nowrap hover:underline',
               'text-red-600'    => $melebihi,
               'text-amber-600'  => !$melebihi,
           ])>
            Kelola Anggaran →
        </a>
    </div>
@endif

{{-- ===== KARTU RINGKASAN ===== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    {{-- Total Saldo Aktif --}}
    <div @class([
        'rounded-xl p-6 text-white',
        'bg-gray-900'   => $saldoAktif >= 0,
        'bg-red-700'    => $saldoAktif < 0,
    ])>
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-white/60">Total Saldo Aktif</p>
            <div class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center">
                {{-- lucide: wallet --}}
                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold">
            {{ $saldoAktif < 0 ? '-' : '' }}Rp {{ number_format(abs($saldoAktif), 0, ',', '.') }}
        </p>
        <p class="text-xs text-white/40 mt-1">Total pemasukan dikurangi pengeluaran</p>
    </div>

    {{-- Pemasukan Bulan Ini --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500">Pemasukan Bulan Ini</p>
            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                {{-- lucide: trending-up --}}
                <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-green-600">+Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    </div>

    {{-- Pengeluaran Bulan Ini --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500">Pengeluaran Bulan Ini</p>
            <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
                {{-- lucide: trending-down --}}
                <svg class="w-4 h-4 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-red-600">-Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    </div>

</div>

{{-- ===== TRANSAKSI TERAKHIR ===== --}}
<div class="bg-white border border-gray-200 rounded-xl">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div>
            <h2 class="text-sm font-semibold text-gray-900">Transaksi Terakhir</h2>
            @if ($transaksiTerakhir->isNotEmpty())
                <p class="text-xs text-gray-400 mt-0.5">{{ $transaksiTerakhir->count() }} transaksi terbaru</p>
            @endif
        </div>
        <a href="{{ route('transaksi.indeks') }}" class="text-xs text-gray-500 hover:text-gray-900 transition-colors font-medium">
            Lihat semua →
        </a>
    </div>

    {{-- Isi --}}
    @if ($transaksiTerakhir->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center px-6">
            {{-- lucide: inbox --}}
            <svg class="w-12 h-12 text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
            <p class="text-sm font-medium text-gray-500 mb-1">Belum ada transaksi</p>
            <p class="text-xs text-gray-400 mb-5">Mulai catat pemasukan atau pengeluaran pertama Anda.</p>
            <a href="{{ route('transaksi.tambah') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tambah Transaksi
            </a>
        </div>
    @else
        <ul class="divide-y divide-gray-50">
            @foreach ($transaksiTerakhir as $item)
                <li class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div @class([
                            'w-9 h-9 rounded-lg flex items-center justify-center shrink-0',
                            'bg-green-100' => $item->tipe === 'pemasukan',
                            'bg-red-100'   => $item->tipe === 'pengeluaran',
                        ])>
                            @if ($item->tipe === 'pemasukan')
                                <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            @else
                                <svg class="w-4 h-4 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $item->category->nama_kategori }}</p>
                            <p class="text-xs text-gray-400">{{ $item->tanggal->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span @class([
                            'text-sm font-semibold',
                            'text-green-600' => $item->tipe === 'pemasukan',
                            'text-red-600'   => $item->tipe === 'pengeluaran',
                        ])>
                            {{ $item->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('transaksi.ubah', $item->id) }}"
                           class="text-gray-300 hover:text-gray-600 transition-colors">
                            {{-- lucide: pencil --}}
                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>

        {{-- Footer ringkasan --}}
        @if ($transaksiTerakhir->count() >= 10)
            <div class="px-6 py-3 border-t border-gray-50 text-center">
                <a href="{{ route('transaksi.indeks') }}" class="text-xs text-gray-400 hover:text-gray-700 transition-colors">
                    Tampilkan semua transaksi →
                </a>
            </div>
        @endif
    @endif

</div>

@endsection
