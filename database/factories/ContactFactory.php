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
        return [
            'first_name' => $this->faker->firstName('female'),
            'last_name' => $this->faker->lastName,
            'account_id' => $this->faker->numberBetween(1, 10),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
