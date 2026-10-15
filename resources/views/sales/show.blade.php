@extends('layouts.app')

@section('title', 'Struk Transaksi #' . $sale->id)

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Navigation -->
    <div class="flex items-center justify-between no-print">
        <a href="{{ route('sales.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
        <button type="button" onclick="window.print()" class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-garden-700 hover:bg-garden-800 text-white font-semibold text-xs transition-colors shadow-sm">
            <i class="fa-solid fa-print"></i>
            <span>Cetak Nota / Struk</span>
        </button>
    </div>

    <!-- Receipt Card (Print Friendly) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-md print:shadow-none print:border-none space-y-6">
        
        <!-- Header Receipt -->
        <div class="text-center pb-6 border-b border-dashed border-slate-200">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-garden-700 to-emerald-500 text-white flex items-center justify-center text-xl mx-auto mb-2 shadow-sm">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <h2 class="font-serif text-2xl font-bold text-slate-900">Garden Bloom Florist</h2>
            <p class="text-xs text-slate-500">Sistem Penjualan & Inventaris Toko Bunga</p>
            <div class="mt-3 inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-mono text-xs font-bold">
                NO. NOTA: #TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <!-- Meta Info -->
        <div class="grid grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block">Pelanggan:</span>
                <span class="font-bold text-slate-900 text-sm">{{ $sale->customer_name }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block">Tanggal Transaksi:</span>
                <span class="font-bold text-slate-800">{{ $sale->sale_date ? $sale->sale_date->translatedFormat('d F Y') : '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">Metode Pembayaran:</span>
                <span class="font-bold text-slate-800">{{ $sale->payment_method }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block">Status:</span>
                <span class="font-bold text-emerald-600">LUNAS / SELESAI</span>
            </div>
        </div>

        <!-- Line Items -->
        <div class="py-4 border-y border-slate-100">
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-100 pb-2">
                        <th class="text-left pb-2">Item Bunga</th>
                        <th class="text-center pb-2">Qty</th>
                        <th class="text-right pb-2">Harga</th>
                        <th class="text-right pb-2">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-3 font-bold text-slate-800">{{ $sale->flower_name }}</td>
                        <td class="py-3 text-center font-bold text-slate-700">{{ $sale->quantity }}x</td>
                        <td class="py-3 text-right text-slate-600">{{ $sale->formatted_unit_price }}</td>
                        <td class="py-3 text-right font-extrabold text-slate-900">{{ $sale->formatted_total_price }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Subtotal & Grand Total -->
        <div class="space-y-1.5 text-xs">
            <div class="flex items-center justify-between text-slate-500">
                <span>Subtotal:</span>
                <span>{{ $sale->formatted_total_price }}</span>
            </div>
            <div class="flex items-center justify-between text-slate-500">
                <span>Pajak (0%):</span>
                <span>Rp 0</span>
            </div>
            <div class="flex items-center justify-between text-base font-extrabold text-garden-800 pt-2 border-t border-slate-200">
                <span>TOTAL DIBAYAR:</span>
                <span>{{ $sale->formatted_total_price }}</span>
            </div>
        </div>

        @if($sale->notes)
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-600">
            <strong class="font-semibold text-slate-700 block mb-0.5">Catatan Khusus:</strong>
            {{ $sale->notes }}
        </div>
        @endif

        <!-- Footer Receipt -->
        <div class="text-center pt-4 text-xs text-slate-400 border-t border-dashed border-slate-200">
            <p>Terima kasih atas kunjungan dan pesanan Anda di Garden Bloom!</p>
            <p class="text-[10px] text-slate-300 mt-1">Struk ini adalah bukti pembayaran yang sah.</p>
        </div>

    </div>

</div>

@push('styles')
<style>
    @media print {
        .no-print, header, footer {
            display: none !important;
        }
        body {
            background: white !important;
        }
    }
</style>
@endpush
@endsection
