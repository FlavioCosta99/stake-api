<?php

namespace Tests\Unit\Services;

use App\Exceptions\InvalidInvestmentAmountException;
use App\Models\PropertyInvestmentCampaign;
use App\Services\PropertyInvestment\PropertyInvestmentValidator;
use Database\Factories\PropertyInvestmentCampaignFactory;
use Database\Factories\PropertyInvestmentFactory;
use Tests\TestCase;

class PropertyInvestmentValidatorTest extends TestCase
{
    private PropertyInvestmentValidator $propertyInvestmentValidator;

    private PropertyInvestmentCampaign $propertyInvestmentCampaign;

    protected function setUp(): void
    {
        parent::setUp();

        $this->propertyInvestmentCampaign = PropertyInvestmentCampaignFactory::new()->create();

        $this->propertyInvestmentValidator = PropertyInvestmentValidator::resolve();
    }

    public function test_it_throws_exception_when_it_isnt_multiple_of_investment_multiple(): void
    {
        $this->expectException(InvalidInvestmentAmountException::class);

        $this->propertyInvestmentValidator->assertCanInvestAmount(
            $this->propertyInvestmentCampaign,
            $this->propertyInvestmentCampaign->value_per_share->multipliedBy(1.2)
        );
    }

    public function test_it_doesnt_throw_exception_for_multiples_of_investment_multiple(): void
    {
        $this->propertyInvestmentValidator->assertCanInvestAmount(
            $this->propertyInvestmentCampaign,
            $this->propertyInvestmentCampaign->value_per_share->multipliedBy(2)
        );
    }

    public function test_it_throws_exception_when_target_value_is_surpassed(): void
    {
        PropertyInvestmentFactory::new()->investmentCampaign($this->propertyInvestmentCampaign)->create();

        $this->propertyInvestmentCampaign->refresh();
        $this->expectException(InvalidInvestmentAmountException::class);

        $this->propertyInvestmentValidator->assertCanInvestAmount(
            $this->propertyInvestmentCampaign,
            $this->propertyInvestmentCampaign->target_amount
        );
    }

    public function test_it_doesnt_throw_exception_when_target_value_is_not_surpassed(): void
    {
        $this->propertyInvestmentValidator->assertCanInvestAmount(
            $this->propertyInvestmentCampaign,
            $this->propertyInvestmentCampaign->target_amount
        );
    }
}
