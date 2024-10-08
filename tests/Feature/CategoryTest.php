<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    function testResource() {
        $this->seed([CategorySeeder::class]);
        $category = Category::first();

        $this->get("/api/categories/$category->id")
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'created_at' => $category->created_at->toJson(),
                'updated_at' => $category->updated_at->toJson(),
            ]
        ]);
        
    }
    
    function testResourceCollection() {
        $this->seed([CategorySeeder::class]);
        $categories = Category::all();
        // dd($categories);
        $this->get("/api/categories")
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $categories[0]->id,
                    'name' => $categories[0]->name,
                    'description' => $categories[0]->description,
                    'created_at' => $categories[0]->created_at->toJson(),
                    'updated_at' => $categories[0]->updated_at->toJson(),
                ],
                [
                    'id' => $categories[1]->id,
                    'name' => $categories[1]->name,
                    'description' => $categories[1]->description,
                    'created_at' => $categories[1]->created_at->toJson(),
                    'updated_at' => $categories[1]->updated_at->toJson(),
                ],
            ]
        ]);
        
    }

    function testResourceCollectionCustom() {
        $this->seed([CategorySeeder::class]);
        $categories = Category::all();

        $this->get("/api/categories-custom")
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $categories[0]->id,
                    'name' => $categories[0]->name,
                    // 'description' => $categories[0]->description,
                    // 'created_at' => $categories[0]->created_at->toJson(),
                    // 'updated_at' => $categories[0]->updated_at->toJson(),
                ],
                [
                    'id' => $categories[1]->id,
                    'name' => $categories[1]->name,
                    // 'description' => $categories[1]->description,
                    // 'created_at' => $categories[1]->created_at->toJson(),
                    // 'updated_at' => $categories[1]->updated_at->toJson(),
                ],
            ],
            'total' => count($categories)
        ]);
    }
}
