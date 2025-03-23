<?php

namespace Database\Seeders;

use Database\Factories\PropertyInvestmentCampaignFactory;
use Illuminate\Database\Seeder;

class PropertyInvestmentCampaignsSeeder extends Seeder
{
    public function run(): void
    {
        PropertyInvestmentCampaignFactory::new()->count(200)->create();
    }
}
