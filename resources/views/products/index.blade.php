@extends('layouts.app')

@section('title', 'Daftar Tanaman & Inventaris')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-garden-700 uppercase tracking-wider">
                <i class="fa-solid fa-seedling"></i>
                <span>Katalog & Inventori</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Daftar Inventaris Tanaman</h1>
            <p class="text-sm text-slate-500">Kelola master data tanaman, pantau stok, harga jual, dan status ketersediaan.</p>
        </div>
        <div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center space-x-2 bg-garden-700 hover:bg-garden-800 text-white font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-garden-700/20 transition-all hover:scale-[1.02] text-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Tanaman Baru</span>
            </a>
        </div>
    </div>

    <!-- Stock Status Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-sm border-b border-slate-200">
        <a href="{{ route('products.index', array_merge(request()->except(['stock_status', 'page']), ['stock_status' => 'all'])) }}"
           class="px-4 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ (!$stockStatus || $stockStatus === 'all') ? 'bg-garden-700 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Semua Tanaman <span class="ml-1 text-xs px-2 py-0.5 rounded-full {{ (!$stockStatus || $stockStatus === 'all') ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $counts['total'] }}</span>
        </a>

        <a href="{{ route('products.index', array_merge(request()->except(['stock_status', 'page']), ['stock_status' => 'in_stock'])) }}"
           class="px-4 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ ($stockStatus === 'in_stock') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <i class="fa-solid fa-circle-check text-xs mr-1 {{ ($stockStatus === 'in_stock') ? 'text-white' : 'text-emerald-600' }}"></i>
            Stok Tersedia <span class="ml-1 text-xs px-2 py-0.5 rounded-full {{ ($stockStatus === 'in_stock') ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800' }}">{{ $counts['in_stock'] }}</span>
        </a>

        <a href="{{ route('products.index', array_merge(request()->except(['stock_status', 'page']), ['stock_status' => 'low_stock'])) }}"
           class="px-4 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ ($stockStatus === 'low_stock') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <i class="fa-solid fa-triangle-exclamation text-xs mr-1 {{ ($stockStatus === 'low_stock') ? 'text-white' : 'text-amber-500' }}"></i>
            Stok Menipis <span class="ml-1 text-xs px-2 py-0.5 rounded-full {{ ($stockStatus === 'low_stock') ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-800' }}">{{ $counts['low_stock'] }}</span>
        </a>

        <a href="{{ route('products.index', array_merge(request()->except(['stock_status', 'page']), ['stock_status' => 'out_of_stock'])) }}"
           class="px-4 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ ($stockStatus === 'out_of_stock') ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <i class="fa-solid fa-circle-xmark text-xs mr-1 {{ ($stockStatus === 'out_of_stock') ? 'text-white' : 'text-rose-500' }}"></i>
            Stok Habis <span class="ml-1 text-xs px-2 py-0.5 rounded-full {{ ($stockStatus === 'out_of_stock') ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-800' }}">{{ $counts['out_of_stock'] }}</span>
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm">
        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            @if($stockStatus)
                <input type="hidden" name="stock_status" value="{{ $stockStatus }}">
            @endif

            <!-- Search input -->
            <div class="md:col-span-5 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari nama tanaman, nama ilmiah, atau SKU..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
            </div>

            <!-- Category filter -->
            <div class="md:col-span-3">
                <select name="category_id" class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 bg-white">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sorting -->
            <div class="md:col-span-2">
                <select name="sort" class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 bg-white">
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nama A - Z</option>
                    <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Nama Z - A</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="stock_asc" {{ $sort === 'stock_asc' ? 'selected' : '' }}>Stok Tersedikit</option>
                    <option value="stock_desc" {{ $sort === 'stock_desc' ? 'selected' : '' }}>Stok Terbanyak</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-grow py-2.5 px-4 rounded-xl bg-garden-700 hover:bg-garden-800 text-white font-semibold text-sm transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Terapkan</span>
                </button>
                @if($search || $categoryId || $sort !== 'latest' || $stockStatus)
                    <a href="{{ route('products.index') }}" title="Reset Filter" class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Products Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-5">Tanaman & Informasi Botani</th>
                        <th class="py-4 px-4">Kategori</th>
                        <th class="py-4 px-4">Harga Satuan</th>
                        <th class="py-4 px-4 text-center">Status & Stok</th>
                        <th class="py-4 px-4">Aksi Cepat Stok</th>
                        <th class="py-4 px-4">Valuasi Stok</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <!-- Product Name & SKU -->
                        <td class="py-4 px-5">
                            <div class="flex items-center space-x-3.5">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-200/60 shadow-2xs">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                            <i class="fa-solid fa-leaf text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('products.show', $product) }}" class="font-bold text-slate-900 hover:text-garden-700 transition-colors">
                                            {{ $product->name }}
                                        </a>
                                        @if($product->is_featured)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                                <i class="fa-solid fa-star text-[9px] mr-1"></i> Unggulan
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                                        @if($product->scientific_name)
                                            <span class="italic text-slate-600 font-serif">{{ $product->scientific_name }}</span>
                                            <span>&bull;</span>
                                        @endif
                                        <span class="font-mono bg-slate-100 text-slate-600 px-1.5 py-0.2 rounded text-[11px]">{{ $product->sku }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-garden-50 text-garden-800 border border-garden-200">
                                <i class="fa-solid {{ $product->category->icon ?? 'fa-leaf' }} mr-1.5 text-garden-600"></i>
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>

                        <!-- Price -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="font-extrabold text-slate-900">{{ $product->formatted_price }}</span>
                        </td>

                        <!-- Stock Status -->
                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            @if($product->stock <= 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                    <i class="fa-solid fa-circle-xmark mr-1.5"></i> Habis (0)
                                </span>
                            @elseif($product->stock <= $product->min_stock)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                    <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Menipis ({{ $product->stock }})
                                </span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Min: {{ $product->min_stock }}</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <i class="fa-solid fa-circle-check mr-1.5"></i> Tersedia ({{ $product->stock }})
                                </span>
                            @endif
                        </td>

                        <!-- Quick Stock Adjustment (Business Rule Stok P4) -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center space-x-1.5">
                                <!-- Kurang 1 -->
                                <form action="{{ route('products.update-stock', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="delta" value="-1">
                                    <button type="submit" 
                                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                                            title="Kurangi stok 1 (terjual/rusak)" 
                                            class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-700 disabled:opacity-30 disabled:pointer-events-none text-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                                        -1
                                    </button>
                                </form>

                                <!-- Tambah 1 -->
                                <form action="{{ route('products.update-stock', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="delta" value="1">
                                    <button type="submit" title="Tambah 1 stok" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-emerald-100 hover:text-emerald-700 text-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                                        +1
                                    </button>
                                </form>

                                <!-- Tambah 5 (Restock batch) -->
                                <form action="{{ route('products.update-stock', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="delta" value="5">
                                    <button type="submit" title="Tambah 5 unit restock" class="px-2 h-7 rounded-lg bg-garden-100 hover:bg-garden-200 text-garden-800 font-bold text-xs flex items-center justify-center transition-colors">
                                        +5 Restock
                                    </button>
                                </form>
                            </div>
                        </td>

                        <!-- Total Valuation -->
                        <td class="py-4 px-4 whitespace-nowrap font-medium text-slate-600">
                            {{ $product->formatted_total_value }}
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-5 text-right whitespace-nowrap">
                            <div class="inline-flex items-center space-x-1">
                                <!-- Show -->
                                <a href="{{ route('products.show', $product) }}" title="Lihat Detail Botani" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-garden-100 hover:text-garden-800 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('products.edit', $product) }}" title="Ubah Data Tanaman" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete with modal confirmation -->
                                <button type="button" 
                                        onclick="openDeleteModal('{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ route('products.destroy', $product) }}')"
                                        title="Hapus Tanaman" 
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-700 text-slate-600 flex items-center justify-center text-xs transition-colors">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 px-4 text-center">
                            <div class="max-w-sm mx-auto">
                                <div class="w-14 h-14 rounded-2xl bg-garden-50 text-garden-600 flex items-center justify-center mx-auto text-2xl mb-3">
                                    <i class="fa-solid fa-seedling"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-base">Tidak ada tanaman ditemukan</h3>
                                <p class="text-xs text-slate-500 mt-1">Coba sesuaikan kata kunci pencarian atau reset filter untuk menampilkan semua varietas tanaman.</p>
                                <div class="mt-4">
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-garden-700 hover:underline">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        <span>Reset Semua Filter</span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section with Query String Preservation -->
        @if($products->hasPages())
        <div class="px-5 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="text-xs text-slate-500">
                Menampilkan <span class="font-semibold text-slate-800">{{ $products->firstItem() }}</span> - <span class="font-semibold text-slate-800">{{ $products->lastItem() }}</span> dari total <span class="font-semibold text-slate-800">{{ $products->total() }}</span> tanaman
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
        @endif
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
            Apakah Anda yakin ingin menghapus data tanaman <strong id="deleteTargetName" class="text-slate-800"></strong> dari sistem inventaris? Tindakan ini tidak dapat dibatalkan.
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
