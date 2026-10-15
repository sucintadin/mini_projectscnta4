@extends('layouts.app')

@section('title', 'Dashboard Inventaris')

@section('content')
<div class="space-y-8">

    <!-- Top Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-garden-900 via-garden-800 to-emerald-900 p-8 text-white shadow-xl">
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-emerald-200 mb-4">
                <i class="fa-solid fa-sparkles"></i>
                <span>Selamat Datang di Sistem Inventaris Garden Bloom</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight text-white mb-2">
                Kelola Koleksi Tanaman & Stok Nursery dengan Presisi
            </h1>
            <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed">
                Pantau ketersediaan stok, batas minimum persediaan, jadwal perawatan botani, dan valuasi aset inventaris toko secara real-time berbasis Laravel MVC.
            </p>
            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a href="{{ route('products.create') }}" class="inline-flex items-center space-x-2 bg-emerald-400 hover:bg-emerald-300 text-garden-950 font-bold px-5 py-2.5 rounded-xl shadow-md transition-all hover:scale-105 text-sm">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Tambah Tanaman Baru</span>
                </a>
                <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-medium px-5 py-2.5 rounded-xl border border-white/20 transition-all text-sm">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Lihat Semua Produk ({{ $totalProducts }})</span>
                </a>
            </div>
        </div>

        <!-- Decorative Leaves Background Icons -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="fa-solid fa-leaf text-[240px]"></i>
        </div>
    </div>

    <!-- 4 Key Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Tanaman -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Tanaman</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-seedling"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-extrabold text-slate-900">{{ $totalProducts }}</span>
                <span class="text-xs text-slate-500 ml-1">varietas</span>
            </div>
            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                <i class="fa-solid fa-layer-group text-garden-600"></i>
                <span>Terbagi ke {{ $totalCategories }} kategori utama</span>
            </p>
        </div>

        <!-- Total Unit Stok -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Fisik Stok</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-extrabold text-slate-900">{{ number_format($totalStockUnits, 0, ',', '.') }}</span>
                <span class="text-xs text-slate-500 ml-1">pot/unit</span>
            </div>
            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>Tersimpan di rumah kaca & nursery</span>
            </p>
        </div>

        <!-- Peringatan Stok Rendah -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Peringatan Stok</span>
                <div class="w-10 h-10 rounded-xl {{ ($lowStockCount + $outOfStockCount > 0) ? 'bg-amber-50 text-amber-600' : 'bg-slate-50 text-slate-400' }} flex items-center justify-center text-lg">
                    <i class="fa-solid fa-bell"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold {{ ($lowStockCount + $outOfStockCount > 0) ? 'text-amber-600' : 'text-slate-900' }}">
                    {{ $lowStockCount + $outOfStockCount }}
                </span>
                <span class="text-xs font-medium text-slate-500">item butuh restock</span>
            </div>
            <div class="mt-2 text-xs flex items-center gap-3 text-slate-500">
                <span class="text-amber-600 font-semibold"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $lowStockCount }} menipis</span>
                <span class="text-rose-600 font-semibold"><i class="fa-solid fa-circle-xmark mr-1"></i>{{ $outOfStockCount }} habis</span>
            </div>
        </div>

        <!-- Nilai Total Inventaris -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Valuasi Aset Stok</span>
                <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-extrabold text-slate-900">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</span>
            </div>
            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up text-garden-600"></i>
                <span>Nilai kotor berdasarkan harga jual</span>
            </p>
        </div>
    </div>

    <!-- Stock Alert Banner if items exist -->
    @if($stockAlertItems->count() > 0)
    <div class="rounded-2xl bg-amber-50/70 border border-amber-200/80 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-sm shadow">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base">Perhatian Business Rule: Peringatan Stok Menipis & Habis</h3>
                    <p class="text-xs text-slate-500">Tanaman berikut berada di bawah batas minimum (min_stock) atau stok telah 0.</p>
                </div>
            </div>
            <a href="{{ route('products.index', ['stock_status' => 'low_stock']) }}" class="text-xs font-semibold text-amber-700 hover:text-amber-800 underline">
                Lihat Filter &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach($stockAlertItems as $alert)
            <div class="bg-white p-3.5 rounded-xl border border-amber-200/60 flex items-center justify-between shadow-2xs">
                <div class="flex items-center space-x-3 truncate">
                    @if($alert->image_url)
                        <img src="{{ $alert->image_url }}" alt="{{ $alert->name }}" class="w-11 h-11 rounded-lg object-cover flex-shrink-0">
                    @else
                        <div class="w-11 h-11 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                    @endif
                    <div class="truncate">
                        <a href="{{ route('products.show', $alert) }}" class="text-sm font-bold text-slate-900 hover:text-garden-700 truncate block">
                            {{ $alert->name }}
                        </a>
                        <span class="text-xs text-slate-500">{{ $alert->sku }} &bull; Min: {{ $alert->min_stock }}</span>
                    </div>
                </div>
                <div class="text-right flex-shrink-0 ml-2">
                    @if($alert->stock <= 0)
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Habis</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">{{ $alert->stock }} unit</span>
                    @endif
                    <!-- Quick Restock Button -->
                    <form action="{{ route('products.update-stock', $alert) }}" method="POST" class="mt-1">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="delta" value="10">
                        <button type="submit" title="Tambah 10 stok cepat" class="text-[11px] text-emerald-700 font-bold hover:underline">
                            +10 Restock
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Two Columns: Latest Products & Category Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Latest Products (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-9 h-9 rounded-xl bg-garden-100 text-garden-800 flex items-center justify-center text-base">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Tanaman Terbaru Ditambahkan</h2>
                        <p class="text-xs text-slate-500">Data produk terakhir yang masuk ke sistem inventaris</p>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-garden-700 hover:text-garden-800 flex items-center gap-1">
                    <span>Semua Tanaman</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100 mt-2">
                @forelse($latestProducts as $item)
                <div class="py-3.5 flex items-center justify-between hover:bg-slate-50/60 px-2 rounded-xl transition-colors">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-leaf"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('products.show', $item) }}" class="font-bold text-sm text-slate-900 hover:text-garden-700">
                                    {{ $item->name }}
                                </a>
                                @if($item->is_featured)
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-800">Unggulan</span>
                                @endif
                            </div>
                            <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                                <span class="font-mono text-slate-400">{{ $item->sku }}</span>
                                <span>&bull;</span>
                                <span class="text-garden-700 font-medium">{{ $item->category->name ?? 'Uncategorized' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-sm font-extrabold text-slate-900 block">{{ $item->formatted_price }}</span>
                        <div class="mt-0.5">
                            @if($item->stock <= 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                    Habis
                                </span>
                            @elseif($item->stock <= $item->min_stock)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                    Stok: {{ $item->stock }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                    Stok: {{ $item->stock }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-slate-400 text-sm">
                    Belum ada data tanaman. Silakan klik tombol "Tambah Tanaman" di atas.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Category Distribution (1 Col) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-base">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Kategori Tanaman</h2>
                            <p class="text-xs text-slate-500">Distribusi varietas per kelompok botani</p>
                        </div>
                    </div>
                    <a href="{{ route('categories.index') }}" class="text-xs font-bold text-garden-700 hover:text-garden-800">
                        Kelola
                    </a>
                </div>

                <div class="space-y-3 mt-4">
                    @foreach($categorySummary as $cat)
                    <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="group block p-3 rounded-xl border border-slate-100 hover:border-garden-200 hover:bg-garden-50/50 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-7 h-7 rounded-lg bg-garden-100 text-garden-800 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                                    <i class="fa-solid {{ $cat->icon ?? 'fa-leaf' }}"></i>
                                </div>
                                <span class="text-sm font-semibold text-slate-800 group-hover:text-garden-800 transition-colors">
                                    {{ $cat->name }}
                                </span>
                            </div>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 group-hover:bg-garden-200 group-hover:text-garden-900 transition-colors">
                                {{ $cat->products_count }} item
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Add Category Shortcut -->
            <div class="mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('categories.create') }}" class="w-full py-2 px-3 rounded-xl border border-dashed border-slate-300 hover:border-garden-500 text-slate-600 hover:text-garden-700 text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Kategori Baru</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
