<?php


namespace App\Http\Traits;


use Illuminate\Support\Str;

trait PostTrait
{
    public function createSlug($string)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug . Str::random(25);

    }

}
