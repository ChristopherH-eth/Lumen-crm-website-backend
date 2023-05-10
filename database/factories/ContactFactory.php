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
            'title' => $this->faker->word,
            'reports_to' => $this->faker->numberBetween(
                $min = 1, $max = 10
            ),                                                              // Linked contact
            'description' => $this->faker->text($maxNbChars = 500),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_opt_out' => $this->faker->boolean,
            'user_id' => $this->faker->numberBetween(
                $min = 1, $max = 10
            ),                                                              // Contact owner
            'account_id' => $this->faker->numberBetween(
                $min = 1, $max = 10
            )                                                               // Linked account
        ];
    }
}
