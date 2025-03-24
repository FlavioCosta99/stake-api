<?php

namespace App\Jobs;

use App\Models\Property;
use App\Repositories\DividendDistributionsRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class DistributeDividendsToInvestors implements ShouldQueue
{
    use Queueable;

    public function __construct(private Property $property) {}

    public function handle(): void
    {
        $dividendRepository = DividendDistributionsRepository::resolve();

        $distributions = $dividendRepository->filterForPendingDistributionsForProperty($this->property);

        foreach ($distributions->cursor() as $distribution) {
            Log::info("Dividend of {$distribution->amount->toString()} distributed to property investment {$distribution->id}.");
            $dividendRepository->markAsFinished($distribution);
        }
    }
}
