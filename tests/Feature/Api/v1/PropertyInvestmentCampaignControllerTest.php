<?php

namespace Tests\Feature\Api\v1;

use App\Models\PropertyInvestmentCampaign;
use Database\Factories\PropertyFactory;
use Database\Factories\PropertyInvestmentCampaignFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyInvestmentCampaignControllerTest extends TestCase
{
    use RefreshDatabase;

    private PropertyInvestmentCampaign $propertyInvestmentCampaign;

    protected function setUp(): void
    {
        parent::setUp();

        $this->propertyInvestmentCampaign = PropertyInvestmentCampaignFactory::new()->create();
    }

    public function test_store_endpoint(): void
    {
        $this->assertStringContainsString(
            sprintf(
                '/api/v1/properties/%s/campaigns/%s/invest',
                $this->propertyInvestmentCampaign->property_id,
                $this->propertyInvestmentCampaign->id
            ),
            route('api.v1.properties.property.campaigns.invest', [
                $this->propertyInvestmentCampaign->property_id,
                $this->propertyInvestmentCampaign->id,
            ])
        );
    }

    public function test_it_stores_investment(): void
    {
        $payload = [
            'amount' => $this->propertyInvestmentCampaign->value_per_share->multipliedBy(2)->toFloat(),
        ];

        $this->postJson(
            route('api.v1.properties.property.campaigns.invest', [
                $this->propertyInvestmentCampaign->property_id,
                $this->propertyInvestmentCampaign->id,
            ]),
            $payload
        )->assertCreated()->assertJsonFragment([
            'id' => $this->propertyInvestmentCampaign->id,
            'amount' => $payload['amount'],
        ]);
    }

    public function test_it_returns_not_found_when_property_id_and_campaign_property_id_dont_match(): void
    {
        $payload = [
            'amount' => $this->propertyInvestmentCampaign->value_per_share->toFloat(),
        ];

        $property = PropertyFactory::new()->create();

        $this->postJson(
            route('api.v1.properties.property.campaigns.invest', [
                $property->id,
                $this->propertyInvestmentCampaign->id,
            ]),
            $payload
        )->assertNotFound();
    }

    public function test_it_returns_validation_error_when_investment_amount_is_invalid(): void
    {
        $payload = [
            'amount' => $this->propertyInvestmentCampaign->value_per_share->plus(1)->toFloat(),
        ];

        $this->postJson(
            route('api.v1.properties.property.campaigns.invest', [
                $this->propertyInvestmentCampaign->property_id,
                $this->propertyInvestmentCampaign->id,
            ]),
            $payload
        )->assertUnprocessable();
    }
}
