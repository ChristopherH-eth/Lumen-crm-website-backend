<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Opportunity;

class OpportunityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Opportunity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'opportunity_name' => $this->faker->name,
            'type' => $this->faker->word,
            'follow_up' => $this->faker->boolean,
            'close_date' => $this->faker->dateTime(
                $max = 'now', $timezone = null
            ),
            'stage' => $this->faker->word,
            'probability' => $this->faker->numberBetween(
                $min = 0, $max = 100
            ),
            'amount' => $this->faker->randomFloat(
                $nbMaxDecimals = 2, $min = 0, $max = 100000
            ),
            'lead_source' => $this->faker->word,
            'next_step' => $this->faker->word,
            'description' => $this->faker->text($maxNbChars = 500),
            'user_id' => $this->faker->numberBetween(1, 10),                // Lead owner
            'account_id' => $this->faker->numberBetween(1, 10)              // Linked account
        ];
    }
}
