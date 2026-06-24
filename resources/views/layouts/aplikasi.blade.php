<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Dashboard') — {{ config('app.name', 'Daily Expense Tracker') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-warm-50 text-gray-800 antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shrink-0">

        {{-- Logo --}}
        <div class="h-16 flex items-center px-5 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center shrink-0">
                    {{-- lucide: wallet --}}
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                </div>
                <span class="text-sm font-bold text-gray-900 leading-tight">Daily Expense<br>Tracker</span>
            </a>
        </div>

        {{-- Nav Links --}}
        <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">

            {{-- Label --}}
            <p class="px-3 mb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</p>

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
                   'bg-gray-900 text-white'            => request()->routeIs('dashboard'),
                   'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('dashboard'),
               ])>
                {{-- lucide: layout-dashboard --}}
                <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard
            </a>

            {{-- Transaksi --}}
            <a href="{{ route('transaksi.indeks') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
                   'bg-gray-900 text-white'            => request()->routeIs('transaksi.*'),
                   'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('transaksi.*'),
               ])>
                {{-- lucide: arrow-left-right --}}
                <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3 4 7l4 4"/><path d="M4 7h16"/><path d="m16 21 4-4-4-4"/><path d="M20 17H4"/></svg>
                Transaksi
            </a>

            {{-- Kategori --}}
            <a href="{{ route('kategori.indeks') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
                   'bg-gray-900 text-white'            => request()->routeIs('kategori.*'),
                   'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('kategori.*'),
               ])>
                {{-- lucide: tag --}}
                <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                Kategori
            </a>

            {{-- Laporan --}}
            <a href="{{ route('laporan.indeks') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
                   'bg-gray-900 text-white'            => request()->routeIs('laporan.*'),
                   'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('laporan.*'),
               ])>
                {{-- lucide: bar-chart-2 --}}
                <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                Laporan
            </a>

            {{-- Anggaran --}}
            <a href="{{ route('anggaran.indeks') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors',
                   'bg-gray-900 text-white'            => request()->routeIs('anggaran.*'),
                   'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('anggaran.*'),
               ])>
                {{-- lucide: piggy-bank --}}
                <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 5c-1.5 0-2.8 1.4-3 2-3.5-1.5-11-.3-11 5 0 1.8 0 3 2 4.5V20h4v-2h3v2h4v-4c1-.5 1.7-1 2-2h2v-4h-2c0-1-.5-1.5-1-2z"/><path d="M2 9v1a2 2 0 0 0 2 2h1"/><path d="M16 11h.01"/></svg>
                Anggaran
            </a>

        </nav>

        {{-- User Info + Logout --}}
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-xs font-bold text-gray-600">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    {{-- lucide: log-out --}}
                    <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== AREA KONTEN UTAMA ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <h1 class="text-base font-semibold text-gray-900">@yield('judul', 'Dashboard')</h1>

            <div class="flex items-center gap-2 text-sm text-gray-500">
                {{-- lucide: calendar --}}
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </header>

        {{-- Konten Halaman --}}
        <main class="flex-1 overflow-y-auto p-8">
            @yield('konten')
        </main>

    </div>

</div>

@stack('skrip')
</body>
</html>
