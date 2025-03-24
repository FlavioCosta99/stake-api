<?php

namespace App\Repositories;

use App\Data\CreatePropertyInvestmentData;
use App\Models\Property;
use App\Models\PropertyInvestment;
use App\Traits\Resolvable;
use Illuminate\Contracts\Database\Query\Builder;

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

    public function filterApprovedInvestorsForProperty(Property $property): Builder
    {
        return PropertyInvestment::query()
            ->where('property_id', $property->id);
    }
}
