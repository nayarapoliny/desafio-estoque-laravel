<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_product(): void
    {
        $payload = [
            'name'        => 'Mouse Gamer',
            'description' => 'RGB 16000dpi',
            'price'       => 199.90,
            'stock'       => 10,
        ];

        $this->postJson('/api/products', $payload)
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Mouse Gamer');

        $this->assertDatabaseHas('products', ['name' => 'Mouse Gamer']);
    }

    public function test_validation_fails_on_missing_fields(): void
    {
        $this->postJson('/api/products', [])
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Erro de validacao.')
            ->assertJsonStructure([
                'success',
                'message',
                'errors' => ['name', 'price', 'stock'],
            ]);
    }

    public function test_can_list_products(): void
    {
        Product::factory()->count(3)->create();

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_filter_products_by_name_and_price(): void
    {
        Product::factory()->create(['name' => 'Mouse', 'price' => 100]);
        Product::factory()->create(['name' => 'Teclado', 'price' => 300]);

        $this->getJson('/api/products?name=Mouse&min_price=50&max_price=200')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Mouse');
    }

    public function test_can_paginate_products(): void
    {
        Product::factory()->count(4)->create();

        $this->getJson('/api/products?per_page=2&page=2')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonPath('meta.per_page', 2)
            ->assertJsonPath('meta.total', 4)
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_can_show_a_product(): void
    {
        $product = Product::factory()->create();

        $this->getJson("/api/products/{$product->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $product->id);
    }

    public function test_can_update_a_product(): void
    {
        $product = Product::factory()->create();

        $this->putJson("/api/products/{$product->id}", ['price' => 555.55])
            ->assertOk()
            ->assertJsonPath('data.price', 555.55);
    }

    public function test_can_delete_a_product(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson("/api/products/{$product->id}")
            ->assertOk();

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_returns_standard_json_for_missing_route(): void
    {
        $this->getJson('/api/rota-inexistente')
            ->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => 'Recurso nao encontrado.',
            ]);
    }

    public function test_populates_cache_on_first_listing_and_invalidates_after_create(): void
    {
        Cache::flush();
        Product::factory()->create(['name' => 'Primeiro Produto']);

        $beforeFirstListing = DB::table('cache')->count();

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Primeiro Produto');

        $afterFirstListing = DB::table('cache')->count();

        $this->assertGreaterThan($beforeFirstListing, $afterFirstListing);

        $versionBeforeCreate = Cache::get('products:version');

        $this->postJson('/api/products', [
            'name' => 'Segundo Produto',
            'description' => 'Novo item',
            'price' => 49.90,
            'stock' => 7,
        ])->assertCreated();

        $this->assertSame($versionBeforeCreate + 1, Cache::get('products:version'));

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Segundo Produto');
    }

    public function test_invalidates_cache_after_update_and_delete(): void
    {
        Cache::flush();
        $product = Product::factory()->create();

        $this->getJson('/api/products')->assertOk();
        $versionBeforeUpdate = Cache::get('products:version');

        $this->putJson("/api/products/{$product->id}", [
            'name' => 'Produto Atualizado',
        ])->assertOk();

        $this->assertSame($versionBeforeUpdate + 1, Cache::get('products:version'));

        $versionBeforeDelete = Cache::get('products:version');

        $this->deleteJson("/api/products/{$product->id}")
            ->assertOk();

        $this->assertSame($versionBeforeDelete + 1, Cache::get('products:version'));
    }
}
