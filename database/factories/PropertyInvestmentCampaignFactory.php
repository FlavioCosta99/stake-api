<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyInvestmentCampaign>
 */
class PropertyInvestmentCampaignFactory extends Factory
{
    public function definition(): array
    {
        $property = PropertyFactory::new()->create();
        $investmentMultiple = random_int(200, 1000);
        $targetAmount = $investmentMultiple * random_int(100000, 750000000);

        return [
            'name' => self::getCampaignNameForProperty($property),
            'property_id' => $property->id,
            'target_amount' => $targetAmount,
            'value_per_share' => $investmentMultiple,
        ];
    }

    private static function getCampaignNameForProperty(Property $property): string
    {
        return sprintf('%s bedroom property in %s', rand(1, 7), $property->location->area);
    }
}
