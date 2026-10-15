<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search, filter, sorting, and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $stockStatus = $request->query('stock_status');
        $sort = $request->query('sort', 'latest');

        // Query with scopes and eager loading relationship
        $products = Product::with('category')
            ->search($search)
            ->filterCategory($categoryId)
            ->filterStock($stockStatus)
            ->sort($sort)
            ->paginate(8)
            ->withQueryString(); // Mempertahankan parameter filter & search pada link pagination

        $categories = Category::withCount('products')->get();

        // Summary counts for filter tabs
        $counts = [
            'total' => Product::count(),
            'in_stock' => Product::whereColumn('stock', '>', 'min_stock')->count(),
            'low_stock' => Product::where('stock', '>', 0)->whereColumn('stock', '<=', 'min_stock')->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
        ];

        return view('products.index', compact('products', 'categories', 'counts', 'search', 'categoryId', 'stockStatus', 'sort'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage with validation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'light_requirement' => 'nullable|string|max:100',
            'watering_schedule' => 'nullable|string|max:100',
            'image_url' => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama tanaman atau produk wajib diisi.',
            'sku.required' => 'Kode SKU produk wajib diisi.',
            'sku.unique' => 'Kode SKU sudah terdaftar pada tanaman lain.',
            'category_id.required' => 'Pilih kategori tanaman yang sesuai.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'price.required' => 'Harga tanaman wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh bernilai negatif.',
            'stock.required' => 'Jumlah persediaan stok awal wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'min_stock.required' => 'Batas minimum stok untuk peringatan wajib diisi.',
            'min_stock.min' => 'Batas minimum stok tidak boleh negatif.',
            'image_url.url' => 'Format URL foto tanaman harus valid (http/https).',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        $product = Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Tanaman '{$product->name}' berhasil ditambahkan ke inventaris Garden Bloom!");
    }

    /**
     * Display the specified product with botanical details and stock status.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product->id)],
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'light_requirement' => 'nullable|string|max:100',
            'watering_schedule' => 'nullable|string|max:100',
            'image_url' => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama tanaman atau produk wajib diisi.',
            'sku.required' => 'Kode SKU produk wajib diisi.',
            'sku.unique' => 'Kode SKU sudah terdaftar pada tanaman lain.',
            'category_id.required' => 'Pilih kategori tanaman yang sesuai.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'price.required' => 'Harga tanaman wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh bernilai negatif.',
            'stock.required' => 'Jumlah stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'min_stock.required' => 'Batas minimum stok untuk peringatan wajib diisi.',
            'min_stock.min' => 'Batas minimum stok tidak boleh negatif.',
            'image_url.url' => 'Format URL foto tanaman harus valid (http/https).',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Data tanaman '{$product->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', "Tanaman '{$name}' telah dihapus dari inventaris.");
    }

    /**
     * Quick stock adjustment (Penyesuaian stok langsung / restock)
     * Memastikan business rule stok dari P4 tetap terpenuhi.
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'delta' => 'required|integer',
        ]);

        $delta = (int) $validated['delta'];
        $newStock = $product->stock + $delta;

        if ($newStock < 0) {
            return redirect()
                ->back()
                ->with('error', "Penyesuaian stok gagal: Stok tidak boleh kurang dari 0. (Stok saat ini: {$product->stock})");
        }

        $product->update(['stock' => $newStock]);

        $msg = $delta >= 0 
            ? "Berhasil menambah {$delta} unit stok untuk '{$product->name}'. Total stok sekarang: {$newStock}."
            : "Berhasil mengurangi " . abs($delta) . " unit stok untuk '{$product->name}'. Total stok sekarang: {$newStock}.";

        return redirect()
            ->back()
            ->with('success', $msg);
    }
}
