<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $iso
 * @property string $name
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property-read Collection<City> cities
 */
class Country extends Model
{
    protected $primaryKey = 'iso';

    protected $keyType = 'string';

    public function cities(): HasMany
    {
        return $this->hasMany(
            related: City::class,
            foreignKey: 'country_iso',
            localKey: 'iso'
        );
    }
}
