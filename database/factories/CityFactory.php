<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        $countryIso = fake()->countryCode();

        return [
            'name' => fake()->city(),
            'country_iso' => Country::query()->where('iso', $countryIso)->exists()
                ? $countryIso
                : CountryFactory::new()->iso($countryIso),
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
