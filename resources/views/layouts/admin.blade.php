<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Flash-Tix</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-900 text-white hidden md:block">
            <div class="p-6 text-2xl font-bold border-b border-slate-800">
                <i class="fas fa-ticket-alt text-purple-500 mr-2"></i> Flash-Tix
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800 transition">
                    <i class="fas fa-chart-pie mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.concerts.index') }}" class="block px-4 py-3 rounded-xl bg-purple-600 shadow-lg transition">
                    <i class="fas fa-microphone-alt mr-2"></i> Kelola Konser
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800 transition">
                    <i class="fas fa-receipt mr-2"></i> Transaksi
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">@yield('page-title')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-600">{{ Auth::user()->name }}</span>
                    <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>