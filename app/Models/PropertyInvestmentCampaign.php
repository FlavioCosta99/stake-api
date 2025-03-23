<?php

namespace App\Models;

use App\Builders\PropertyInvestmentCampaignBuilder;
use App\Casts\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\HasBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $property_id
 * @property string $name
 * @property ?string $image_url
 * @property Money $target_amount
 * @property Money $value_per_share
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property-read Property $property
 * @property-read int $percentage_raised
 */
class PropertyInvestmentCampaign extends Model
{
    use HasBuilder;

    protected static string $builder = PropertyInvestmentCampaignBuilder::class;

    protected $casts = [
        'target_amount' => Money::class,
        'value_per_share' => Money::class,
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(
            PropertyInvestment::class,
            foreignKey: 'property_investment_campaign_id',
            localKey: 'id'
        );
    }

    protected function raisedAmount(): Attribute
    {
        return Attribute::get(
            fn () => $this->value_per_share
                ->multipliedBy(
                    $this->investments()->sum('shares')
                )
        );
    }

    protected function percentageRaised(): Attribute
    {
        $percentage = $this->raised_amount->toFloat() / $this->target_amount->toFloat();

        return Attribute::get(
            fn () => $percentage === 0.0 ? '0%' : sprintf('%.10f%%', $percentage)
        );
    }

    protected function numberOfInvestors(): Attribute
    {
        return Attribute::get(fn () => $this->investments()->count());
    }

    protected function remainingAmount(): Attribute
    {
        return Attribute::get(
            fn () => $this->target_amount->minus($this->raised_amount)
        );
    }
}
