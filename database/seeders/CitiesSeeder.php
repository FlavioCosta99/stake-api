<?php

namespace Database\Seeders;

use Database\Factories\CityFactory;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        collect([
            'Dubai',
            'Abu Dhabi',
            'Sharjah',
            'Al Ain',
        ])->each(fn (string $city) => CityFactory::new()->country_iso('AE')->name($city)->create());

        collect([
            'Riyadh',
            'Jeddah',
            'Mecca',
            'Medina',
        ])->each(fn (string $city) => CityFactory::new()->country_iso('SA')->name($city)->create());
    }
}
