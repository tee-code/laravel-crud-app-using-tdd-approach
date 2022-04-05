<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Repositories\PostRepository;

class PostController extends Controller
{

    public function __construct(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;

        $this->middleware("auth")->except(["index", "show","findBySlug"]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->getAllPosts();

        return view("posts.index", compact("posts"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAll();

        return view("posts.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {

        $this->postRepository->create($request->validated());

        return back()->with("message", "Post created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view("posts.show", compact("post"));
    }

    public function findBySlug($slug)
    {
        $post = $this->postRepository->getPostBySlug($slug);

        return view("posts.show", compact("post"));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        $this->authorize("edit", $post);

        $categories = $this->categoryRepository->getAll();

        return view("posts.edit", compact("post", "categories"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize("update", $post);

        $this->postRepository->update($post->id, $request->validated());

        return back()->with("message", "Post updated successfully.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize("delete", $post);

        $this->postRepository->delete($post->id);

        return back()->with("message", "Post deleted successfully.");

    }
}
