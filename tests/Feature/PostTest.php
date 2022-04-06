<?php

namespace Tests\Feature;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


class PostTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    public function test_all_users_can_view_index_page()
    {
        $this->withoutExceptionHandling();

        $response = $this->get("/posts");

        $response->assertSuccessful()
            ->assertViewIs("posts.index");

    }

    public function test_all_users_can_view_show_page()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $response = $this->get("/category/posts/$post->slug");

        $response->assertSuccessful()
            ->assertViewIs("posts.show");
    }

    public function test_user_can_read_all_posts()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $response = $this->get("/posts");

        $response->assertSuccessful()
            ->assertSee($post->slug);

    }

    public function test_user_can_read_a_post_by_slug()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $response = $this->get("/category/posts/$post->slug");

        $response->assertSuccessful()
            ->assertSee($post->title)
            ->assertSee($post->body)
            ->assertSee($post->category->name)
            ->assertSee($post->user->name)
            ->assertSee($post->created_at);
    }


    public function test_user_can_read_a_post_by_id()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $response = $this->get("/posts/$post->id");

        $response->assertSuccessful()
            ->assertSee($post->title)
            ->assertSee($post->body)
            ->assertSee($post->category->name)
            ->assertSee($post->user->name)
            ->assertSee($post->created_at);
    }

    public function test_user_should_be_redirected_if_slug_not_found()
    {

        $this->withoutExceptionHandling();

        Post::factory()->create();

        $response = $this->get("/category/posts/wrong_slug");

        $response->assertRedirect("/posts")
                ->assertSessionHas("message", "Post not found.")
                ->assertStatus(302);

    }


    public function test_authenticated_user_can_create_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->make(["user_id" => Auth::id()]);

        $response = $this->post("/posts", $post->toArray());

        $response->assertRedirect()
                ->assertStatus(302)
                ->assertSessionHas("message", "Post created successfully.");

        //$this->assertDatabaseHas("posts", ["slug" => $post->slug]);

        $this->assertEquals(1, Post::all()->count());

    }

    public function test_guest_cannot_create_a_post()
    {

        $post = Post::factory()->make()->toArray();

        $response = $this->post("/posts", $post);

        $response->assertRedirect("/login")
                ->assertStatus(302);

        $this->assertDatabaseMissing("posts", $post);
    }

    public function test_authenticated_user_cannot_create_already_exist_slug_post_on_update()
    {
        //$this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create(["user_id" => Auth::id(), "slug" => "first_slug"]);

        $new_post = Post::factory()->create(["user_id" => Auth::id(), "slug" => "second_slug"]);

        $new_post->slug = $post->slug;

        $response = $this->put("/posts/$new_post->id", $new_post->toArray());

        $errors = session("errors");

        $response->assertSessionHasErrors("slug")
            ->assertRedirect()
            ->assertStatus(302);

        $this->assertEquals( "The slug has already been taken.", $errors->get("slug")[0]);

    }

    public function test_authenticated_user_can_update_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create(["user_id" => Auth::id()]);

        $post->slug = "updated_slug";

        $response = $this->put("/posts/$post->id", $post->toArray());

        $response->assertRedirect()
            ->assertStatus(302)
            ->assertSessionHas("message", "Post updated successfully.");

        $this->assertDatabaseHas("posts", ["slug" => "updated_slug"]);

    }

    public function test_guest_cannot_update_post()
    {
        $post = Post::factory()->create();

        $post->slug = "updated_slug";

        $response = $this->put("/posts/$post->id", $post->toArray());

        $response->assertRedirect("/login")
            ->assertStatus(302);


    }

    public function test_unauthenticated_user_cannot_update_post()
    {

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create();

        $post->slug = "updated_slug";

        $response = $this->put("/posts/$post->id", $post->toArray());

        $response->assertStatus(403);

        $this->assertDatabaseMissing("posts", ["slug" => $post->slug]);

    }

    public function test_authenticated_user_can_delete_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create(["user_id" => Auth::id()]);

        $response = $this->delete("/posts/$post->id");

        $response->assertRedirect()
            ->assertStatus(302)
            ->assertSessionHas("message", "Post deleted successfully.");

        $this->assertDatabaseMissing("posts", ["slug" => $post->slug, "id" => $post->id]);

    }

    public function test_unauthenticated_user_cannot_delete_post()
    {

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create();

        $response = $this->delete("/posts/$post->id");

        $response->assertStatus(403);

        $this->assertDatabaseHas("posts", ["slug" => $post->slug, "id" => $post->id]);

    }

    public function test_guest_cannot_delete_post()
    {

        $post = Post::factory()->create();

        $response = $this->delete("/posts/$post->id");

        $response->assertRedirect("/login")
            ->assertStatus(302);

        $this->assertDatabaseHas("posts", ["id" => $post->id, "slug" => $post->slug]);

    }

    public function test_a_post_requires_a_title()
    {

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->make(["title" => null]);

        $response = $this->post("/posts", $post->toArray());

        $response_2 = $this->put("/posts/$post->id", $post->toArray());

        $response->assertSessionHasErrors("title");

        $response_2->assertSessionHasErrors("title");

        $errors = session("errors");

        $this->assertEquals("The title field is required.", $errors->get("title")[0]);

        $this->assertDatabaseMissing("posts", ["slug" => $post->slug]);


    }

    public function test_a_post_requires_a_body()
    {
        $this->actingAs(User::factory()->create());

        $post = Post::factory()->make(["body" => null]);

        $response = $this->post("/posts", $post->toArray());

        $response_2 = $this->put("/posts/$post->id", $post->toArray());

        $response->assertSessionHasErrors("body");
        $response_2->assertSessionHasErrors("body");


        $errors = session("errors");

        $this->assertEquals("The body field is required.", $errors->get("body")[0]);

        $this->assertDatabaseMissing("posts", ["slug" => $post->slug]);
    }

    public function test_a_post_requires_a_category_id()
    {
        $this->actingAs(User::factory()->create());

        $post = Post::factory()->make(["category_id" => null]);

        $response = $this->post("/posts", $post->toArray());

        $response_2 = $this->put("/posts/$post->id", $post->toArray());

        $response->assertSessionHasErrors("category_id");

        $response_2->assertSessionHasErrors("category_id");

        $errors = session("errors");

        $this->assertEquals("The category id field is required.", $errors->get("category_id")[0]);

        $this->assertDatabaseMissing("posts", ["slug" => $post->slug]);

    }

    public function test_updated_post_requires_a_slug()
    {

        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create(["user_id" => Auth::id()]);

        $post->slug = null;

        $response = $this->put("/posts/$post->id", $post->toArray());

        $response_2 = $this->put("/posts/$post->id", $post->toArray());

        $response->assertSessionHasErrors("slug");

        $response_2->assertSessionHasErrors("slug");

        $errors = session("errors");

        $this->assertEquals("The slug field is required.", $errors->get("slug")[0]);

        $this->assertDatabaseMissing("posts", ["slug" => $post->title]);

    }

}
