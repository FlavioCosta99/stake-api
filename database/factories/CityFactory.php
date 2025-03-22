<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->city(),
            'country_iso' => CountryFactory::new()->iso(fake()->countryCode()),
        ];
    }

    public function name(string $name): static
    {
        return $this->state([
            'name' => $name,
        ]);
    }

    public function country_iso(string $iso): static
    {
        return $this->state([
            'country_iso' => $iso,
        ]);
    }
}
