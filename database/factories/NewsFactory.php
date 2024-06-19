<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'content' => $this->faker->paragraph,
            'image' =>  $this->faker->image('storage/app/public/images/news', 640, 480, null, false),
            'author_id' => User::all()->random()->id,
        ];
    }
}
