<?php


namespace App\Interfaces;


interface PostRepositoryInterface
{
    public function getPostBySlug(string $slug);
    public function getPostById($id);
    public function getAllPosts();
    public function create(array $post);
    public function update($id, array $post);
    public function delete($id);
    public function createPostSlug(string $string);
}
