<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $property_investment_id
 * @property string $status
 * @property Money $amount
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class DividendDistribution extends Model
{
    protected $casts = [
        'amount' => Money::class,
        'value_per_share' => Money::class,
    ];

    public function propertyInvestment(): BelongsTo
    {
        return $this->belongsTo(PropertyInvestment::class);
    }
}
