<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = $this->faker->firstName('female');
        $lastName = $this->faker->lastName;
        $fullName = $firstName . " " . $lastName;

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'account_id' => $this->faker->numberBetween(1, 10),             // Linked account
            'user_id' => $this->faker->numberBetween(1, 10),                // Contact owner
            'email' => $this->faker->unique()->safeEmail,
            'email_opt_out' => $this->faker->boolean
        ];
    }
}
