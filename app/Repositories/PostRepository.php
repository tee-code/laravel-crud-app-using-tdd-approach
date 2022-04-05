<?php


namespace App\Repositories;


use App\Http\Traits\PostTrait;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostRepository implements \App\Interfaces\PostRepositoryInterface
{
    use PostTrait;

    public function getPostBySlug(string $slug)
    {
        // TODO: Implement getPostBySlug() method.
        return Post::where("slug", $slug)->first();
    }

    public function getPostById($id)
    {
        // TODO: Implement getPostById() method.
        return Post::findOrFail($id)->first();
    }

    public function getAllPosts()
    {
        // TODO: Implement getAllPosts() method.
        return Post::latest()->paginate(25);
    }

    public function create(array $post)
    {
        // TODO: Implement create() method.
        $slug = $this->createSlug($post['title']);

        $post['slug'] = $slug;

        $post['user_id'] = Auth::user()->id;

        return Post::create($post);

    }

    public function update($id, array $post)
    {
        // TODO: Implement update() method.
        return Post::whereId($id)->update($post);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.

        return Post::destroy($id);
    }

    public function createPostSlug(string $string)
    {
        // TODO: Implement createSlug() method.
        return $this->createSlug($string);
    }
}
