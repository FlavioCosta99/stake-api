<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
