<?php

namespace Tests\Feature;

use App\Events\ProductStatusChangedEvent;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ProductStatusChangedTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProductStatusChanged()
    {
        Event::fake();

        $product = Product::factory()->create();

        $response = $this->post('/products/update', ['id' => $product->id, 'status' => $product->status]);

        $response->assertStatus(302);

        Event::assertDispatched(ProductStatusChangedEvent::class);
    }
}