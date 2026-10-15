<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Garden Bloom') | Botanical Inventory Management</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        garden: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            950: '#052e16',
                        },
                        amber: {
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f8faf8;
            color: #1e293b;
        }
        .botanical-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#15803d 0.75px, transparent 0.75px), radial-gradient(#15803d 0.75px, #ffffff 0.75px);
            background-size: 30px 30px;
            background-position: 0 0, 15px 15px;
            opacity: 0.98;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 9999px;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col font-sans antialiased text-slate-800">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 glass-nav border-b border-emerald-100 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-garden-700 to-emerald-500 flex items-center justify-center text-white shadow-md shadow-garden-600/20 group-hover:scale-105 transition-transform duration-300">
                            <i class="fa-solid fa-leaf text-2xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="font-serif text-2xl font-bold tracking-tight text-garden-900 group-hover:text-garden-700 transition-colors">Garden Bloom</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-garden-100 text-garden-800 border border-garden-200">
                                    Nursery IMS
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 font-medium">Sistem Inventaris Tanaman Hias & Botani</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2 {{ request()->routeIs('dashboard') ? 'bg-garden-50 text-garden-800 shadow-sm border border-garden-200' : 'text-slate-600 hover:text-garden-700 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-chart-pie text-garden-600"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2 {{ request()->routeIs('products.*') ? 'bg-garden-50 text-garden-800 shadow-sm border border-garden-200' : 'text-slate-600 hover:text-garden-700 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-seedling text-garden-600"></i>
                        <span>Daftar Tanaman</span>
                    </a>

                    <a href="{{ route('categories.index') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center space-x-2 {{ request()->routeIs('categories.*') ? 'bg-garden-50 text-garden-800 shadow-sm border border-garden-200' : 'text-slate-600 hover:text-garden-700 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-tags text-garden-600"></i>
                        <span>Kategori</span>
                    </a>
                </nav>

                <!-- Action Button -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('products.create') }}" 
                       class="inline-flex items-center space-x-2 bg-garden-700 hover:bg-garden-800 text-white font-medium px-4 py-2.5 rounded-xl shadow-md shadow-garden-700/25 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 text-sm">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Tanaman</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Global Alert Banners (Flash Messages) -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div id="flash-success" class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 shadow-sm flex items-start space-x-3.5 transition-all duration-300">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-check text-lg"></i>
                </div>
                <div class="flex-grow pt-1">
                    <h4 class="text-sm font-bold text-emerald-900">Operasi Berhasil</h4>
                    <p class="text-sm text-emerald-800 mt-0.5">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="document.getElementById('flash-success').remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="flash-error" class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 shadow-sm flex items-start space-x-3.5 transition-all duration-300">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                </div>
                <div class="flex-grow pt-1">
                    <h4 class="text-sm font-bold text-rose-900">Perhatian / Peringatan</h4>
                    <p class="text-sm text-rose-800 mt-0.5">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="document.getElementById('flash-error').remove()" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-2xl bg-amber-50 border border-amber-200 p-4 shadow-sm flex items-start space-x-3.5">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                </div>
                <div class="flex-grow pt-1">
                    <h4 class="text-sm font-bold text-amber-900">Terdapat kesalahan pengisian form:</h4>
                    <ul class="list-disc list-inside text-sm text-amber-800 mt-1 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Main Content Slot -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto bg-white border-t border-slate-200/80 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-garden-700 text-white flex items-center justify-center text-sm shadow">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div>
                        <span class="font-serif font-bold text-slate-800">Garden Bloom Inventory</span>
                        <span class="text-xs text-slate-500 block">Pertemuan 5 - Laravel CRUD Fundamental (MVC Architecture)</span>
                    </div>
                </div>

                <div class="flex items-center space-x-6 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-code-branch text-garden-600"></i> Laravel 12.x</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-database text-garden-600"></i> Eloquent ORM</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-garden-600"></i> CSRF & Validation</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
