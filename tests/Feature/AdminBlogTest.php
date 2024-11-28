<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBlogTest extends TestCase
{
    use RefreshDatabase;

    protected string $baseUrl = '/api/v1/admin/blogs/';
    protected function getBearerToken()
    {
        $user = User::factory()->create();
        return $user->createToken('TestToken')->plainTextToken; // For Sanctum
    }

    public function testIndex()
    {
        $user = User::factory()->create();
        $token = $this->getBearerToken();

        // Create some blogs
        Blog::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson($this->baseUrl);

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function testShow()
    {
        $blog = Blog::factory()->create();

        $token = $this->getBearerToken();

        $response = $this

            ->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson($this->baseUrl . $blog->id);

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $blog->id]]);
    }

    public function testUpdate()
    {
        $blog = Blog::factory()->create();

        $token = $this->getBearerToken();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson($this->baseUrl . $blog->id, [
                'title' => 'Updated Blog Title',
                'slug' => 'updated-blog-title',
                'content' => 'Updated content for the blog.',
                'publish_at' => now(),
                'category_id' => $blog->category_id,
                'status' => 'draft',
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Blog Updated Successfully']);

        $this->assertDatabaseHas('blogs', ['title' => 'Updated Blog Title']);
    }

    public function testDestroy()
    {
        $blog = Blog::factory()->create();

        $token = $this->getBearerToken();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->deleteJson($this->baseUrl . $blog->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Blogs Deleted Successfully']);

        $this->assertSoftDeleted('blogs', ['id' => $blog->id]);
    }

    public function testRestore()
    {
        $blog = Blog::factory()->create();
        $blog->delete(); // Soft delete the blog

        $token = $this->getBearerToken();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson($this->baseUrl . $blog->id . '/restore');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Blogs Deleted Successfully']);

        $this->assertDatabaseHas('blogs', ['id' => $blog->id, 'deleted_at' => null]);
    }
}
