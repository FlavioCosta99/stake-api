<?php

namespace App\Jobs;

use App\Casts\Money;
use App\Data\CreateDividendDistributionData;
use App\Models\Property;
use App\Repositories\DividendDistributionsRepository;
use App\Repositories\PropertyInvestmentRepository;
use Brick\Math\RoundingMode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CreateDividendsForProperty implements ShouldQueue
{
    use Queueable;

    public function __construct(private Property $property, private Money $amount) {}

    public function handle(): void
    {
        $investors = PropertyInvestmentRepository::resolve()
            ->filterApprovedInvestorsForProperty($this->property);

        $dividendPerShare = $this->getDividendPerShare();

        $dividendDistributionsRepository = DividendDistributionsRepository::resolve();

        foreach ($investors->cursor() as $investor) {

            $investorDividend = $dividendPerShare->multipliedBy(
                value: $investor->shares,
                roundingMode: RoundingMode::DOWN,
                precision: 10
            );

            $dividendDistributionsRepository->create(
                CreateDividendDistributionData::validateAndCreate([
                    'propertyInvestment' => $investor,
                    'amount' => $investorDividend,
                ]),
            );

            Log::info("Created dividend for property investment {$investor->id} with a value of {$investorDividend->toString()}");
        }
    }

    private function getDividendPerShare(): Money
    {
        return Money::create(
            amount: $this->amount->toFloat(),
            precision: 10,
            roundingMode: RoundingMode::DOWN
        )->dividedBy(
            value: $this->property->total_number_of_investor_shares,
            roundingMode: RoundingMode::DOWN,
            precision: 10,
        );
    }
}
