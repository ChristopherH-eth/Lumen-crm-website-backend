<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lead;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

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
            'company' => $this->faker->word,
            'lead_status' => $this->faker->word,
            'user_id' => $this->faker->numberBetween(1, 10),                // Lead owner
            'email' => $this->faker->unique()->safeEmail,
            'email_opt_out' => $this->faker->boolean
        ];
    }
}
