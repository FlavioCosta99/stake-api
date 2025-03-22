<?php

namespace Database\Seeders;

use Database\Factories\CountryFactory;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        CountryFactory::new()->iso('AE')->name('United Arab Emirates')->create();
        CountryFactory::new()->iso('SA')->name('Saudi Arabia')->create();
    }
}
