@extends('layouts.app')

@section('title', 'Kategori Tanaman')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-garden-700 uppercase tracking-wider">
                <i class="fa-solid fa-tags"></i>
                <span>Taksonomi & Pengelompokan</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Kategori Tanaman & Produk</h1>
            <p class="text-sm text-slate-500">Kelola kelompok botani tanaman hias, sukulen, bonsai, dan nutrisi taman.</p>
        </div>
        <div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center space-x-2 bg-garden-700 hover:bg-garden-800 text-white font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-garden-700/20 transition-all hover:scale-[1.02] text-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Kategori Baru</span>
            </a>
        </div>
    </div>

    <!-- Categories Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
            <div>
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-garden-700 to-emerald-500 text-white flex items-center justify-center text-xl shadow-md shadow-garden-600/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid {{ $category->icon ?: 'fa-seedling' }}"></i>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-garden-100 text-garden-800 border border-garden-200">
                        {{ $category->products_count }} Tanaman
                    </span>
                </div>

                <div class="mt-4">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-garden-700 transition-colors">
                        <a href="{{ route('categories.show', $category) }}">
                            {{ $category->name }}
                        </a>
                    </h3>
                    <p class="font-mono text-xs text-slate-400 mt-0.5">slug: /{{ $category->slug }}</p>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed line-clamp-2">
                        {{ $category->description ?: 'Belum ada deskripsi untuk kategori ini.' }}
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('categories.show', $category) }}" class="font-bold text-garden-700 hover:text-garden-800 flex items-center gap-1">
                    <span>Lihat Tanaman ({{ $category->products_count }})</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>

                <div class="flex items-center space-x-1">
                    <a href="{{ route('categories.edit', $category) }}" title="Ubah Kategori" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 text-slate-600 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                    </a>

                    <!-- Delete button with check for existing products -->
                    <button type="button" 
                            onclick="openDeleteCatModal('{{ $category->id }}', '{{ addslashes($category->name) }}', '{{ $category->products_count }}', '{{ route('categories.destroy', $category) }}')"
                            title="Hapus Kategori" 
                            class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-700 text-slate-600 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-200">
            <div class="w-16 h-16 rounded-2xl bg-garden-50 text-garden-600 flex items-center justify-center mx-auto text-2xl mb-4">
                <i class="fa-solid fa-tags"></i>
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum ada kategori</h3>
            <p class="text-xs text-slate-500 mt-1">Tambahkan kategori untuk mengelompokkan koleksi tanaman Anda.</p>
            <div class="mt-4">
                <a href="{{ route('categories.create') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-garden-700 text-white font-bold text-xs">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Kategori Sekarang</span>
                </a>
            </div>
        </div>
        @endforelse
    </div>

</div>

<!-- Delete Category Modal -->
<div id="deleteCatModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform transition-all">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus Kategori</h3>
        <p class="text-sm text-slate-500 mt-1.5">
            Apakah Anda yakin ingin menghapus kategori <strong id="deleteCatTargetName" class="text-slate-800"></strong>?
        </p>

        <div id="catWarningBox" class="mt-3 hidden p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>
            <span id="catWarningText"></span>
        </div>

        <form id="deleteCatForm" method="POST" action="" class="mt-6 flex items-center justify-end space-x-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteCatModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-sm transition-colors">
                Batal
            </button>
            <button type="submit" id="submitDeleteCatBtn" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm shadow-md transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-trash-can text-xs"></i>
                <span>Ya, Hapus Kategori</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteCatModal(id, name, productsCount, deleteUrl) {
        document.getElementById('deleteCatTargetName').innerText = `"${name}"`;
        document.getElementById('deleteCatForm').action = deleteUrl;

        const warningBox = document.getElementById('catWarningBox');
        const submitBtn = document.getElementById('submitDeleteCatBtn');

        if (parseInt(productsCount) > 0) {
            warningBox.classList.remove('hidden');
            document.getElementById('catWarningText').innerText = `Kategori ini memiliki ${productsCount} tanaman. Sesuai business rule, Anda harus memindahkan atau menghapus tanaman di dalamnya terlebih dahulu!`;
            submitBtn.setAttribute('disabled', 'disabled');
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            warningBox.classList.add('hidden');
            submitBtn.removeAttribute('disabled');
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        document.getElementById('deleteCatModal').classList.remove('hidden');
    }

    function closeDeleteCatModal() {
        document.getElementById('deleteCatModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
