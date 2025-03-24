<?php

namespace Database\Seeders;

use Database\Factories\PropertyInvestmentCampaignFactory;
use Database\Factories\PropertyInvestmentFactory;
use Illuminate\Database\Seeder;

class PropertyInvestmentsSeeder extends Seeder
{
    public function run(): void
    {
        PropertyInvestmentFactory::new()->count(50)->create();

        $propertyInvestmentCampaign = PropertyInvestmentCampaignFactory::new()->create();
        for ($i = 0; $i < 2000; $i++) {
            PropertyInvestmentFactory::new()->investmentCampaign($propertyInvestmentCampaign)->create();
        }
    }
}
