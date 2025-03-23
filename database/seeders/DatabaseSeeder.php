<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountriesSeeder::class,
            CitiesSeeder::class,
            LocationsSeeder::class,
            PropertiesSeeder::class,
            PropertyInvestmentCampaignsSeeder::class,
            PropertyInvestmentsSeeder::class,
        ]);
    }
}
