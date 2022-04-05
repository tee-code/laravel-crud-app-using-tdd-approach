<?php


namespace App\Http\Traits;


trait PostTrait
{
    public function createSlug($string)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug;

    }

}
