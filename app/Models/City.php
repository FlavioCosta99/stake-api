<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $country_iso
 * @property ?Carbon $created_at
 * @property ?Carbon @updated_at
 * @property-read Country $country
 */
class City extends Model
{
    protected $primaryKey = 'name';

    protected $keyType = 'string';

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
