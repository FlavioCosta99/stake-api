<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $property_investment_campaign_id
 * @property int $property_id
 * @property int $shares
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property-read  $percentage
 * @property-read string $percentage
 */
class PropertyInvestment extends Model
{
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(
            related: PropertyInvestmentCampaign::class,
            foreignKey: 'property_investment_campaign_id',
            ownerKey: 'id'
        );
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function sharesTotalValue(): Attribute
    {
        return Attribute::get(
            fn () => $this->campaign->value_per_share->multipliedBy($this->shares)
        );
    }

    public function percentage(): Attribute
    {
        return Attribute::get(
            fn () => sprintf('%.10f%%', ($this->shares_total_value->toFloat() / $this->campaign->target_amount->toFloat()))
        );
    }
}
