<?php

namespace App\Builders;

use App\Data\PropertyInvestmentCampaignsFilter;
use Illuminate\Database\Eloquent\Builder;

class PropertyInvestmentCampaignBuilder extends Builder
{
    public function wherePropertyId(int $propertyId): self
    {
        return $this->where('property_id', $propertyId);
    }

    public function filter(PropertyInvestmentCampaignsFilter $filters): self
    {
        [
            'name' => $name,
            'target_amount_from' => $target_amount_from,
            'target_amount_to' => $target_amount_to
        ] = $filters->toArray();

        return $this
            ->when(
                ! empty($name),
                fn (self $query) => $query->searchName($name)
            )
            ->when(
                ! is_null($target_amount_from),
                fn (self $query) => $query->whereTargetAmountBiggerThanOrEqualTo($target_amount_from)
            )->when(
                ! is_null($target_amount_to),
                fn (self $query) => $query->whereTargetAmountLessThanOrEqualTo($target_amount_to)
            );
    }

    public function searchName(string $name): self
    {
        $terms = explode(' ', preg_replace('/\s+/', ' ', str_replace(',', ' ', $name)));

        foreach ($terms as $term) {
            $this->query->where('name', 'ilike', "%$term%");
        }

        return $this;
    }

    public function whereTargetAmountBiggerThanOrEqualTo(float $value): self
    {
        return $this->where('target_amount', '>=', $value);
    }

    public function whereTargetAmountLessThanOrEqualTo(float $value): self
    {
        return $this->where('target_amount', '<=', $value);
    }
}
