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
        return [
            'first_name' => $this->faker->firstName('female'),
            'last_name' => $this->faker->lastName,
            'company' => $this->faker->word,
            'lead_status' => $this->faker->word,
            'lead_owner' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_opt_out' => $this->faker->boolean
        ];
    }
}
