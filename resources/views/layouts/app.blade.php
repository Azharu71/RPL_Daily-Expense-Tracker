<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daily Expense Tracker — Kelola keuangan harian Anda dengan mudah. Catat pemasukan & pengeluaran, pantau budget, dan raih tujuan finansial Anda.">
    <title>{{ config('app.name', 'Daily Expense Tracker') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-warm-50 text-gray-800 antialiased">
    @yield('content')
    @stack('skrip')
</body>
</html>
