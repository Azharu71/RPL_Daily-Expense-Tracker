@extends('layouts.aplikasi')

@section('judul', 'Laporan Keuangan')

@section('konten')

{{-- ===== HEADER ===== --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Laporan Keuangan</h2>
        <p class="text-sm text-gray-400 mt-0.5">Analisis tren pemasukan dan pengeluaran Anda.</p>
    </div>
</div>

{{-- ===== FILTER PERIODE ===== --}}
<form method="GET" action="{{ route('laporan.indeks') }}" class="flex flex-wrap items-end gap-3 mb-6 p-4 bg-white border border-gray-200 rounded-xl">

    {{-- Pilih Tahun --}}
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
        <select name="tahun"
                class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
            @foreach ($daftarTahun as $tahun)
                <option value="{{ $tahun }}" @selected($tahun == $tahunDipilih)>{{ $tahun }}</option>
            @endforeach
        </select>
    </div>

    {{-- Pilih Bulan --}}
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Bulan (opsional)</label>
        <select name="bulan"
                class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
            <option value="">Semua Bulan</option>
            @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $namaBulan)
                <option value="{{ $i + 1 }}" @selected(($i + 1) == $bulanDipilih)>{{ $namaBulan }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit"
            class="flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Tampilkan
    </button>

    @if ($bulanDipilih !== '')
        <a href="{{ route('laporan.indeks', ['tahun' => $tahunDipilih]) }}"
           class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            Reset Bulan
        </a>
    @endif

</form>

{{-- ===== KARTU RINGKASAN PERIODE ===== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500">Total Pemasukan</p>
            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            </div>
        </div>
        <p class="text-xl font-bold text-green-600">+Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">
            {{ $bulanDipilih ? \Carbon\Carbon::create()->month($bulanDipilih)->translatedFormat('F') . ' ' . $tahunDipilih : 'Tahun ' . $tahunDipilih }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500">Total Pengeluaran</p>
            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
            </div>
        </div>
        <p class="text-xl font-bold text-red-600">-Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">
            {{ $bulanDipilih ? \Carbon\Carbon::create()->month($bulanDipilih)->translatedFormat('F') . ' ' . $tahunDipilih : 'Tahun ' . $tahunDipilih }}
        </p>
    </div>

    <div @class([
        'rounded-xl p-5 text-white',
        'bg-gray-900' => $selisih >= 0,
        'bg-red-700'  => $selisih < 0,
    ])>
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-white/60">Selisih Bersih</p>
            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
        </div>
        <p class="text-xl font-bold">
            {{ $selisih < 0 ? '-' : '+' }}Rp {{ number_format(abs($selisih), 0, ',', '.') }}
        </p>
        <p class="text-xs text-white/40 mt-1">Pemasukan dikurangi pengeluaran</p>
    </div>

</div>

{{-- ===== GRAFIK TREN ===== --}}
<div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Tren Bulanan {{ $tahunDipilih }}</h3>
            <p class="text-xs text-gray-400 mt-0.5">Pemasukan vs pengeluaran per bulan</p>
        </div>
        <div class="flex items-center gap-4 text-xs text-gray-500">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-green-500 inline-block"></span> Pemasukan
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-red-400 inline-block"></span> Pengeluaran
            </span>
        </div>
    </div>
    <div class="relative" style="height: 260px;">
        <canvas id="grafikTren"></canvas>
    </div>
</div>

{{-- ===== TABEL TRANSAKSI ===== --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-900">Detail Transaksi</h3>
        <span class="text-xs text-gray-400">{{ $transaksi->total() }} transaksi ditemukan</span>
    </div>

    @if ($transaksi->isEmpty())
        <div class="flex flex-col items-center justify-center py-14 text-center px-6">
            <svg class="w-10 h-10 text-gray-300 mb-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
            <p class="text-sm text-gray-400">Tidak ada transaksi pada periode ini.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($transaksi as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3.5 text-gray-600 whitespace-nowrap">
                                {{ $item->tanggal->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div @class([
                                        'w-5 h-5 rounded flex items-center justify-center shrink-0',
                                        'bg-green-100' => $item->tipe === 'pemasukan',
                                        'bg-red-100'   => $item->tipe === 'pengeluaran',
                                    ])>
                                        @if ($item->tipe === 'pemasukan')
                                            <svg class="w-2.5 h-2.5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                        @else
                                            <svg class="w-2.5 h-2.5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                                        @endif
                                    </div>
                                    <span class="text-gray-700">{{ $item->category->nama_kategori }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span @class([
                                    'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-700' => $item->tipe === 'pemasukan',
                                    'bg-red-100 text-red-700'     => $item->tipe === 'pengeluaran',
                                ])>
                                    {{ $item->tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right font-semibold whitespace-nowrap @class([
                                'text-green-600' => $item->tipe === 'pemasukan',
                                'text-red-600'   => $item->tipe === 'pengeluaran',
                            ])">
                                {{ $item->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($transaksi->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $transaksi->links() }}
            </div>
        @endif
    @endif

</div>

@endsection

@push('skrip')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const labelBulan    = @json($labelBulan);
    const dataPemasukan  = @json($dataPemasukan);
    const dataPengeluaran = @json($dataPengeluaran);

    const ctx = document.getElementById('grafikTren').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelBulan,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: dataPemasukan,
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(22, 163, 74)',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                },
                {
                    label: 'Pengeluaran',
                    data: dataPengeluaran,
                    backgroundColor: 'rgba(248, 113, 113, 0.8)',
                    borderColor: 'rgb(220, 38, 38)',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            const nilai = ctx.parsed.y;
                            return ' ' + ctx.dataset.label + ': Rp ' + nilai.toLocaleString('id-ID');
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9ca3af', font: { size: 11 } },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: {
                        color: '#9ca3af',
                        font: { size: 11 },
                        callback: function (nilai) {
                            if (nilai >= 1000000) return 'Rp ' + (nilai / 1000000).toFixed(1) + 'jt';
                            if (nilai >= 1000)    return 'Rp ' + (nilai / 1000).toFixed(0) + 'rb';
                            return 'Rp ' + nilai;
                        },
                    },
                },
            },
        },
    });
})();
</script>
@endpush
