<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


class CategoryTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function test_all_categories_can_be_read()
    {
        $this->withoutExceptionHandling();

        $category = Category::factory()->create();

        $response = $this->get("/categories")->assertStatus(200);

        $response->assertSee($category->title);

    }

    public function test_a_category_can_be_read()
    {
        $this->withoutExceptionHandling();

        $category = Category::factory()->create();

        $response = $this->get("/categories/$category->id");

        $response->assertStatus(200)
                ->assertSee($category->name)
                ->assertSee($category->description);

    }


    public function test_authenticated_user_can_create_a_category(){

        $this->withoutExceptionHandling();

        //Given that we have a category model
        $category = Category::factory()->make()->toArray();

        //Given an authenticated user

        $response = $this->actingAs(User::factory()->create())->post("/categories", $category);

        $this->assertEquals(1, Category::all()->count());

        $response->assertRedirect("/categories")
            ->assertSessionHas(["message" => "Category added successfully."])
            ->assertStatus(302);

        $this->assertDatabaseHas("categories", $category);

    }

    public function test_guest_cannot_create_category()
    {

        $category = Category::factory()->make()->toArray();

        $response = $this->post("/categories", $category);

        $response->assertRedirect("/login");

        $response->assertStatus(302);

    }

    public function test_duplicate_category_name_on_authenticaated_user()
    {

        $this->actingAs(User::factory()->create());

        $first_category = Category::factory()->create();

        $second_category = Category::factory()->make(["name" => $first_category->name])->toArray();

        $response = $this->post("/categories", $second_category);

        $errors = session('errors');

        $response->assertSessionHasErrors("name");

        $this->assertEquals($errors->get('name')[0], "The name has already been taken.");

        $response->assertRedirect();

        $response->assertStatus(302);

    }

    public function test_authenticated_user_can_update_a_category()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $category->name = "Updated";

        $response = $this->put("/categories/$category->id", $category->toArray());

        $this->assertDatabaseHas("categories", ["id" => $category->id, "name" => "Updated"]);

        $response->assertRedirect("/categories/$category->id/edit");

        // $response->assertRedirectToSignedRoute("categories.edit", $category->id);

        $response->assertSessionHas(["message" => "Category updated successfully."]);

        $response->assertStatus(302);

    }

    public function test_authenticated_user_can_delete_a_category()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $response = $this->delete("/categories/$category->id");

        $this->assertDatabaseMissing("categories", ["id" => $category->id]);

        $response->assertRedirect("/categories")
            ->assertSessionHas("message", "Category deleted successfully.")
            ->assertStatus(302);

    }

}
