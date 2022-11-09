<?php

namespace Database\Factories;

use App\Services\PageService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->jobTitle();
        $slug = Str::slug($title, '_');
        return [
            //
            'title'=>$title,
            'slug'=>$slug,
            'full_slug_path'=>$slug,
            'content'=>$this->faker->realText(400),

        ];
    }
}
