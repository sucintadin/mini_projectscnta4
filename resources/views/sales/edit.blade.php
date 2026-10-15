@extends('layouts.app')

@section('title', 'Ubah Transaksi #' . $sale->id)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header & Breadcrumb -->
    <div>
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-garden-700">Dashboard</a>
            <span>/</span>
            <a href="{{ route('sales.index') }}" class="hover:text-garden-700">Penjualan (P4)</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Ubah Transaksi</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900">Ubah Transaksi Penjualan</h1>
                <p class="text-sm text-slate-500">Perbarui data transaksi pesanan #TRX-{{ $sale->id }}.</p>
            </div>
            <a href="{{ route('sales.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('sales.update', $sale) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Customer Name -->
            <div>
                <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Pelanggan <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="customer_name" 
                       name="customer_name" 
                       value="{{ old('customer_name', $sale->customer_name) }}" 
                       required
                       class="w-full px-4 py-2.5 rounded-xl border @error('customer_name') border-rose-400 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                @error('customer_name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Flower Name -->
            <div>
                <label for="flower_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilihan Bunga / Produk <span class="text-rose-500">*</span>
                </label>
                <input list="flowerList" 
                       id="flower_name" 
                       name="flower_name" 
                       value="{{ old('flower_name', $sale->flower_name) }}" 
                       required
                       class="w-full px-4 py-2.5 rounded-xl border @error('flower_name') border-rose-400 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                <datalist id="flowerList">
                    @foreach($flowers as $fl)
                        <option value="{{ $fl }}"></option>
                    @endforeach
                </datalist>
                @error('flower_name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Qty & Unit Price -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="quantity" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Jumlah Beli (Qty) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           id="quantity" 
                           name="quantity" 
                           value="{{ old('quantity', $sale->quantity) }}" 
                           min="1" 
                           required
                           class="w-full px-4 py-2.5 rounded-xl border @error('quantity') border-rose-400 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                </div>

                <div>
                    <label for="unit_price" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Harga Satuan (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           id="unit_price" 
                           name="unit_price" 
                           value="{{ old('unit_price', (int)$sale->unit_price) }}" 
                           min="0" 
                           step="1000"
                           required
                           class="w-full px-4 py-2.5 rounded-xl border @error('unit_price') border-rose-400 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                </div>
            </div>

            <!-- Date & Payment Method -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="sale_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Tanggal Penjualan <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" 
                           id="sale_date" 
                           name="sale_date" 
                           value="{{ old('sale_date', $sale->sale_date ? $sale->sale_date->format('Y-m-d') : '') }}" 
                           required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all bg-white">
                </div>

                <div>
                    <label for="payment_method" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Metode Pembayaran <span class="text-rose-500">*</span>
                    </label>
                    <select id="payment_method" 
                            name="payment_method" 
                            required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all bg-white">
                        <option value="Tunai" {{ old('payment_method', $sale->payment_method) == 'Tunai' ? 'selected' : '' }}>Tunai (Cash)</option>
                        <option value="Transfer" {{ old('payment_method', $sale->payment_method) == 'Transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="QRIS" {{ old('payment_method', $sale->payment_method) == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        <option value="Kartu" {{ old('payment_method', $sale->payment_method) == 'Kartu' ? 'selected' : '' }}>Kartu Debit/Kredit</option>
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Catatan Pesanan
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3" 
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">{{ old('notes', $sale->notes) }}</textarea>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('sales.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center space-x-2 bg-garden-700 hover:bg-garden-800 text-white font-bold px-6 py-2.5 rounded-xl shadow-md shadow-garden-700/20 transition-all text-sm">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
