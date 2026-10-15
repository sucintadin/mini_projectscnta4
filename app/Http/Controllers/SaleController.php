<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of sales transactions (P4 Feature).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $paymentMethod = $request->query('payment_method');

        $query = Sale::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('flower_name', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where('payment_method', $paymentMethod);
        }

        $sales = $query->orderBy('sale_date', 'desc')->paginate(10)->withQueryString();

        // Summary metrics
        $totalRevenue = Sale::select(DB::raw('SUM(quantity * unit_price) as rev'))->value('rev') ?? 0;
        $totalItemsSold = Sale::sum('quantity');
        $totalTransactions = Sale::count();
        $todayTransactions = Sale::whereDate('sale_date', now()->toDateString())->count();

        return view('sales.index', compact(
            'sales',
            'search',
            'paymentMethod',
            'totalRevenue',
            'totalItemsSold',
            'totalTransactions',
            'todayTransactions'
        ));
    }

    /**
     * Show the form for creating a new sale transaction.
     */
    public function create()
    {
        $flowers = Product::pluck('name');
        return view('sales.create', compact('flowers'));
    }

    /**
     * Store a newly created sale transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'flower_name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'payment_method' => 'required|in:Tunai,Transfer,QRIS,Kartu',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'flower_name.required' => 'Nama bunga/tanaman wajib diisi.',
            'quantity.required' => 'Jumlah beli wajib diisi.',
            'quantity.min' => 'Jumlah beli minimal 1.',
            'unit_price.required' => 'Harga satuan wajib diisi.',
            'sale_date.required' => 'Tanggal transaksi wajib diisi.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        Sale::create($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', "Transaksi penjualan atas nama '{$validated['customer_name']}' berhasil dicatat!");
    }

    /**
     * Display the specified sale transaction (Invoice/Receipt).
     */
    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale transaction.
     */
    public function edit(Sale $sale)
    {
        $flowers = Product::pluck('name');
        return view('sales.edit', compact('sale', 'flowers'));
    }

    /**
     * Update the specified sale transaction in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'flower_name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'payment_method' => 'required|in:Tunai,Transfer,QRIS,Kartu',
            'notes' => 'nullable|string|max:500',
        ]);

        $sale->update($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', "Transaksi penjualan #{$sale->id} berhasil diperbarui!");
    }

    /**
     * Remove the specified sale transaction from storage.
     */
    public function destroy(Sale $sale)
    {
        $id = $sale->id;
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', "Transaksi #{$id} berhasil dihapus.");
    }
}
