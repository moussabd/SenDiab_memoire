<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()
                ->unique()
                ->safeEmail(),
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'remember_token' => \Str::random(10),
            'age' => fake()->randomNumber(0),
            'phone_number' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
            'place_of_birth' => fake()->text(255),
            'firstname' => fake()->firstName(),
            'two_factor_secret' => fake()->text(),
            'two_factor_recovery_codes' => fake()->text(),
            'lastname' => fake()->lastName(),
            'deleted_at' => null,
            'cni' => fake()->text(255),
            'address' => fake()->address(),
            'civility' => 'M.',
            'gender' => \Arr::random(['male', 'female', 'other']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
