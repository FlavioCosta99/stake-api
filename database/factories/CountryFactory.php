<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'iso' => fake()->countryCode(),
            'name' => fake()->country(),
        ];
    }

    public function iso(string $iso): static
    {
        return $this->state([
            'iso' => $iso,
        ]);
    }

    public function name(string $name): static
    {
        return $this->state([
            'name' => $name,
        ]);
    }
}
