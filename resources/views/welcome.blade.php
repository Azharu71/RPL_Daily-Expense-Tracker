@extends('layouts.app')

@section('content')
{{-- ========== NAVBAR ========== --}}
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-warm-50/90 backdrop-blur-sm border-b border-gray-200 transition-all duration-300">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        {{-- Logo --}}
        <a href="#" class="flex items-center gap-2.5">
            <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center text-white">
                {{-- lucide: wallet --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
            </div>
            <span class="text-lg font-bold text-gray-900 tracking-tight">Daily ExpenseTracker</span>
        </a>

        {{-- CTA Buttons --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" id="btn-login" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                Masuk
            </a>
            <a href="{{ route('register') }}" id="btn-register" class="px-5 py-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 rounded-lg transition-colors">
                Daftar Gratis
            </a>
        </div>
    </div>
</nav>

{{-- ========== HERO SECTION ========== --}}
<section id="hero" class="pt-32 pb-20 lg:pt-40 lg:pb-32">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            {{-- Left: Text Content --}}
            <div class="text-center lg:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold leading-tight text-gray-900 mb-6 ">
                    Kelola Keuangan Harian Anda dengan Mudah
                </h1>

                <p class="text-lg text-gray-500 leading-relaxed mb-10 max-w-lg mx-auto lg:mx-0 ">
                    Catat setiap pemasukan dan pengeluaran, kelompokkan berdasarkan kategori, dan pantau kesehatan finansial Anda.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start ">
                    <a href="{{ route('register') }}" id="btn-hero-start" class="group inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg transition-colors">
                        Mulai Sekarang
                        {{-- lucide: arrow-right --}}
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Right: Dashboard Preview Card --}}
            <div>
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    {{-- Card Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm text-gray-400">Total Saldo</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">Rp 4.250.000</p>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-green-50 border border-green-200 rounded-full">
                            {{-- lucide: trending-up --}}
                            <svg class="w-3.5 h-3.5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                            <span class="text-xs text-green-700 font-semibold">+12.5%</span>
                        </div>
                    </div>

                    {{-- Trend Line Chart --}}
                    <div class="h-28 mb-6">
                        <svg viewBox="0 0 300 100" class="w-full h-full" preserveAspectRatio="none">
                            {{-- Grid lines --}}
                            <line x1="0" y1="25" x2="300" y2="25" stroke="#F3F4F6" stroke-width="1"/>
                            <line x1="0" y1="50" x2="300" y2="50" stroke="#F3F4F6" stroke-width="1"/>
                            <line x1="0" y1="75" x2="300" y2="75" stroke="#F3F4F6" stroke-width="1"/>
                            {{-- Gradient fill --}}
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#111827" stop-opacity="0.1"/>
                                    <stop offset="100%" stop-color="#111827" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,70 L25,55 L50,62 L75,40 L100,48 L125,30 L150,38 L175,25 L200,32 L225,18 L250,22 L275,12 L300,15 L300,100 L0,100 Z" fill="url(#chartGradient)"/>
                            {{-- Trend line --}}
                            <polyline points="0,70 25,55 50,62 75,40 100,48 125,30 150,38 175,25 200,32 225,18 250,22 275,12 300,15" fill="none" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            {{-- Current point --}}
                            <circle cx="300" cy="15" r="3" fill="#111827"/>
                        </svg>
                    </div>

                    {{-- Recent Transactions --}}
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-3">Transaksi Terakhir</p>

                        <div class="space-y-2">
                            {{-- Transaction: Pemasukan --}}
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                                        {{-- lucide: plus --}}
                                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Gaji Bulanan</p>
                                        <p class="text-xs text-gray-400">Pemasukan</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-green-700">+Rp 5.000.000</span>
                            </div>

                            {{-- Transaction: Pengeluaran --}}
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
                                        {{-- lucide: minus --}}
                                        <svg class="w-4 h-4 text-red-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Makan Siang</p>
                                        <p class="text-xs text-gray-400">Pengeluaran</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-red-600">-Rp 35.000</span>
                            </div>

                            {{-- Transaction: Pengeluaran --}}
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
                                        {{-- lucide: minus --}}
                                        <svg class="w-4 h-4 text-red-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Transportasi</p>
                                        <p class="text-xs text-gray-400">Pengeluaran</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-red-600">-Rp 15.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
