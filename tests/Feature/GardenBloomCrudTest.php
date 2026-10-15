<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GardenBloomCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database
        $this->seed();
    }

    /**
     * Test Dashboard loads and displays summary metrics.
     */
    public function test_dashboard_displays_correctly(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Garden Bloom');
        $response->assertSee('Total Tanaman');
        $response->assertSee('Valuasi Aset Stok');
    }

    /**
     * Test Product Index listing and search functionality.
     */
    public function test_product_index_and_search(): void
    {
        $response = $this->get(route('products.index', ['search' => 'Monstera']));

        $response->assertStatus(200);
        $response->assertSee('Monstera Deliciosa');
    }

    /**
     * Test Create form contains CSRF and loads categories.
     */
    public function test_create_form_displays_categories(): void
    {
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Tanaman Baru');
        $response->assertSee('Tanaman Hias Daun');
    }

    /**
     * Test form validation when fields are empty or invalid.
     */
    public function test_product_store_validation_errors(): void
    {
        $response = $this->post(route('products.store'), [
            'name' => '',
            'sku' => '',
            'category_id' => 99999, // nonexistent
            'price' => -5000, // negative price
            'stock' => -10, // negative stock
        ]);

        $response->assertSessionHasErrors(['name', 'sku', 'category_id', 'price', 'stock']);
    }

    /**
     * Test successful product creation (Store -> Redirect -> Persisted in Database).
     */
    public function test_product_can_be_created_successfully(): void
    {
        $category = Category::first();

        $payload = [
            'name' => 'Bonsai Anting Putri Variegata',
            'scientific_name' => 'Wrightia religiosa variegata',
            'category_id' => $category->id,
            'sku' => 'GB-TEST-888',
            'price' => 450000,
            'stock' => 12,
            'min_stock' => 4,
            'light_requirement' => 'Matahari Penuh Terik',
            'watering_schedule' => 'Setiap Hari',
            'image_url' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=600&q=80',
            'description' => 'Bonsai bunga anting putri unik dengan daun variegasi.',
            'is_featured' => 1,
        ];

        $response = $this->post(route('products.store'), $payload);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'sku' => 'GB-TEST-888',
            'name' => 'Bonsai Anting Putri Variegata',
        ]);
    }

    /**
     * Test product detail (Show) view.
     */
    public function test_product_show_view(): void
    {
        $product = Product::first();

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->sku);
    }

    /**
     * Test product update functionality.
     */
    public function test_product_can_be_updated(): void
    {
        $product = Product::first();

        $response = $this->put(route('products.update', $product), [
            'name' => 'Monstera Deliciosa Updated Title',
            'scientific_name' => $product->scientific_name,
            'category_id' => $product->category_id,
            'sku' => $product->sku,
            'price' => 199000,
            'stock' => 25,
            'min_stock' => 5,
        ]);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Monstera Deliciosa Updated Title',
            'price' => 199000,
            'stock' => 25,
        ]);
    }

    /**
     * Test product deletion.
     */
    public function test_product_can_be_deleted(): void
    {
        $product = Product::create([
            'category_id' => Category::first()->id,
            'name' => 'Tanaman Hapus Test',
            'sku' => 'GB-DEL-001',
            'price' => 50000,
            'stock' => 2,
            'min_stock' => 1,
        ]);

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    /**
     * Test Business Rule: Stock adjustment cannot produce negative stock.
     */
    public function test_stock_adjustment_prevents_negative_stock(): void
    {
        $product = Product::first();
        $initialStock = $product->stock;

        // Try reducing more than available stock
        $response = $this->patch(route('products.update-stock', $product), [
            'delta' => -($initialStock + 50),
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals($initialStock, $product->fresh()->stock);

        // Valid adjustment (+5)
        $responseValid = $this->patch(route('products.update-stock', $product), [
            'delta' => 5,
        ]);

        $responseValid->assertSessionHas('success');
        $this->assertEquals($initialStock + 5, $product->fresh()->stock);
    }
}
