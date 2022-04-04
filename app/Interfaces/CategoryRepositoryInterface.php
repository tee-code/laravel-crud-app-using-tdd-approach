<?php


namespace App\Interfaces;


interface CategoryRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $category);
    public function update($id, array $category);
    public function delete($id);

}
