<?php

namespace Database\Factories;

use App\Models\PropertyInvestmentCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyInvestment>
 */
class PropertyInvestmentFactory extends Factory
{
    public function definition(): array
    {
        $investmentCampaign = PropertyInvestmentCampaignFactory::new()->create();

        return [
            'property_investment_campaign_id' => $investmentCampaign->id,
            'property_id' => $investmentCampaign->property_id,
            'shares' => $this->getRandomValidSharesAmount($investmentCampaign),
        ];
    }

    public function investmentCampaign(PropertyInvestmentCampaign $investmentCampaign)
    {
        return $this->state([
            'property_investment_campaign_id' => $investmentCampaign->id,
            'property_id' => $investmentCampaign->property_id,
            'shares' => $this->getRandomValidSharesAmount($investmentCampaign),
        ]);
    }

    public function getRandomValidSharesAmount(PropertyInvestmentCampaign $investmentCampaign): int
    {
        return random_int(1, $investmentCampaign->remaining_amount->dividedBy($investmentCampaign->value_per_share)->toInt());
    }
}
