<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'location_id' => LocationFactory::new(),
        ];
    }

    public function location(Location $location): static
    {
        return $this->state([
            'location_id' => $location->id,
        ]);
    }
}
