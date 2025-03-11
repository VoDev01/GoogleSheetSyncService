<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        Product::factory()->count(100)->create();

        $response = $this->getJson(env('APP_URL') . '/api/v1/products/index');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
            $json->has('products.data', 15)->etc()       
        );
    }
    public function testCreate()
    {
        $product = Product::factory()->make();

        $response = $this->postJson(env('APP_URL') . '/api/v1/products/create', ['name' => $product->name, 'status' => $product->status]);

        $response->assertOk();
        $this->assertDatabaseHas('products', ['name' => $product, 'status' => $product]);
    }
    public function testDestroy()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(env('APP_URL') . '/api/v1/products/destroy', ['name' => $product->name]);

        $response->assertOk();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
    public function testUpdate()
    {
        $product = Product::factory()->create();

        $response = $this->patchJson(env('APP_URL') . '/api/v1/products/update', ['id' => $product->id, 'name' => 'product']);

        $response->assertOk();
        $this->assertDatabaseHas('products', ['name' => 'product']);
    }
}