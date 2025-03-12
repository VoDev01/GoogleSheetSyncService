<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Events\ProductCreatedEvent;
use App\Events\ProductDeletedEvent;
use Illuminate\Support\Facades\Event;
use App\Events\ProductStatusChangedEvent;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductEventsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProductDeleted()
    {
        Event::fake();

        $product = Product::factory()->create();

        $response = $this->post('/products/destroy', ['name' => $product->name]);

        $response->assertStatus(302);

        Event::assertDispatched(ProductDeletedEvent::class);
    }

    public function testProductStatusChanged()
    {
        Event::fake();

        $product = Product::factory()->create();

        $response = $this->post('/products/update', ['id' => $product->id, 'status' => $product->status]);

        $response->assertStatus(302);

        Event::assertDispatched(ProductStatusChangedEvent::class);
    }

    public function testProductCreated()
    {
        Event::fake();

        $product = Product::factory()->make();

        $response = $this->post('/products/create', ['name' => $product->name, 'status' => $product->status]);

        $response->assertStatus(302);

        Event::assertDispatched(ProductCreatedEvent::class);
    }
}
