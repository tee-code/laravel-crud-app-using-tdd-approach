<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository implements \App\Interfaces\CategoryRepositoryInterface
{

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return Category::paginate(5);
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        return Category::findOrFail($id)->first();
    }

    public function create(array $category)
    {
        // TODO: Implement create() method.

        return Category::create($category);

    }

    public function update($id, array $category)
    {
        // TODO: Implement update() method.

        return Category::whereId($id)->update($category);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return Category::destroy($id);
    }
}
