<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function update(User $user, Post $post)
    {
        return $post->user_id == $user->id;
    }

    public function delete(User $user, Post $post)
    {
        return $post->user_id == $user->id;
    }

    public function edit(User $user, Post $post)
    {
        return $post->user_id == $user->id;
    }
}
