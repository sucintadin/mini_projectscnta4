@extends('layouts.app')

@section('title', 'Ubah Kategori: ' . $category->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header & Breadcrumb -->
    <div>
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-garden-700">Dashboard</a>
            <span>/</span>
            <a href="{{ route('categories.index') }}" class="hover:text-garden-700">Kategori</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Ubah</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900">Ubah Kategori</h1>
                <p class="text-sm text-slate-500">Perbarui informasi kelompok botani <strong class="text-slate-700">"{{ $category->name }}"</strong>.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Kategori <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $category->name) }}" 
                       required
                       class="w-full px-4 py-2.5 rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Slug URL
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug', $category->slug) }}" 
                       class="w-full px-4 py-2.5 rounded-xl border @error('slug') border-rose-400 @else border-slate-200 @enderror text-sm font-mono focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">
                @error('slug')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icon -->
            <div>
                <label for="icon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    FontAwesome Icon Class
                </label>
                <select id="icon" 
                        name="icon" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 bg-white transition-all">
                    <option value="fa-leaf" {{ old('icon', $category->icon) == 'fa-leaf' ? 'selected' : '' }}>fa-leaf (Daun)</option>
                    <option value="fa-spa" {{ old('icon', $category->icon) == 'fa-spa' ? 'selected' : '' }}>fa-spa (Bunga/Anggrek)</option>
                    <option value="fa-sun" {{ old('icon', $category->icon) == 'fa-sun' ? 'selected' : '' }}>fa-sun (Sukulen/Kaktus)</option>
                    <option value="fa-tree" {{ old('icon', $category->icon) == 'fa-tree' ? 'selected' : '' }}>fa-tree (Bonsai/Pohon)</option>
                    <option value="fa-heart-pulse" {{ old('icon', $category->icon) == 'fa-heart-pulse' ? 'selected' : '' }}>fa-heart-pulse (Herbal)</option>
                    <option value="fa-seedling" {{ old('icon', $category->icon) == 'fa-seedling' ? 'selected' : '' }}>fa-seedling (Bibit/Media Tanam)</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Deskripsi Kategori
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3" 
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-garden-600 focus:ring-2 focus:ring-garden-100 transition-all">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('categories.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-sm transition-colors">
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
