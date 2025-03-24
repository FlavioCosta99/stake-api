<?php

namespace App\Services\PropertyInvestment;

use App\Casts\Money;
use App\Data\CreatePropertyInvestmentData;
use App\Models\PropertyInvestment;
use App\Models\PropertyInvestmentCampaign;
use App\Repositories\PropertyInvestmentRepository;
use App\Traits\Resolvable;
use Exception;
use Illuminate\Support\Facades\Cache;

class PropertyInvestmentService
{
    use Resolvable;

    /**
     * @throws Exception
     */
    public function invest(PropertyInvestmentCampaign $propertyInvestmentCampaign, Money $amount): PropertyInvestment
    {
        $lock = Cache::lock("property_investment_campaign_{$propertyInvestmentCampaign->id}", 10);

        try {
            if ($lock->get()) {
                $investmentData = CreatePropertyInvestmentData::validateAndCreate([
                    'campaign' => $propertyInvestmentCampaign,
                    'amount' => $amount,
                ]);

                $propertyInvestment = PropertyInvestmentRepository::resolve()->create($investmentData);
            } else {
                throw new Exception('Try again later');
            }
        } finally {
            $lock->release();
        }

        return $propertyInvestment;
    }
}
