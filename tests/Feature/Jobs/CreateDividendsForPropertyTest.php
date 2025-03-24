<?php

namespace Tests\Feature\Api\v1;

use App\Casts\Money;
use App\Jobs\CreateDividendsForProperty;
use App\Models\DividendDistribution;
use App\Models\PropertyInvestmentCampaign;
use Database\Factories\PropertyInvestmentCampaignFactory;
use Database\Factories\PropertyInvestmentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDividendsForPropertyTest extends TestCase
{
    use RefreshDatabase;

    private PropertyInvestmentCampaign $propertyInvestmentCampaign;

    protected function setUp(): void
    {
        parent::setUp();

        $this->propertyInvestmentCampaign = PropertyInvestmentCampaignFactory::new()->create();

        for ($i = 0; $i < 2000; $i++) {
            PropertyInvestmentFactory::new()->investmentCampaign($this->propertyInvestmentCampaign)->create();
        }
    }

    public function test_it_creates_dividends(): void
    {
        $amount = Money::create(12345);

        CreateDividendsForProperty::dispatchSync($this->propertyInvestmentCampaign->property, $amount);

        $this->assertEquals(
            2000,
            DividendDistribution::query()
                ->whereHas(
                    'propertyInvestment',
                    fn ($query) => $query->where('property_id', $this->propertyInvestmentCampaign->property_id)
                )->count()
        );
    }
}
