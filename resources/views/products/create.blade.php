@extends('layouts.app')

@section('title', 'Tambah Tanaman Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Header -->
    <div>
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-garden-700">Dashboard</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-garden-700">Inventaris Tanaman</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Tambah Tanaman</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900">Tambah Tanaman Baru</h1>
                <p class="text-sm text-slate-500">Daftarkan varietas tanaman atau perlengkapan botani baru ke dalam katalog sistem.</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section 1: Informasi Utama Tanaman -->
            <div>
                <div class="flex items-center space-x-2.5 pb-3 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-garden-100 text-garden-800 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Informasi Dasar & Taksonomi</h2>
                        <p class="text-xs text-slate-500">Nama umum, nama ilmiah botani, dan pengelompokan kategori</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama Tanaman -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nama Tanaman / Produk <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               placeholder="Contoh: Monstera Deliciosa King" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                        @error('name')
                            <p class="text-xs text-rose-600 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Nama Ilmiah / Botani -->
                    <div>
                        <label for="scientific_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nama Ilmiah (Latin / Botani)
                        </label>
                        <input type="text" 
                               id="scientific_name" 
                               name="scientific_name" 
                               value="{{ old('scientific_name') }}" 
                               placeholder="Contoh: Monstera deliciosa" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('scientific_name') border-rose-400 @else border-slate-200 @enderror text-sm italic font-serif focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                        @error('scientific_name')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kategori Tanaman <span class="text-rose-500">*</span>
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                required
                                class="w-full px-4 py-2.5 rounded-xl border @error('category_id') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs text-rose-600 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Inventori, SKU, Harga & Stok -->
            <div>
                <div class="flex items-center space-x-2.5 pb-3 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">SKU, Stok & Harga Jual</h2>
                        <p class="text-xs text-slate-500">Kode identifikasi unik dan kalkulasi persediaan inventaris</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kode SKU Unik <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               id="sku" 
                               name="sku" 
                               value="{{ old('sku', 'GB-' . strtoupper(Str::random(3)) . '-' . rand(100, 999)) }}" 
                               required
                               placeholder="Contoh: GB-FOL-010" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('sku') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-sm font-mono focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                        @error('sku')
                            <p class="text-xs text-rose-600 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Harga (Price) -->
                    <div>
                        <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Harga Satuan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">Rp</span>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', 0) }}" 
                                   min="0"
                                   step="500"
                                   required
                                   placeholder="0" 
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('price') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                        </div>
                        @error('price')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok Awal -->
                    <div>
                        <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Jumlah Stok Awal <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock', 10) }}" 
                               min="0"
                               required
                               placeholder="0" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('stock') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                        @error('stock')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Min Stock (Peringatan Stok Rendah) -->
                    <div>
                        <label for="min_stock" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Batas Minimum Stok (Alert) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" 
                               id="min_stock" 
                               name="min_stock" 
                               value="{{ old('min_stock', 5) }}" 
                               min="0"
                               required
                               placeholder="5" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('min_stock') border-rose-400 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                        <span class="text-[11px] text-slate-400 mt-1 block">Sistem akan memberi alert jika stok &le; angka ini.</span>
                        @error('min_stock')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kebutuhan Cahaya -->
                    <div>
                        <label for="light_requirement" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kebutuhan Cahaya
                        </label>
                        <select id="light_requirement" 
                                name="light_requirement" 
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 bg-white transition-all">
                            <option value="">-- Pilih Kondisi Cahaya --</option>
                            <option value="Terang Tidak Langsung" {{ old('light_requirement') == 'Terang Tidak Langsung' ? 'selected' : '' }}>Terang Tidak Langsung (Indoor)</option>
                            <option value="Matahari Penuh Terik" {{ old('light_requirement') == 'Matahari Penuh Terik' ? 'selected' : '' }}>Matahari Penuh Terik (Outdoor)</option>
                            <option value="Matahari Pagi 4-6 Jam" {{ old('light_requirement') == 'Matahari Pagi 4-6 Jam' ? 'selected' : '' }}>Matahari Pagi 4-6 Jam</option>
                            <option value="Teduh Lembap" {{ old('light_requirement') == 'Teduh Lembap' ? 'selected' : '' }}>Teduh Lembap (Low Light)</option>
                            <option value="Toleran Segala Cahaya" {{ old('light_requirement') == 'Toleran Segala Cahaya' ? 'selected' : '' }}>Toleran Segala Kondisi Cahaya</option>
                        </select>
                    </div>

                    <!-- Jadwal Siram -->
                    <div>
                        <label for="watering_schedule" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Jadwal Penyiraman Air
                        </label>
                        <input type="text" 
                               id="watering_schedule" 
                               name="watering_schedule" 
                               value="{{ old('watering_schedule', '2-3 Hari Sekali') }}" 
                               placeholder="Contoh: 2-3 Hari Sekali" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 3: Media Foto & Deskripsi -->
            <div>
                <div class="flex items-center space-x-2.5 pb-3 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Foto Tanaman & Panduan Perawatan</h2>
                        <p class="text-xs text-slate-500">Tautan gambar katalog dan catatan perawatan botani</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- URL Gambar -->
                    <div>
                        <label for="image_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            URL Gambar / Foto Tanaman (Online Image URL)
                        </label>
                        <input type="url" 
                               id="image_url" 
                               name="image_url" 
                               value="{{ old('image_url') }}" 
                               oninput="previewImage(this.value)"
                               placeholder="https://images.unsplash.com/photo-..." 
                               class="w-full px-4 py-2.5 rounded-xl border @error('image_url') border-rose-400 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                        <span class="text-[11px] text-slate-400 mt-1 block">Masukkan tautan direct URL gambar tanaman (Unsplash, imgur, atau web).</span>
                        @error('image_url')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Live Preview -->
                        <div id="imagePreviewContainer" class="mt-3 hidden items-center space-x-3 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <img id="imagePreview" src="" alt="Pratinjau Foto" class="w-16 h-16 rounded-xl object-cover border border-slate-200">
                            <span class="text-xs text-slate-500">Pratinjau foto tanaman berhasil dimuat.</span>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Deskripsi Botani & Catatan Perawatan
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Tuliskan karakteristik daun, warna bunga, tips pemupukan, atau keunikan tanaman ini..." 
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">{{ old('description') }}</textarea>
                    </div>

                    <!-- Featured Checkbox -->
                    <div class="pt-2">
                        <label class="inline-flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1" 
                                   {{ old('is_featured') ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-garden-700 focus:ring-garden-500 border-slate-300">
                            <span class="text-sm font-semibold text-slate-800">Tandai sebagai Koleksi Unggulan (Featured Plant)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button & Cancel -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center space-x-2 bg-garden-700 hover:bg-garden-800 text-white font-bold px-6 py-2.5 rounded-xl shadow-md shadow-garden-700/20 transition-all hover:scale-[1.02] text-sm">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Tanaman Baru</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    function previewImage(url) {
        const container = document.getElementById('imagePreviewContainer');
        const img = document.getElementById('imagePreview');
        if (url && url.startsWith('http')) {
            img.src = url;
            container.classList.remove('hidden');
            container.classList.add('flex');
        } else {
            container.classList.add('hidden');
            container.classList.remove('flex');
        }
    }

    // Run preview on load if old value exists
    window.addEventListener('DOMContentLoaded', () => {
        const val = document.getElementById('image_url').value;
        if (val) previewImage(val);
    });
</script>
@endpush
@endsection
