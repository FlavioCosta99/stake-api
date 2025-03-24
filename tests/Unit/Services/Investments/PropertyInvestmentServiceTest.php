<?php

namespace Tests\Unit\Services;

use App\Models\PropertyInvestmentCampaign;
use App\Services\PropertyInvestment\PropertyInvestmentService;
use Database\Factories\PropertyInvestmentCampaignFactory;
use Tests\TestCase;

class PropertyInvestmentServiceTest extends TestCase
{
    private PropertyInvestmentService $propertyInvestmentService;

    private PropertyInvestmentCampaign $propertyInvestmentCampaign;

    protected function setUp(): void
    {
        parent::setUp();

        $this->propertyInvestmentCampaign = PropertyInvestmentCampaignFactory::new()->create();

        $this->propertyInvestmentService = PropertyInvestmentService::resolve();
    }

    public function test_it_creates_property_investment(): void
    {
        $amount = $this->propertyInvestmentCampaign->value_per_share->multipliedBy(2);

        $propertyInvestment = $this->propertyInvestmentService->invest($this->propertyInvestmentCampaign, $amount);

        $this->assertEquals($amount, $propertyInvestment->shares_total_value);
        $this->assertEquals($this->propertyInvestmentCampaign->id, $propertyInvestment->property_investment_campaign_id);
    }
}
