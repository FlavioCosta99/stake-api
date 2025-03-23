<?php

namespace Database\Seeders;

use Database\Factories\PropertyInvestmentFactory;
use Illuminate\Database\Seeder;

class PropertyInvestmentsSeeder extends Seeder
{
    public function run(): void
    {
        PropertyInvestmentFactory::new()->count(200)->create();
    }
}
