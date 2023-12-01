<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "unique_document_identifier" => $this->faker->randomNumber(9, 9),
            "value" => $this->faker->randomFloat(2, 0, 10000),
            "issue_date" => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d\TH:i:s.u\Z'),
            "sender_cnpj" => $this->faker->cnpj(false),
            "sender_name" => $this->faker->company(),
            "carrier_cnpj" => $this->faker->cnpj(false),
            "carrier_name" => $this->faker->company(),
            "user_id" => User::factory(),

        ];
    }
}
