@extends('layouts.aplikasi')

@section('judul', 'Anggaran')

@section('konten')

{{-- ===== HEADER ===== --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Anggaran Bulanan</h2>
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
                            <option value="{{ $angka }}" @selected(old('bulan', $bulanDipilih) == $angka)>{{ $nama }}</option>
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
                               value="{{ old('nominal_anggaran', $anggaran ? $anggaran->nominal_anggaran : '') }}"
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

    {{-- ===== KOLOM KANAN: DETAIL ANGGARAN BULAN TERPILIH ===== --}}
    <div class="lg:col-span-2">

        {{-- Filter tahun & bulan --}}
        <form method="GET" action="{{ route('anggaran.indeks') }}" class="flex flex-wrap items-center gap-4 mb-6 bg-white p-4 border border-gray-200 rounded-xl">
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Tahun:</span>
                <select name="tahun" onchange="this.form.submit()"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900">
                    @foreach ($daftarTahun as $tahun)
                        <option value="{{ $tahun }}" @selected($tahun == $tahunDipilih)>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Bulan:</span>
                <select name="bulan" onchange="this.form.submit()"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900">
                    <option value="all" @selected($bulanDipilih === 'all')>Semua Bulan</option>
                    @foreach ($namaBulan as $angka => $nama)
                        <option value="{{ $angka }}" @selected($angka == $bulanDipilih)>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            @if ($bulanDipilih != now()->month || $tahunDipilih != now()->year)
                <a href="{{ route('anggaran.indeks') }}" 
                   class="ml-auto px-3 py-2 text-xs font-semibold text-gray-900 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Bulan Ini
                </a>
            @endif
        </form>

        @if ($bulanDipilih === 'all')
            {{-- Tampilan Grid 12 Bulan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($namaBulan as $angka => $nama)
                    @php
                        $anggaranItem     = $daftarAnggaran->get($angka);
                        $pengeluaranItem  = $pengeluaranPerBulan[$angka];
                        $persen           = ($anggaranItem && $anggaranItem->nominal_anggaran > 0)
                                            ? min(($pengeluaranItem / $anggaranItem->nominal_anggaran) * 100, 100)
                                            : 0;
                        $persenAktual     = ($anggaranItem && $anggaranItem->nominal_anggaran > 0)
                                            ? ($pengeluaranItem / $anggaranItem->nominal_anggaran) * 100
                                            : 0;
                        $bulanIni         = ($angka == now()->month && $tahunDipilih == now()->year);
                    @endphp

                    <div @class([
                        'bg-white border rounded-xl p-4 shadow-sm',
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
                            @if ($anggaranItem)
                                @if ($persenAktual >= 100)
                                    <span class="text-[10px] font-semibold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">Melampaui</span>
                                @elseif ($persenAktual >= 80)
                                    <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">Peringatan</span>
                                @else
                                    <span class="text-[10px] font-semibold text-green-600 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">Aman</span>
                                @endif
                            @endif
                        </div>

                        @if ($anggaranItem)
                            {{-- Progress bar --}}
                            <div class="mb-3">
                                <div class="flex items-center justify-between text-[11px] text-gray-500 mb-1">
                                    <span>Terpakai {{ number_format($persenAktual, 0) }}%</span>
                                    <span>Rp {{ number_format($pengeluaranItem, 0, ',', '.') }}</span>
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
                            <div class="flex items-center justify-between border-t border-gray-50 pt-2">
                                <p class="text-xs text-gray-400">
                                    Anggaran: <span class="font-medium text-gray-600">Rp {{ number_format($anggaranItem->nominal_anggaran, 0, ',', '.') }}</span>
                                </p>
                                <a href="{{ route('anggaran.indeks', ['tahun' => $tahunDipilih, 'bulan' => $angka]) }}" class="text-[10px] text-gray-900 hover:underline font-semibold flex items-center gap-0.5">
                                    Detail
                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-2">
                                <p class="text-xs text-gray-400 mb-2">Belum ada anggaran</p>
                                <div class="flex items-center justify-between border-t border-gray-50 pt-2">
                                    <p class="text-[11px] text-gray-400">Pengeluaran: Rp {{ number_format($pengeluaranItem, 0, ',', '.') }}</p>
                                    <a href="{{ route('anggaran.indeks', ['tahun' => $tahunDipilih, 'bulan' => $angka]) }}" class="text-[10px] text-gray-900 hover:underline font-semibold flex items-center gap-0.5">
                                        Atur
                                        <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            {{-- Tampilan Satu Bulan Terpilih --}}
            @php
                $persen       = ($anggaran && $anggaran->nominal_anggaran > 0)
                                    ? min(($pengeluaran / $anggaran->nominal_anggaran) * 100, 100)
                                    : 0;
                $persenAktual = ($anggaran && $anggaran->nominal_anggaran > 0)
                                    ? ($pengeluaran / $anggaran->nominal_anggaran) * 100
                                    : 0;
                $sisa         = $anggaran ? ($anggaran->nominal_anggaran - $pengeluaran) : 0;
                $bulanIni     = ($bulanDipilih == now()->month && $tahunDipilih == now()->year);
            @endphp
            <div @class([
                'bg-white border rounded-xl p-6 shadow-sm',
                'border-gray-900 ring-1 ring-gray-900' => $bulanIni,
                'border-gray-200'                      => !$bulanIni,
            ])>
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            {{ $namaBulan[$bulanDipilih] }} {{ $tahunDipilih }}
                            @if ($bulanIni)
                                <span class="text-xs font-semibold bg-gray-900 text-white px-2.5 py-0.5 rounded-full">Bulan Ini</span>
                            @endif
                        </h3>
                        <p class="text-sm text-gray-400 mt-1">Status dan pemantauan anggaran bulan yang dipilih.</p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if ($anggaran)
                            @if ($persenAktual >= 100)
                                <span class="text-xs font-semibold text-red-600 bg-red-50 border border-red-200 px-3 py-1 rounded-full">Melampaui Anggaran</span>
                            @elseif ($persenAktual >= 80)
                                <span class="text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full">Peringatan (≥ 80%)</span>
                            @else
                                <span class="text-xs font-semibold text-green-600 bg-green-50 border border-green-200 px-3 py-1 rounded-full">Anggaran Aman</span>
                            @endif

                            <form method="POST" action="{{ route('anggaran.hapus', $anggaran->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggaran bulan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    Hapus Anggaran
                                </button>
                            </form>
                        @else
                            <span class="text-xs font-semibold text-gray-500 bg-gray-50 border border-gray-200 px-3 py-1 rounded-full">Belum Ditentukan</span>
                        @endif
                    </div>
                </div>

                @if ($anggaran)
                    {{-- Progress bar --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                            <span class="font-medium">Terpakai {{ number_format($persenAktual, 1, ',', '.') }}%</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($pengeluaran, 0, ',', '.') }} / Rp {{ number_format($anggaran->nominal_anggaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div @class([
                                'h-full rounded-full transition-all duration-500',
                                'bg-red-500'   => $persenAktual >= 100,
                                'bg-amber-400' => $persenAktual >= 80 && $persenAktual < 100,
                                'bg-green-500' => $persenAktual < 80,
                            ]) style="width: {{ $persen }}%"></div>
                        </div>
                    </div>

                    {{-- Detail stats --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-100 pt-6">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-400 font-medium block mb-1">Total Anggaran</span>
                            <span class="text-base font-bold text-gray-900">Rp {{ number_format($anggaran->nominal_anggaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-400 font-medium block mb-1">Total Pengeluaran</span>
                            <span class="text-base font-bold text-gray-900">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-4 rounded-xl {{ $sisa < 0 ? 'bg-red-50 text-red-900' : 'bg-green-50 text-green-900' }}">
                            <span class="text-xs {{ $sisa < 0 ? 'text-red-500' : 'text-green-600' }} font-medium block mb-1">
                                {{ $sisa < 0 ? 'Kelebihan Pengeluaran' : 'Sisa Anggaran' }}
                            </span>
                            <span class="text-base font-bold">
                                Rp {{ number_format(abs($sisa), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-xl">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-500 mb-1">Belum ada anggaran untuk bulan ini</p>
                        <p class="text-xs text-gray-400 mb-4">Silakan atur anggaran di panel sebelah kiri.</p>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 rounded-lg text-xs font-semibold text-gray-600">
                            Pengeluaran Aktual saat ini: Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

</div>

@endsection
