@extends('layouts.app')

@section('title', 'Kategori: ' . $category->name)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div>
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-garden-700">Dashboard</a>
            <span>/</span>
            <a href="{{ route('categories.index') }}" class="hover:text-garden-700">Kategori</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">{{ $category->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-garden-700 to-emerald-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-garden-600/20">
                    <i class="fa-solid {{ $category->icon ?: 'fa-seedling' }}"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900">{{ $category->name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-garden-100 text-garden-800 border border-garden-200">
                            {{ $products->total() }} Tanaman
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1 max-w-xl">{{ $category->description ?: 'Kategori tanaman botani.' }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('categories.edit', $category) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Ubah Kategori
                </a>
                <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="px-4 py-2 rounded-xl bg-garden-700 hover:bg-garden-800 text-white font-semibold text-xs transition-colors shadow-sm">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Tanaman di Sini
                </a>
            </div>
        </div>
    </div>

    <!-- Plants in this Category -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-seedling text-garden-600"></i>
            <span>Daftar Tanaman dalam Kategori Ini</span>
        </h2>

        @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($products as $product)
            <div class="rounded-2xl border border-slate-200/80 p-4 hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <div class="w-full aspect-square rounded-xl overflow-hidden bg-slate-100 relative mb-3">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                <i class="fa-solid fa-leaf text-3xl"></i>
                            </div>
                        @endif

                        @if($product->stock <= 0)
                            <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-600 text-white shadow">
                                Habis
                            </span>
                        @elseif($product->stock <= $product->min_stock)
                            <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white shadow">
                                Menipis ({{ $product->stock }})
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('products.show', $product) }}" class="font-bold text-sm text-slate-900 hover:text-garden-700 line-clamp-1">
                        {{ $product->name }}
                    </a>
                    @if($product->scientific_name)
                        <p class="font-serif italic text-xs text-slate-500 line-clamp-1">{{ $product->scientific_name }}</p>
                    @endif
                    <p class="font-mono text-[11px] text-slate-400 mt-1">{{ $product->sku }}</p>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 block">Harga</span>
                        <span class="text-sm font-extrabold text-garden-800">{{ $product->formatted_price }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400 block">Stok</span>
                        <span class="text-xs font-bold text-slate-700">{{ $product->stock }} unit</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($products->hasPages())
        <div class="mt-6 pt-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
        @endif

        @else
        <div class="py-12 text-center text-slate-400">
            <i class="fa-solid fa-seedling text-4xl mb-2 text-slate-300"></i>
            <p class="text-sm">Belum ada tanaman yang didaftarkan pada kategori ini.</p>
        </div>
        @endif
    </div>

</div>
@endsection
