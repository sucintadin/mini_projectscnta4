<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::withCount('products')
            ->with(['products' => function ($q) {
                $q->select('id', 'category_id', 'stock', 'price');
            }])
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'slug.unique' => 'Slug kategori sudah terdaftar.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if (empty($validated['icon'])) {
            $validated['icon'] = 'fa-seedling';
        }

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', "Kategori '{$validated['name']}' berhasil ditambahkan!");
    }

    /**
     * Display the specified category and its plants.
     */
    public function show(Category $category)
    {
        $products = $category->products()->paginate(8)->withQueryString();
        return view('categories.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'slug.unique' => 'Slug kategori sudah terdaftar.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $productsCount = $category->products()->count();

        if ($productsCount > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', "Kategori '{$category->name}' tidak dapat dihapus karena masih menampung {$productsCount} tanaman!");
        }

        $name = $category->name;
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', "Kategori '{$name}' berhasil dihapus.");
    }
}
