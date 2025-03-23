<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PropertyInvestmentCampaignsFilter extends Data
{
    public function __construct(
        public ?string $name,
        public ?float $target_amount_from,
        public ?float $target_amount_to,
    ) {}
}
