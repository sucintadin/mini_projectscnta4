@extends('layouts.app')

@section('title', 'Riwayat Penjualan Florist (Fitur P4)')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-garden-700 uppercase tracking-wider">
                <i class="fa-solid fa-receipt"></i>
                <span>Fitur Terintegrasi Pertemuan 4 (Petal & Co.)</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Riwayat Transaksi Penjualan</h1>
            <p class="text-sm text-slate-500">Seluruh data penjualan toko bunga dari project P4 telah berhasil diimpor ke sistem Laravel.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('sales.create') }}" class="inline-flex items-center space-x-2 bg-garden-700 hover:bg-garden-800 text-white font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-garden-700/20 transition-all hover:scale-[1.02] text-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Catat Penjualan Baru</span>
            </a>
        </div>
    </div>

    <!-- Summary Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Pendapatan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Pendapatan</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-extrabold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
            <p class="mt-1 text-xs text-slate-400">Total akumulasi transaksi masuk</p>
        </div>

        <!-- Total Item Terjual -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Bunga Terjual</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-seedling"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-extrabold text-slate-900">{{ $totalItemsSold }}</span>
                <span class="text-xs text-slate-500 ml-1">tangkai/buket</span>
            </div>
            <p class="mt-1 text-xs text-slate-400">Total unit bunga keluar</p>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Transaksi</span>
                <div class="w-9 h-9 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-extrabold text-slate-900">{{ $totalTransactions }}</span>
                <span class="text-xs text-slate-500 ml-1">pesanan</span>
            </div>
            <p class="mt-1 text-xs text-slate-400">Transaksi tercatat di database</p>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Transaksi Hari Ini</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-extrabold text-slate-900">{{ $todayTransactions }}</span>
                <span class="text-xs text-slate-500 ml-1">hari ini</span>
            </div>
            <p class="mt-1 text-xs text-slate-400">{{ now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm">
        <form action="{{ route('sales.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <!-- Search -->
            <div class="md:col-span-6 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari pelanggan, nama bunga, atau catatan transaksi..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
            </div>

            <!-- Payment Method -->
            <div class="md:col-span-3">
                <select name="payment_method" class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 bg-white">
                    <option value="">-- Semua Metode Bayar --</option>
                    <option value="Tunai" {{ $paymentMethod === 'Tunai' ? 'selected' : '' }}>Tunai (Cash)</option>
                    <option value="Transfer" {{ $paymentMethod === 'Transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="QRIS" {{ $paymentMethod === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    <option value="Kartu" {{ $paymentMethod === 'Kartu' ? 'selected' : '' }}>Kartu Debit/Kredit</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-grow py-2.5 px-4 rounded-xl bg-garden-700 hover:bg-garden-800 text-white font-semibold text-sm transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Cari Transaksi</span>
                </button>
                @if($search || $paymentMethod)
                    <a href="{{ route('sales.index') }}" title="Reset Filter" class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-5">Nota #</th>
                        <th class="py-4 px-4">Nama Pelanggan</th>
                        <th class="py-4 px-4">Bunga / Produk</th>
                        <th class="py-4 px-4 text-center">Jumlah</th>
                        <th class="py-4 px-4">Harga Satuan</th>
                        <th class="py-4 px-4 font-extrabold text-garden-800">Total Pembayaran</th>
                        <th class="py-4 px-4">Tanggal</th>
                        <th class="py-4 px-4">Metode Bayar</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <!-- Invoice ID -->
                        <td class="py-4 px-5 whitespace-nowrap font-mono text-xs font-bold text-slate-500">
                            #TRX-{{ str_pad($sale->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Customer -->
                        <td class="py-4 px-4 font-bold text-slate-900">
                            {{ $sale->customer_name }}
                            @if($sale->notes)
                                <span class="block text-[11px] font-normal text-slate-400 mt-0.5 line-clamp-1">
                                    <i class="fa-regular fa-comment-dots mr-1"></i>{{ $sale->notes }}
                                </span>
                            @endif
                        </td>

                        <!-- Flower -->
                        <td class="py-4 px-4 font-semibold text-garden-800">
                            {{ $sale->flower_name }}
                        </td>

                        <!-- Qty -->
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                                {{ $sale->quantity }}x
                            </span>
                        </td>

                        <!-- Unit Price -->
                        <td class="py-4 px-4 whitespace-nowrap text-slate-600">
                            {{ $sale->formatted_unit_price }}
                        </td>

                        <!-- Total Price -->
                        <td class="py-4 px-4 whitespace-nowrap font-extrabold text-slate-900">
                            {{ $sale->formatted_total_price }}
                        </td>

                        <!-- Date -->
                        <td class="py-4 px-4 whitespace-nowrap text-xs text-slate-500">
                            {{ $sale->sale_date ? $sale->sale_date->format('d/m/Y') : '-' }}
                        </td>

                        <!-- Payment Method Badge -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            @php
                                $badgeStyle = match($sale->payment_method) {
                                    'QRIS' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'Transfer' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'Kartu' => 'bg-violet-100 text-violet-800 border-violet-200',
                                    default => 'bg-amber-100 text-amber-800 border-amber-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                                {{ $sale->payment_method }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-5 text-right whitespace-nowrap">
                            <div class="inline-flex items-center space-x-1">
                                <!-- Print Struk / Detail -->
                                <a href="{{ route('sales.show', $sale) }}" title="Lihat Struk / Nota" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-garden-100 hover:text-garden-800 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                    <i class="fa-solid fa-receipt"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('sales.edit', $sale) }}" title="Ubah Transaksi" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi #TRX-{{ $sale->id }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Transaksi" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-700 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-receipt text-4xl mb-3 text-slate-300"></i>
                            <h3 class="font-bold text-slate-700 text-base">Tidak ada transaksi ditemukan</h3>
                            <p class="text-xs text-slate-500 mt-1">Coba sesuaikan pencarian atau catat transaksi penjualan baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->hasPages())
        <div class="px-5 py-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $sales->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
