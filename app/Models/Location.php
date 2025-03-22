<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property int $id
 * @property string $city
 * @property string $area
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property-read Country $country
 */
class Location extends Model
{
    public function country(): HasOneThrough
    {
        return $this->hasOneThrough(
            related: Country::class,
            through: City::class,
            firstKey: 'name',
            secondKey: 'iso',
            localKey: 'city',
            secondLocalKey: 'country_iso'
        );
    }
}
