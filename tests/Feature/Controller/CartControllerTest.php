<?php

namespace Tests\Feature\Controller;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_item()
    {
        $this->withExceptionHandling();
        $item1 = Item::factory()->create();
        $response = $this->get('/cart/' . $item1->id);
        $response = $this->get('/cart/' . $item1->id);
        $item2 = Item::factory()->create();
        $response = $this->get('/cart/' . $item2->id);

        $response->dumpSession();
        $response->assertStatus(302);
    }

    public function test_show_cart()
    {
        $this->withExceptionHandling();
        $item = Item::factory()->create();
        $response = $this->get('/cart/' . $item->id);
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_change_qty()
    {
        $this->withExceptionHandling();
        $item = Item::factory()->create();
        $response = $this->get('/cart/' . $item->id);
        $response = $this->post('/cart/' . $item->id, [
            'qty' => 10,
        ]);
        $response->dumpSession();
        $response->assertStatus(302);
    }

    public function test_delete_item()
    {
        $this->withExceptionHandling();
        $item1 = Item::factory()->create();
        $response = $this->get('/cart/' . $item1->id);
        $item2 = Item::factory()->create();
        $response = $this->get('/cart/' . $item2->id);
        $response = $this->delete('/cart/' . $item1->id);
        $response->dumpSession();
        $response->assertStatus(302);
    }
}
