<?php

namespace App\Traits;

trait Resolvable
{
    public static function resolve(array $parameters = []): static
    {
        return resolve(static::class, $parameters);
    }
}
