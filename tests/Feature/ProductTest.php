<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    function testResource() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);
        $p = Product::first();
        $this->get("/api/products/$p->id")
            ->assertStatus(200)
            ->assertJson([
                'value' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'category' => [
                        'id' => $p->category->id,
                        'name' => $p->category->name,
                    ],
                    'price' => $p->price,
                    'created_at' => $p->created_at->toJson(),
                    'updated_at' => $p->updated_at->toJson(),
                ]
            ]);
    }
}
