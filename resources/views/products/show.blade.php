@extends('layouts.app')

@section('title', $product->name . ' - Detail Tanaman')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Breadcrumb & Navigation -->
    <div class="flex items-center justify-between">
        <nav class="flex items-center space-x-2 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-garden-700">Dashboard</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-garden-700">Inventaris Tanaman</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">{{ $product->name }}</span>
        </nav>
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Ubah Data</span>
            </a>
            <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Plant Photo & Fast Quick Restock -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-3 border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="w-full aspect-square rounded-2xl overflow-hidden bg-slate-100 relative group">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                            <i class="fa-solid fa-leaf text-6xl"></i>
                        </div>
                    @endif

                    @if($product->is_featured)
                        <div class="absolute top-4 left-4 bg-emerald-600/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center gap-1.5">
                            <i class="fa-solid fa-star text-[10px]"></i>
                            <span>Koleksi Unggulan</span>
                        </div>
                    @endif
                </div>

                <div class="p-3 text-center">
                    <span class="font-mono text-xs text-slate-400">Kode SKU: {{ $product->sku }}</span>
                </div>
            </div>

            <!-- Quick Restock Widget (Business Rule Stok) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-garden-100 text-garden-800 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-dolly"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Penyesuaian Stok Cepat (Restock)</h3>
                        <p class="text-xs text-slate-500">Update langsung persediaan fisik tanaman</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <!-- -1 -->
                    <form action="{{ route('products.update-stock', $product) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="delta" value="-1">
                        <button type="submit" 
                                {{ $product->stock <= 0 ? 'disabled' : '' }}
                                class="w-full py-2 px-2 rounded-xl bg-slate-100 hover:bg-rose-100 hover:text-rose-700 disabled:opacity-40 text-slate-700 font-bold text-xs transition-colors flex items-center justify-center gap-1">
                            <i class="fa-solid fa-minus text-[10px]"></i> 1 Terjual
                        </button>
                    </form>

                    <!-- +1 -->
                    <form action="{{ route('products.update-stock', $product) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="delta" value="1">
                        <button type="submit" class="w-full py-2 px-2 rounded-xl bg-slate-100 hover:bg-emerald-100 hover:text-emerald-700 text-slate-700 font-bold text-xs transition-colors flex items-center justify-center gap-1">
                            <i class="fa-solid fa-plus text-[10px]"></i> 1 Masuk
                        </button>
                    </form>

                    <!-- +10 -->
                    <form action="{{ route('products.update-stock', $product) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="delta" value="10">
                        <button type="submit" class="w-full py-2 px-2 rounded-xl bg-garden-100 hover:bg-garden-200 text-garden-800 font-bold text-xs transition-colors flex items-center justify-center gap-1">
                            <i class="fa-solid fa-boxes-packing text-[10px]"></i> +10 Batch
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Botanical Details & Specs -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Header Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-garden-100 text-garden-800 border border-garden-200 flex items-center gap-1.5">
                        <i class="fa-solid {{ $product->category->icon ?? 'fa-leaf' }} text-garden-600"></i>
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>
                    <span class="text-xs text-slate-400">&bull;</span>
                    <span class="text-xs text-slate-500 font-medium">Ditambahkan {{ $product->created_at->diffForHumans() }}</span>
                </div>

                <div>
                    <h1 class="font-serif text-3xl font-bold text-slate-900">{{ $product->name }}</h1>
                    @if($product->scientific_name)
                        <p class="font-serif italic text-base text-slate-500 mt-1">{{ $product->scientific_name }}</p>
                    @endif
                </div>

                <!-- Price & Valuation Ribbon -->
                <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold block">Harga Satuan</span>
                        <span class="text-2xl font-extrabold text-garden-800 mt-1 block">{{ $product->formatted_price }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold block">Total Valuasi Stok</span>
                        <span class="text-2xl font-extrabold text-slate-800 mt-1 block">{{ $product->formatted_total_value }}</span>
                    </div>
                </div>

                <!-- Stock Status Box -->
                <div class="p-4 rounded-2xl {{ $product->stock <= 0 ? 'bg-rose-50 border border-rose-200' : ($product->stock <= $product->min_stock ? 'bg-amber-50 border border-amber-200' : 'bg-emerald-50 border border-emerald-200') }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl {{ $product->stock <= 0 ? 'bg-rose-500 text-white' : ($product->stock <= $product->min_stock ? 'bg-amber-500 text-white' : 'bg-emerald-500 text-white') }} flex items-center justify-center text-lg shadow-sm">
                                @if($product->stock <= 0)
                                    <i class="fa-solid fa-circle-xmark"></i>
                                @elseif($product->stock <= $product->min_stock)
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                @else
                                    <i class="fa-solid fa-circle-check"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-bold {{ $product->stock <= 0 ? 'text-rose-900' : ($product->stock <= $product->min_stock ? 'text-amber-900' : 'text-emerald-900') }}">
                                    Status: {{ $product->stock_status_label }}
                                </h4>
                                <p class="text-xs {{ $product->stock <= 0 ? 'text-rose-700' : ($product->stock <= $product->min_stock ? 'text-amber-700' : 'text-emerald-700') }}">
                                    Tersedia <strong class="font-bold">{{ $product->stock }} unit</strong> di nursery &bull; Batas minimum peringatan: {{ $product->min_stock }} unit
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plant Care Guide Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Light -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-solid fa-sun"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Kebutuhan Cahaya</h4>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $product->light_requirement ?: 'Kondisi Cahaya Umum' }}</p>
                        <p class="text-[11px] text-slate-400 mt-1">Letakkan pada area sesuai intensitas untuk fotosintesis optimal.</p>
                    </div>
                </div>

                <!-- Water -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-solid fa-droplet"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Jadwal Penyiraman</h4>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $product->watering_schedule ?: 'Sesuai kelembapan media' }}</p>
                        <p class="text-[11px] text-slate-400 mt-1">Cek kelembapan 2cm dari permukaan tanah sebelum menyiram.</p>
                    </div>
                </div>
            </div>

            <!-- Description & Botanical Notes -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-3">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-garden-600"></i>
                    <span>Deskripsi Tanaman & Panduan Perawatan</span>
                </h3>
                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                    {{ $product->description ?: 'Belum ada deskripsi botani khusus untuk varietas ini.' }}
                </div>
            </div>

            <!-- Bottom Actions -->
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('products.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-xs transition-colors">
                    &larr; Kembali ke Daftar
                </a>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('products.edit', $product) }}" class="px-5 py-2.5 rounded-xl bg-garden-700 hover:bg-garden-800 text-white font-bold text-xs transition-colors flex items-center gap-1.5 shadow-md shadow-garden-700/20">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Ubah Data Tanaman</span>
                    </a>

                    <!-- Delete button -->
                    <button type="button" 
                            onclick="openDeleteModal('{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ route('products.destroy', $product) }}')"
                            class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition-colors flex items-center gap-1.5 border border-rose-200">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform transition-all animate-in fade-in zoom-in-95 duration-150">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus Tanaman</h3>
        <p class="text-sm text-slate-500 mt-1.5">
            Apakah Anda yakin ingin menghapus data tanaman <strong id="deleteTargetName" class="text-slate-800"></strong> dari inventaris Garden Bloom? Tindakan ini permanen.
        </p>

        <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-end space-x-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-sm transition-colors">
                Batal
            </button>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm shadow-md transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-trash-can text-xs"></i>
                <span>Ya, Hapus Tanaman</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(id, name, deleteUrl) {
        document.getElementById('deleteTargetName').innerText = `"${name}"`;
        document.getElementById('deleteForm').action = deleteUrl;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
