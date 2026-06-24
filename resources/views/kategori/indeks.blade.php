@extends('layouts.aplikasi')

@section('judul', 'Kategori')

@section('konten')

{{-- ===== HEADER ===== --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Manajemen Kategori</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola kategori transaksi Anda.</p>
    </div>
</div>

{{-- ===== FLASH MESSAGE ===== --}}
@if (session('sukses'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
        <svg class="w-4 h-4 shrink-0 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('sukses') }}
    </div>
@endif

@if (session('galat'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
        <svg class="w-4 h-4 shrink-0 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        {{ session('galat') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- ===== KOLOM KIRI: KATEGORI SAYA ===== --}}
    <div>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

            {{-- Header seksi --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Kategori Saya</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kategori yang bisa Anda ubah dan hapus</p>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                    {{ $kategoriSaya->count() }} kategori
                </span>
            </div>

            {{-- Form tambah kategori --}}
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                <p class="text-xs font-medium text-gray-600 mb-2">Tambah Kategori Baru</p>
                <form method="POST" action="{{ route('kategori.simpan') }}" class="flex items-start gap-2">
                    @csrf
                    <div class="flex-1">
                        <input type="text"
                               name="nama_kategori"
                               value="{{ old('nama_kategori') }}"
                               placeholder="Nama kategori..."
                               maxlength="50"
                               class="w-full px-3 py-2 text-sm border @error('nama_kategori') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        @error('nama_kategori')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Tambah
                    </button>
                </form>
            </div>

            {{-- Daftar kategori milik user --}}
            @if ($kategoriSaya->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center px-6">
                    <svg class="w-10 h-10 text-gray-300 mb-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                    <p class="text-sm text-gray-400">Belum ada kategori kustom.</p>
                    <p class="text-xs text-gray-400 mt-1">Tambahkan kategori di atas.</p>
                </div>
            @else
                <ul class="divide-y divide-gray-50">
                    @foreach ($kategoriSaya as $kategori)
                        <li class="px-5 py-3" id="baris-kategori-{{ $kategori->id }}">

                            {{-- Tampilan normal --}}
                            <div data-view="{{ $kategori->id }}" class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                                    </div>
                                    <span class="text-sm text-gray-800">{{ $kategori->nama_kategori }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    {{-- Tombol ubah --}}
                                    <button type="button"
                                            onclick="tampilkanFormUbah({{ $kategori->id }})"
                                            class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                            title="Ubah">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    </button>
                                    {{-- Tombol hapus --}}
                                    <form method="POST" action="{{ route('kategori.hapus', $kategori->id) }}"
                                          onsubmit="return confirm('Hapus kategori \'{{ addslashes($kategori->nama_kategori) }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Hapus">
                                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Form ubah inline (tersembunyi) --}}
                            <div data-edit="{{ $kategori->id }}" class="hidden mt-2">
                                <form method="POST" action="{{ route('kategori.perbarui', $kategori->id) }}"
                                      class="flex items-start gap-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex-1">
                                        <input type="text"
                                               name="nama_kategori"
                                               value="{{ old('nama_kategori_edit_' . $kategori->id, $kategori->nama_kategori) }}"
                                               maxlength="50"
                                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                    </div>
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
                                        Simpan
                                    </button>
                                    <button type="button"
                                            onclick="sembunyikanFormUbah({{ $kategori->id }})"
                                            class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-lg transition-colors">
                                        Batal
                                    </button>
                                </form>
                            </div>

                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>

    {{-- ===== KOLOM KANAN: KATEGORI DEFAULT ===== --}}
    <div>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

            {{-- Header seksi --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Kategori Default</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kategori bawaan sistem, tidak bisa diubah</p>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                    {{ $kategoriDefault->count() }} kategori
                </span>
            </div>

            {{-- Daftar kategori default --}}
            <ul class="divide-y divide-gray-50">
                @foreach ($kategoriDefault as $kategori)
                    <li class="flex items-center gap-2.5 px-5 py-3">
                        <div class="w-6 h-6 bg-blue-50 rounded flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                        </div>
                        <span class="text-sm text-gray-700">{{ $kategori->nama_kategori }}</span>
                        <span class="ml-auto text-[10px] font-medium text-blue-500 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full">default</span>
                    </li>
                @endforeach
            </ul>

        </div>

        {{-- Info box --}}
        <div class="mt-4 flex items-start gap-3 px-4 py-3 bg-amber-50 border border-amber-200 rounded-lg">
            <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <p class="text-xs text-amber-700">
                Kategori default tersedia untuk semua pengguna dan tidak dapat diubah atau dihapus.
                Tambahkan kategori kustom di sebelah kiri jika Anda membutuhkan kategori tambahan.
            </p>
        </div>
    </div>

</div>

@endsection

@push('skrip')
<script>
function tampilkanFormUbah(id) {
    document.querySelector('[data-view="' + id + '"]').classList.add('hidden');
    document.querySelector('[data-edit="' + id + '"]').classList.remove('hidden');
    document.querySelector('[data-edit="' + id + '"] input').focus();
}

function sembunyikanFormUbah(id) {
    document.querySelector('[data-edit="' + id + '"]').classList.add('hidden');
    document.querySelector('[data-view="' + id + '"]').classList.remove('hidden');
}
</script>
@endpush
