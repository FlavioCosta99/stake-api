<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    public function definition(): array
    {
        $city = fake()->city();

        return [
            'city' => City::query()->where('name', $city)->exists() ? $city : CityFactory::new()->name($city),
            'area' => fake()->streetName(),
        ];
    }

    public function city(City $city): static
    {
        return $this->state([
            'city' => $city->name,
        ]);
    }

    public function area(string $area): static
    {
        return $this->state([
            'area' => $area,
        ]);
    }
}
