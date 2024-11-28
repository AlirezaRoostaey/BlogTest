<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{

    use RefreshDatabase;
    protected string $baseUrl = '/api/v1/';
    public function testAllBlogs()
    {

        Blog::factory()->count(3)->create();

        $response = $this->getJson($this->baseUrl.'blogs');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['title', 'slug', 'content', 'author', 'category']]]);
    }
    public function testBlog()
    {

        $blog = Blog::factory()->create();


        $response = $this->getJson($this->baseUrl.'blogs/'.$blog->slug);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['title', 'slug', 'content', 'author', 'category']]);
    }
    public function testAllCategories()
    {

        Category::factory()->count(3)->create();

        $response = $this->getJson($this->baseUrl.'categories');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'title', 'description', 'childrenRecursive']]]);
    }
    public function testCategory()
    {

        $category = Category::factory()->create();


        $response = $this->getJson($this->baseUrl.'categories/'.$category->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'childrenRecursive']]);
    }
}
