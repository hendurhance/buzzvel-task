<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bool = $this->faker->boolean;
        $fileIds = File::pluck('id')->toArray();
        $fileArray = [$fileIds, []];
        $userIds = User::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($userIds),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'completed' => $bool,
            'completed_at' => $bool ?  $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'file' => $this->faker->randomElement($fileArray),
        ];
    }
}
