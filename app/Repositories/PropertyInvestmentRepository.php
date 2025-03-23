<?php

namespace App\Repositories;

use App\Data\CreatePropertyInvestmentData;
use App\Models\PropertyInvestment;
use App\Traits\Resolvable;

class PropertyInvestmentRepository
{
    use Resolvable;

    public function create(CreatePropertyInvestmentData $data): PropertyInvestment
    {
        $propertyInvestment = new PropertyInvestment;
        $propertyInvestment->property_investment_campaign_id = $data->campaign->id;
        $propertyInvestment->property_id = $data->campaign->property_id;
        $propertyInvestment->shares = $data->shares;

        $propertyInvestment->save();

        return $propertyInvestment;
    }
}
