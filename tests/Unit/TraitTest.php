<?php

namespace Tests\Unit;

use App\Http\Traits\PostTrait;

class TraitTest extends \Tests\TestCase
{
    use PostTrait;

    public function test_create_slug_function_returns_string()
    {
        $string = "title example";

        $response = $this->createSlug($string);

        $this->assertStringContainsString("title-example", $response);

        $this->assertIsString($response);
    }

}
