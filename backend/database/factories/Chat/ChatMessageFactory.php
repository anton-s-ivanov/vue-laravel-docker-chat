<?php

namespace Database\Factories\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => User::all()->random()->id,
            'recipient_id' => User::all()->random()->id,
            'message' => fake()->realTextBetween(20, 100)
        ];
    }
}
