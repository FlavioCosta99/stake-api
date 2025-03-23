<?php

namespace App\Casts;

use Brick\Math\RoundingMode;
use Brick\Money\Currency;
use Brick\Money\Money as MoneyMoney;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class Money implements CastsAttributes
{
    public MoneyMoney $money;

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return self::create(
            amount: $value,
            precision: 2
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof self) {
            return $value->toFloat();
        }

        return $value;
    }

    public static function create(float $amount, int $precision = 2, RoundingMode $roundingMode = RoundingMode::UNNECESSARY): mixed
    {
        $currency = new Currency(
            currencyCode: 'AED',
            numericCode: 784,
            name: 'United Arab Emirates dirham',
            defaultFractionDigits: $precision,
        );

        $money = new self;

        $money->money = MoneyMoney::of(
            amount: $amount,
            currency: $currency,
            roundingMode: $roundingMode
        );

        return $money;
    }

    public function isRemainderZero(Money $amount): bool
    {
        return $amount->toFloat() % $this->toFloat() === 0;
    }

    public function multipliedBy(float|int|self $value): self
    {
        if ($value instanceof self) {
            $value = $value->toFloat();
        }

        $result = $this->money->multipliedBy($value);

        return self::create($result->getAmount()->toFloat());
    }

    public function dividedBy(float|int|self $value, RoundingMode $roundingMode = RoundingMode::UNNECESSARY): self
    {
        if ($value instanceof self) {
            $value = $value->toFloat();
        }

        $result = $this->money->dividedBy($value, $roundingMode);

        return self::create($result->getAmount()->toFloat());
    }

    public function minus(float|int|self $value): self
    {
        if ($value instanceof self) {
            $value = $value->toFloat();
        }

        $result = $this->money->minus($value);

        return self::create($result->getAmount()->toFloat());
    }

    public function plus(float|int|self $value): self
    {
        if ($value instanceof self) {
            $value = $value->toFloat();
        }

        $result = $this->money->plus($value);

        return self::create($result->getAmount()->toFloat());
    }

    public function toFloat(): float
    {
        return $this->money->getAmount()->toFloat();
    }

    public function toInt(): int
    {
        return $this->money->getAmount()->toInt();
    }

    public function toString(): string
    {
        return $this->money->__toString();
    }
}
