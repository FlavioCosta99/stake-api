<?php

namespace App\Repositories;

use App\Data\CreateDividendDistributionData;
use App\Enums\DistributionStatus;
use App\Models\DividendDistribution;
use App\Models\Property;
use App\Traits\Resolvable;
use Illuminate\Contracts\Database\Query\Builder;

class DividendDistributionsRepository
{
    use Resolvable;

    public function create(CreateDividendDistributionData $data): DividendDistribution
    {
        $dividendDistribution = new DividendDistribution;
        $dividendDistribution->property_investment_id = $data->propertyInvestment->id;
        $dividendDistribution->amount = $data->amount->toFloat();
        $dividendDistribution->status = DistributionStatus::PENDING;

        $dividendDistribution->save();

        return $dividendDistribution;
    }

    public function filterForPendingDistributionsForProperty(Property $property): Builder
    {
        return DividendDistribution::query()
            ->where('status', DistributionStatus::PENDING)
            ->whereHas('propertyInvestment', fn ($query) => $query->where('property_id', $property->id));
    }

    public function markAsFinished(DividendDistribution $distribution): DividendDistribution
    {
        $distribution->status = DistributionStatus::FINISHED;
        $distribution->save();

        return $distribution;
    }
}
