<?php

namespace Database\Factories;

use App\Models\User;
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
     * @return array
     */
    public function definition()
    {
        // Create the full name property
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $fullName = $firstName . " " . $lastName;

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password
        ];
    }
}
