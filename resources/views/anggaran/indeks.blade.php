@extends('layouts.aplikasi')

@section('judul', 'Anggaran')

@section('konten')

{{-- ===== HEADER ===== --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Anggaran Bulanan</h2>
        <p class="text-sm text-gray-400 mt-0.5">Atur batas pengeluaran per bulan dan pantau realisasinya.</p>
    </div>
</div>

{{-- ===== FLASH ===== --}}
@if (session('sukses'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
        <svg class="w-4 h-4 shrink-0 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('sukses') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ===== KOLOM KIRI: FORM SET ANGGARAN ===== --}}
    <div class="lg:col-span-1">
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Atur Anggaran</h3>
                <p class="text-xs text-gray-400 mt-0.5">Simpan akan menimpa anggaran yang sudah ada untuk bulan tersebut.</p>
            </div>

            <form method="POST" action="{{ route('anggaran.simpan') }}" class="px-5 py-5 space-y-4">
                @csrf

                {{-- Bulan --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Bulan</label>
                    <select name="bulan"
                            class="w-full px-3 py-2 text-sm border @error('bulan') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        @foreach ($namaBulan as $angka => $nama)
                            <option value="{{ $angka }}" @selected(old('bulan', now()->month) == $angka)>{{ $nama }}</option>
                        @endforeach
                    </select>
                    @error('bulan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Tahun</label>
                    <select name="tahun"
                            class="w-full px-3 py-2 text-sm border @error('tahun') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        @foreach ($daftarTahun as $tahun)
                            <option value="{{ $tahun }}" @selected(old('tahun', $tahunDipilih) == $tahun)>{{ $tahun }}</option>
                        @endforeach
                    </select>
                    @error('tahun')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nominal --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Nominal Anggaran</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium pointer-events-none">Rp</span>
                        <input type="number"
                               name="nominal_anggaran"
                               value="{{ old('nominal_anggaran') }}"
                               min="1"
                               step="1000"
                               placeholder="0"
                               class="w-full pl-9 pr-3 py-2 text-sm border @error('nominal_anggaran') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    </div>
                    @error('nominal_anggaran')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors">
                    Simpan Anggaran
                </button>
            </form>
        </div>

        {{-- Info box --}}
        <div class="mt-4 flex items-start gap-3 px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg">
            <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <p class="text-xs text-blue-700">
                Peringatan otomatis akan muncul di dashboard ketika pengeluaran mencapai
                <strong>80%</strong> atau melebihi anggaran yang ditetapkan.
            </p>
        </div>
    </div>

    {{-- ===== KOLOM KANAN: GRID 12 BULAN ===== --}}
    <div class="lg:col-span-2">

        {{-- Filter tahun --}}
        <form method="GET" action="{{ route('anggaran.indeks') }}" class="flex items-center gap-2 mb-4">
            <select name="tahun" onchange="this.form.submit()"
                    class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900">
                @foreach ($daftarTahun as $tahun)
                    <option value="{{ $tahun }}" @selected($tahun == $tahunDipilih)>{{ $tahun }}</option>
                @endforeach
            </select>
            <span class="text-xs text-gray-400">Tampilkan anggaran tahun:</span>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach ($namaBulan as $angka => $nama)
                @php
                    $anggaran     = $daftarAnggaran->get($angka);
                    $pengeluaran  = $pengeluaranPerBulan[$angka];
                    $persen       = ($anggaran && $anggaran->nominal_anggaran > 0)
                                        ? min(($pengeluaran / $anggaran->nominal_anggaran) * 100, 100)
                                        : 0;
                    $persenAktual = ($anggaran && $anggaran->nominal_anggaran > 0)
                                        ? ($pengeluaran / $anggaran->nominal_anggaran) * 100
                                        : 0;
                    $bulanIni     = ($angka == now()->month && $tahunDipilih == now()->year);
                @endphp

                <div @class([
                    'bg-white border rounded-xl p-4',
                    'border-gray-900 ring-1 ring-gray-900' => $bulanIni,
                    'border-gray-200'                      => !$bulanIni,
                ])>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-800">{{ $nama }}</span>
                            @if ($bulanIni)
                                <span class="text-[10px] font-medium bg-gray-900 text-white px-1.5 py-0.5 rounded-full">Sekarang</span>
                            @endif
                        </div>
                        @if ($anggaran)
                            @if ($persenAktual >= 100)
                                <span class="text-[10px] font-semibold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">Melampaui</span>
                            @elseif ($persenAktual >= 80)
                                <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">Peringatan</span>
                            @else
                                <span class="text-[10px] font-semibold text-green-600 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">Aman</span>
                            @endif
                        @endif
                    </div>

                    @if ($anggaran)
                        {{-- Progress bar --}}
                        <div class="mb-2">
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                <span>Terpakai {{ number_format($persenAktual, 0) }}%</span>
                                <span>Rp {{ number_format($pengeluaran, 0, ',', '.') }}</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div @class([
                                    'h-full rounded-full transition-all',
                                    'bg-red-500'   => $persenAktual >= 100,
                                    'bg-amber-400' => $persenAktual >= 80 && $persenAktual < 100,
                                    'bg-green-500' => $persenAktual < 80,
                                ]) style="width: {{ $persen }}%"></div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">
                            Anggaran: <span class="font-medium text-gray-600">Rp {{ number_format($anggaran->nominal_anggaran, 0, ',', '.') }}</span>
                        </p>
                    @else
                        <div class="text-center py-3">
                            <p class="text-xs text-gray-400 mb-2">Belum ada anggaran</p>
                            <p class="text-xs text-gray-300">Pengeluaran: Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
