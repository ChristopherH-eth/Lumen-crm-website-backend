<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_name' => $this->faker->name,
            'website' => $this->faker->word,
            'type' => $this->faker->word,
            'description' => $this->faker->text($maxNbChars = 500),
            'phone' => $this->faker->phoneNumber,
            'user_id' => $this->faker->numberBetween(
                $min = 1, $max = 10
            )                                                               // Account owner
            
        ];
    }
}
