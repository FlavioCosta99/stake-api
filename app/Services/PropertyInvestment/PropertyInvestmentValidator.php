<?php

namespace App\Services\PropertyInvestment;

use App\Casts\Money;
use App\Exceptions\InvalidInvestmentAmountException;
use App\Models\PropertyInvestmentCampaign;
use App\Traits\Resolvable;

class PropertyInvestmentValidator
{
    use Resolvable;

    /**
     * @throws InvalidInvestmentAmountException
     */
    public function assertCanInvestAmount(PropertyInvestmentCampaign $campaign, Money $amount): void
    {
        if (! $campaign->value_per_share->isRemainderZero($amount)) {
            throw new InvalidInvestmentAmountException("Amount is not a multiple of the expected investment_multiple: {$campaign->value_per_share->toString()}");
        }

        if ($campaign->remaining_amount->minus($amount->toFloat())->money->isNegative()) {
            throw new InvalidInvestmentAmountException("Amount surpasses target_amount of {$campaign->target_amount->toString()}");
        }
    }
}
