<?php

namespace App\Console\Commands;

use App\Casts\Money;
use App\Jobs\CreateDividendsForProperty;
use App\Jobs\DistributeDividendsToInvestors;
use App\Models\Property;
use Illuminate\Console\Command;

class DistributeDividendCommand extends Command
{
    protected $signature = 'investments:distribute-dividend {property_id} {amount}';

    protected $description = 'Distributes dividends pro-rata to investors in a property campaign';

    public function handle()
    {
        $propertyId = (int) $this->argument('property_id');
        $amount = (float) $this->argument('amount');

        if ($propertyId === 0) {
            $this->error('Property ID is invalid');

            return;
        }

        if ($amount <= 0) {
            $this->error('Amount must be positive.');

            return;
        }

        $property = Property::query()->findOrFail($propertyId);
        $amount = Money::create($amount);

        CreateDividendsForProperty::dispatchSync($property, $amount);
        DistributeDividendsToInvestors::dispatchSync($property);
    }
}
