<?php

namespace Database\Seeders;

use App\Models\City;
use Database\Factories\LocationFactory;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        $city = City::query()
            ->where('name', 'Dubai')
            ->firstOrFail();

        collect([
            'Dubai Islands',
            'Sobha Hartland',
            'Dubai Marina',
        ])->each(fn (string $area) => LocationFactory::new()->city($city)->area($area)->create());

        $city = City::query()
            ->where('name', 'Abu Dhabi')
            ->firstOrFail();

        collect([
            'Al Reem Island',
            'Yas Island',
            'Saadiyat Island',
        ])->each(fn (string $area) => LocationFactory::new()->city($city)->area($area)->create());
    }
}
