<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $location_id
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property-read Location $location
 */
class Property extends Model
{
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(
            PropertyInvestment::class
        );
    }

    protected function totalNumberOfInvestorShares(): Attribute
    {
        return Attribute::get(
            fn () => $this->investments()->sum('shares')
        );
    }
}
