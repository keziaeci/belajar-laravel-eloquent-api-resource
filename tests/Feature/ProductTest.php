<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Tests\TestCase;

use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertNotNull;

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

    function testResourceCollectionWrap() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);
        $res = $this->get('api/products')->assertStatus(200);

        $names = $res->json('data.*.name');
        // dd($names);
        for ($i=0; $i < 5; $i++) { 
            assertContains("Product $i of Food", $names);
        }

        for ($i=0; $i < 5; $i++) { 
            assertContains("Product $i of Good", $names);
        }
    }

    function testProductPaging() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);
        $res = $this->get('api/products-paging')->assertStatus(200);

        assertNotNull($res->json('links'));
        assertNotNull($res->json('data'));
        assertNotNull($res->json('meta'));
    }

    function testAdditionalMetadata() {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);
        $prod = Product::first();
        $res =  $this->get("/api/products-debug/$prod->id")
        ->assertStatus(200)
        ->assertJson([
            'author' => 'Maria Regina',
            'data' => [
                'id' => $prod->id,
                'name' => $prod->name,
                'price' => $prod->price,
            ]
        ]);

        assertNotNull($res->json('server_time'));
    }
}
