<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'message_id' => Str::random(51),
            'from' => fake()->unique()->safeEmail(),
            'to' => fake()->unique()->safeEmail(),
            'spam_verdict' => true,
            'virus_verdict' => true,
            'subject' => fake()->sentence(),
            'html' => fake()->randomHtml(),
        ];
    }
}
