<?php

namespace App\Data;

use App\Casts\Money;
use App\Models\PropertyInvestment;
use Spatie\LaravelData\Data;

class CreateDividendDistributionData extends Data
{
    public function __construct(
        public readonly PropertyInvestment $propertyInvestment,
        public readonly Money $amount,
    ) {}
}
