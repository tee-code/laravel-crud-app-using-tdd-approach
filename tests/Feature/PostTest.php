<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


class PostTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    public function test_all_users_can_view_index_page()
    {}

    public function test_all_users_can_view_show_page()
    {}

    public function test_user_can_read_all_posts()
    {}

    public function test_user_can_read_a_post_by_slug()
    {}

    public function test_user_should_be_redirected_if_slug_not_found()
    {}

    public function test_authenticated_user_can_create_post()
    {}

    public function test_guest_cannot_create_a_post()
    {}

    public function test_authenticated_user_cannot_create_already_exist_post()
    {}

    public function test_authenticated_user_can_update_post()
    {}

    public function test_guest_cannot_update_post()
    {}

    public function test_authenticated_user_can_delete_post()
    {}

    public function test_guest_cannot_delete_post()
    {}

}
