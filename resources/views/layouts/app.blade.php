<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Flash-Tix - Tiket Konser Online')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js untuk dropdown notifikasi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        /* ============================================ */
        /* DARK MODE VARIABLES */
        /* ============================================ */
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --bg-navbar: #ffffff;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --border-color: #e2e8f0;
            --bg-input: #ffffff;
            --hover-bg: #f3e8ff;
        }
        
        body.dark-mode {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-navbar: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --bg-input: #334155;
            --hover-bg: #2d3748;
        }
        
        body {
            background-color: var(--bg-body);
            transition: background-color 0.3s ease;
        }
        
        /* NAVBAR - SOLID PUTIH, TIDAK TRANSPARAN */
        .navbar-fixed {
            background-color: var(--bg-navbar);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        /* LOGO */
        @keyframes floatTicket {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-5px) rotate(5deg); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .logo-icon {
            animation: floatTicket 3s ease-in-out infinite;
            font-size: 32px;
            color: #7c3aed;
        }
        
        .logo-text {
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, #7c3aed 0%, #c084fc 30%, #ec4899 70%, #7c3aed 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }
        
        .logo-tagline {
            font-size: 9px;
            color: var(--text-secondary);
        }
        
        /* NAV LINK */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            color: var(--text-primary);
            font-weight: 500;
            padding: 8px 0;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2.5px;
            background: linear-gradient(90deg, #7c3aed, #ec4899);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .nav-link:hover {
            color: #7c3aed;
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            color: #7c3aed;
            font-weight: 600;
        }
        
        .nav-link.active::after {
            width: 100%;
        }
        
        /* BUTTON */
        .btn-register {
            background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
            border-radius: 40px;
            padding: 8px 22px;
            font-weight: 500;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124,58,237,0.4);
        }
        
        .btn-login {
            transition: all 0.3s ease;
            color: var(--text-primary);
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: 500;
        }
        
        .btn-login:hover {
            color: #7c3aed;
            background: var(--hover-bg);
        }
        
        .main-content {
            padding-top: 80px;
            min-height: 100vh;
        }
        
        .navbar-scrolled {
            background: var(--bg-navbar);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        /* Card dan konten lainnya */
        .bg-white {
            background-color: var(--bg-card) !important;
        }
        
        .text-gray-800, .text-gray-700, .text-gray-900 {
            color: var(--text-primary) !important;
        }
        
        .text-gray-500, .text-gray-600 {
            color: var(--text-secondary) !important;
        }
        
        .border-gray-200, .border-gray-100, .border-gray-300 {
            border-color: var(--border-color) !important;
        }
        
        .bg-gray-50 {
            background-color: var(--bg-body) !important;
        }
        
        /* Avatar Image Style */
        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Animasi bounce untuk notifikasi */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        
        .animate-bounce {
            animation: bounce 0.5s ease infinite;
        }
        
        @media (max-width: 768px) {
            .main-content { padding-top: 70px; }
            .logo-text { font-size: 16px; }
            .logo-icon { font-size: 24px; }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    
    <!-- NAVBAR - SOLID WHITE -->
    <nav class="navbar-fixed fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-center h-16 md:h-20">
                
                <!-- LOGO -->
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <i class="fas fa-ticket-alt logo-icon"></i>
                    <div class="flex flex-col">
                        <span class="logo-text">Flash-Tix</span>
                        <span class="logo-tagline">#1 Tiket Konser Indonesia</span>
                    </div>
                </a>
                
                <!-- MENU NAVIGASI UTAMA -->
                @auth
                    <div class="hidden md:flex items-center gap-6">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                                <i class="fas fa-chart-line mr-1.5 text-purple-400"></i> Statistik
                            </a>
                            <a href="{{ route('admin.concerts.index') }}" class="nav-link {{ request()->is('admin/concerts*') ? 'active' : '' }}">
                                <i class="fas fa-microphone-alt mr-1.5 text-purple-400"></i> Kelola Konser
                            </a>
                            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                                <i class="fas fa-receipt mr-1.5 text-purple-400"></i> Data Pesanan
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home mr-1.5 text-purple-400"></i> Beranda
                            </a>
                            <a href="{{ route('concerts.index') }}" class="nav-link {{ request()->is('concerts*') ? 'active' : '' }}">
                                <i class="fas fa-ticket-alt mr-1.5 text-purple-400"></i> Cari Tiket
                            </a>
                            <a href="{{ route('my-bookings') }}" class="nav-link {{ request()->routeIs('my-bookings*') ? 'active' : '' }}">
                                <i class="fas fa-receipt mr-1.5 text-purple-400"></i> Tiket Saya
                            </a>
                            <a href="{{ route('wishlist') }}" class="nav-link {{ request()->routeIs('wishlist*') ? 'active' : '' }}">
                                <i class="fas fa-heart mr-1.5 text-purple-400"></i> Wishlist
                            </a>
                            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
                                <i class="fas fa-user-cog mr-1.5 text-purple-400"></i> Profil
                            </a>
                        @endif
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="fas fa-home mr-1.5 text-purple-400"></i> Beranda
                        </a>
                        <a href="{{ route('concerts.index') }}" class="nav-link {{ request()->is('concerts*') ? 'active' : '' }}">
                            <i class="fas fa-music mr-1.5 text-purple-400"></i> Jadwal Konser
                        </a>
                        <a href="{{ route('how-it-works') }}" class="nav-link {{ request()->is('cara-kerja*') ? 'active' : '' }}">
                            <i class="fas fa-play-circle mr-1.5 text-purple-400"></i> Cara Kerja
                        </a>
                        <a href="{{ route('contact') }}" class="nav-link {{ request()->is('kontak*') ? 'active' : '' }}">
                            <i class="fas fa-headset mr-1.5 text-purple-400"></i> Kontak
                        </a>
                    </div>
                @endauth
                
                <!-- AUTH SECTION - NOTIFICATION BELL & DROPDOWN PROFILE -->
                <div class="flex items-center gap-3">
                    
                    <!-- ============================================ -->
                    <!-- NOTIFICATION BELL - LONCENG NOTIFIKASI -->
                    <!-- ============================================ -->
                    @auth
                    <div class="relative inline-block text-left mr-1" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 text-slate-400 hover:text-purple-600 transition focus:outline-none rounded-full hover:bg-purple-50">
                            <i class="fas fa-bell text-lg"></i>
                            
                            <!-- Badge jumlah notifikasi belum dibaca -->
                            <span id="notifBadge" class="absolute top-0 right-0 bg-rose-500 text-white text-[9px] font-black min-w-[16px] h-4 rounded-full flex items-center justify-center shadow-sm hidden">
                                0
                            </span>
                        </button>

                        <!-- Dropdown Notifikasi -->
                        <div x-show="open" @click.away="open = false" x-cloak style="display: none;" class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-xl z-50 overflow-hidden">
                            <div class="px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                                <span class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider">
                                    <i class="fas fa-bell mr-1 text-purple-500"></i> Notifikasi
                                </span>
                                <button onclick="markAllNotificationsAsRead()" class="text-[10px] font-bold text-purple-600 hover:underline">
                                    Tandai semua
                                </button>
                            </div>

                            <div id="notificationDropdownList" class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700">
                                <div class="p-6 text-center text-slate-400">
                                    <i class="fas fa-spinner fa-spin text-lg mb-2 block"></i>
                                    <p class="text-[11px]">Memuat notifikasi...</p>
                                </div>
                            </div>
                            
                            <div class="px-4 py-2 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 text-center">
                                <a href="{{ route('notifications') }}" class="text-[10px] text-purple-600 font-semibold hover:underline">
                                    Lihat semua notifikasi →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endauth
                    
                    <!-- PROFILE DROPDOWN -->
                    @auth
                        <div class="relative" id="profileDropdown">
                            <button id="profileButton" 
                                    class="flex items-center gap-2 px-3 py-2 rounded-full bg-purple-100 hover:bg-purple-200 transition border border-purple-300">
                                
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm overflow-hidden border border-purple-400/50 shadow-sm">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                
                                <span class="font-medium text-gray-700 dark:text-gray-200 hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform duration-200 hidden sm:inline" id="dropdownArrow"></i>
                            </button>
                            
                            <div id="dropdownMenu" class="absolute right-0 mt-2 w-64 bg-white dark:bg-slate-800 rounded-xl shadow-2xl z-50 hidden border border-gray-200 dark:border-slate-700 overflow-hidden">
                                <!-- Header dengan Foto Profil -->
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold overflow-hidden">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                            @if(Auth::user()->role === 'admin')
                                                <span class="text-xs text-purple-500 font-semibold">Administrator</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Menu Items -->
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-chart-line w-5 text-purple-500"></i> Dashboard Admin
                                    </a>
                                    <a href="{{ route('admin.concerts.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-microphone-alt w-5 text-purple-500"></i> Kelola Konser
                                    </a>
                                    <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-receipt w-5 text-purple-500"></i> Data Pesanan
                                    </a>
                                    <div class="border-t border-gray-100 dark:border-slate-700 my-1"></div>
                                @else
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-tachometer-alt w-5 text-purple-500"></i> Dashboard
                                    </a>
                                    <a href="{{ route('concerts.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-ticket-alt w-5 text-purple-500"></i> Cari Konser
                                    </a>
                                    <a href="{{ route('my-bookings') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-receipt w-5 text-purple-500"></i> Tiket Saya
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-heart w-5 text-purple-500"></i> Wishlist
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                        <i class="fas fa-user-edit w-5 text-purple-500"></i> Edit Profil
                                    </a>
                                    <div class="border-t border-gray-100 dark:border-slate-700 my-1"></div>
                                @endif
                                
                                <!-- Menu Umum -->
                                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                    <i class="fas fa-home w-5 text-purple-500"></i> Beranda
                                </a>
                                <a href="{{ route('concerts.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                    <i class="fas fa-music w-5 text-purple-500"></i> Konser
                                </a>
                                <a href="{{ route('how-it-works') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                    <i class="fas fa-play-circle w-5 text-purple-500"></i> Cara Kerja
                                </a>
                                <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                                    <i class="fas fa-headset w-5 text-purple-500"></i> Kontak
                                </a>
                                
                                <div class="border-t border-gray-100 dark:border-slate-700 my-1"></div>
                                
                                <!-- Dark Mode Toggle -->
                                <div id="darkModeToggle" class="flex items-center justify-between px-4 py-3 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-moon w-5 text-purple-500"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Mode Gelap</span>
                                    </div>
                                    <div id="darkModeSwitch" class="w-10 h-5 bg-gray-300 dark:bg-gray-600 rounded-full relative transition duration-300">
                                        <div class="w-4 h-4 bg-white rounded-full absolute top-0.5 left-0.5 transition duration-300"></div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-100 dark:border-slate-700 my-1"></div>
                                
                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                        <i class="fas fa-sign-out-alt w-5"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                    @else
                        <a href="{{ route('login') }}" class="btn-login transition flex items-center gap-1">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-register transition flex items-center gap-2">
                            <i class="fas fa-user-plus"></i> Daftar
                            <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- MAIN CONTENT -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white pt-12 pb-6 mt-16">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2024 Flash-Tix. All rights reserved.
        </div>
    </footer>
    
    <script>
        // DROPDOWN TOGGLE
        const profileButton = document.getElementById('profileButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownArrow = document.getElementById('dropdownArrow');
        
        if (profileButton) {
            profileButton.addEventListener('click', function(e) {
                e.stopPropagation();
                if (dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.remove('hidden');
                    if (dropdownArrow) dropdownArrow.style.transform = 'rotate(180deg)';
                } else {
                    dropdownMenu.classList.add('hidden');
                    if (dropdownArrow) dropdownArrow.style.transform = 'rotate(0deg)';
                }
            });
        }
        
        document.addEventListener('click', function() {
            if (dropdownMenu && !dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.add('hidden');
                if (dropdownArrow) dropdownArrow.style.transform = 'rotate(0deg)';
            }
        });
        
        if (dropdownMenu) {
            dropdownMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
        
        // DARK MODE TOGGLE
        const darkModeToggleBtn = document.getElementById('darkModeToggle');
        const darkModeSwitchBtn = document.getElementById('darkModeSwitch');
        const toggleCircleBtn = darkModeSwitchBtn?.querySelector('div');
        
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            if (darkModeSwitchBtn) {
                darkModeSwitchBtn.classList.add('bg-purple-600');
                darkModeSwitchBtn.classList.remove('bg-gray-300');
            }
            if (toggleCircleBtn) toggleCircleBtn.style.transform = 'translateX(20px)';
        }
        
        if (darkModeToggleBtn) {
            darkModeToggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                document.body.classList.toggle('dark-mode');
                
                if (document.body.classList.contains('dark-mode')) {
                    localStorage.setItem('darkMode', 'enabled');
                    if (darkModeSwitchBtn) {
                        darkModeSwitchBtn.classList.add('bg-purple-600');
                        darkModeSwitchBtn.classList.remove('bg-gray-300');
                    }
                    if (toggleCircleBtn) toggleCircleBtn.style.transform = 'translateX(20px)';
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                    if (darkModeSwitchBtn) {
                        darkModeSwitchBtn.classList.remove('bg-purple-600');
                        darkModeSwitchBtn.classList.add('bg-gray-300');
                    }
                    if (toggleCircleBtn) toggleCircleBtn.style.transform = 'translateX(0px)';
                }
            });
        }
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50 && navbar) {
                navbar.classList.add('navbar-scrolled');
            } else if (navbar) {
                navbar.classList.remove('navbar-scrolled');
            }
        });
        
        // ============================================
        // NOTIFICATION FUNCTIONS
        // ============================================
        
        // Ambil notifikasi dari server
        async function fetchNotifications() {
            try {
                // PERUBAHAN: Menggunakan route('notifications') bukan route('notifications.get')
                const response = await fetch('{{ route("notifications") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    updateNotificationUI(data.data, data.unread_count);
                }
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        }
        
        // Update UI notifikasi
        function updateNotificationUI(notifications, unreadCount) {
            const badge = document.getElementById('notifBadge');
            const dropdownList = document.getElementById('notificationDropdownList');
            
            // Update badge
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                badge.classList.remove('hidden');
                // Animasi bounce
                badge.style.animation = 'bounce 0.5s ease';
                setTimeout(() => {
                    if (badge) badge.style.animation = '';
                }, 500);
            } else {
                badge.classList.add('hidden');
            }
            
            // Update dropdown list
            if (!notifications || notifications.length === 0) {
                dropdownList.innerHTML = `
                    <div class="p-6 text-center text-slate-400">
                        <i class="fas fa-bell-slash text-lg mb-2 block"></i>
                        <p class="text-[11px] font-medium">Belum ada notifikasi baru</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            notifications.forEach(notif => {
                const isUnread = !notif.is_read;
                const timeAgo = getTimeAgo(notif.created_at);
                html += `
                    <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition flex gap-3 cursor-pointer ${isUnread ? 'bg-purple-50/30 dark:bg-purple-900/20' : ''}" 
                         onclick="markNotificationAsRead('${notif.id}')">
                        <div class="w-8 h-8 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 flex-shrink-0 mt-0.5">
                            <i class="fas fa-ticket-alt text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-xs font-bold text-slate-800 dark:text-white">${escapeHtml(notif.title) || 'Notifikasi'}</h5>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">${escapeHtml(notif.message) || ''}</p>
                            <span class="text-[9px] text-slate-400 block mt-1">
                                <i class="far fa-clock mr-1"></i> ${timeAgo}
                                ${isUnread ? '<span class="ml-2 text-blue-500">● Baru</span>' : ''}
                            </span>
                        </div>
                    </div>
                `;
            });
            dropdownList.innerHTML = html;
        }
        
        // Escape HTML untuk keamanan
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Tandai satu notifikasi sebagai dibaca
        async function markNotificationAsRead(id) {
            try {
                const response = await fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    fetchNotifications();
                }
            } catch (error) {
                console.error('Error marking notification:', error);
            }
        }
        
        // Tandai semua notifikasi sebagai dibaca
        async function markAllNotificationsAsRead() {
            try {
                const response = await fetch('{{ route("notifications.mark-all-read") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    fetchNotifications();
                }
            } catch (error) {
                console.error('Error marking all notifications:', error);
            }
        }
        
        // Format waktu
        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000);
            
            if (diff < 60) return 'Baru saja';
            if (diff < 3600) return `${Math.floor(diff / 60)} menit lalu`;
            if (diff < 86400) return `${Math.floor(diff / 3600)} jam lalu`;
            if (diff < 604800) return `${Math.floor(diff / 86400)} hari lalu`;
            return date.toLocaleDateString('id-ID');
        }
        
        // Jalankan fetch notifikasi setiap 30 detik
        @auth
        fetchNotifications();
        setInterval(fetchNotifications, 30000);
        @endauth
    </script>
    
    @stack('scripts')
</body>
</html>