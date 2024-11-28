<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{

    protected string $baseUrl = '/api/v1/admin/categories/';
    public function testIndex()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum

        Category::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson($this->baseUrl);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'title', 'description', 'parent_id']]]);
    }

    public function testShow()
    {

        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum
        $category = Category::factory()->create();


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson($this->baseUrl . $category->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'parent_id']]);
    }

    public function testShowNotFound()
    {

        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson($this->baseUrl.'922299');

        $response->assertStatus(404)
            ->assertJson(['message' => 'not Found']);
    }

    public function testStore()
    {
        $data = [
            'title' => 'New Category',
            'description' => 'Category Description',
        ];


        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson($this->baseUrl, $data);

        $response->assertStatus(200)
            ->assertJson(['message' => 'category Created Successfully']);

        $this->assertDatabaseHas('categories', $data);
    }

    public function testUpdate()
    {
        $category = Category::factory()->create();


        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum

        $data = [
            'title' => 'Updated Category',
            'description' => 'Updated Description',
            'parent_id' => null,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson($this->baseUrl . $category->id, $data);

        $response->assertStatus(200)
            ->assertJson(['message' => 'category Updated Successfully']);

        $this->assertDatabaseHas('categories', $data);
    }

    public function testUpdateNotFound()
    {
        $data = [
            'title' => 'Updated Category',
            'description' => 'Updated Description',
            'parent_id' => null,
        ];


        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson($this->baseUrl.'992229', $data);

        $response->assertStatus(404)
            ->assertJson(['message' => 'category not found']);
    }

    public function testDestroy()
    {

        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum

        $category = Category::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson($this->baseUrl . $category->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'category Deleted Successfully']);

        $this->assertSoftDeleted('categories', ['id' => $category->id]);

    }

    public function testDestroyNotFound()
    {

        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; // For Sanctum
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson($this->baseUrl.'999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'category not found']);
    }

}
