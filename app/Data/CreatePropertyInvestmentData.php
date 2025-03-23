<?php

namespace App\Data;

use App\Casts\Money;
use App\Models\PropertyInvestmentCampaign;
use App\Services\PropertyInvestment\PropertyInvestmentValidator;
use Spatie\LaravelData\Data;

class CreatePropertyInvestmentData extends Data
{
    public readonly ?int $shares;

    public function __construct(
        public readonly PropertyInvestmentCampaign $campaign,
        public readonly Money $amount,
    ) {
        PropertyInvestmentValidator::resolve()
            ->assertCanInvestAmount($this->campaign, $this->amount);

        $this->shares = $this->amount->dividedBy($campaign->value_per_share)->toInt();
    }
}
