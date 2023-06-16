<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'path' => $this->faker->image('public/storage', 640, 480, null, false),
            'size' => $this->faker->randomNumber(2),
            'type' => $this->faker->mimeType,
        ];
    }
}
