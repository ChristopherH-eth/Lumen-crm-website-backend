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
        // Create the full name property
        $firstName = $this->faker->firstName('female');
        $lastName = $this->faker->lastName;
        $fullName = $firstName . " " . $lastName;

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'salutation' => $this->faker->title(
                $gender = 'male'|'female'
            ),
            'company' => $this->faker->word,
            'title' => $this->faker->word,
            'website' => $this->faker->word,
            'description' => $this->faker->text($maxNbChars = 500),
            'lead_status' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_opt_out' => $this->faker->boolean,
            'email' => $this->faker->unique()->safeEmail,
            'email_opt_out' => $this->faker->boolean,
            'number_of_employees' => $this->faker->numberBetween(
                $min = 50, $max = 10000
            ),
            'annual_revenue' => $this->faker->randomFloat(
                $nbMaxDecimals = 2, $min = 10000, $max = 1000000
            ),
            'lead_source' => $this->faker->word,
            'industry' => $this->faker->word,
            'user_id' => $this->faker->numberBetween(
                $min = 1, $max = 10
            ),                                                              // Lead owner
        ];
    }
}
