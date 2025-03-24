<?php

namespace App\Http\Controllers;

use App\Casts\Money;
use App\Data\PropertyInvestmentCampaignsFilter;
use App\Exceptions\InvalidInvestmentAmountException;
use App\Http\Requests\StorePropertyInvestmentRequest;
use App\Http\Resources\PropertyInvestmentCampaignResource;
use App\Http\Resources\PropertyInvestmentResource;
use App\Models\Property;
use App\Models\PropertyInvestmentCampaign;
use App\Services\PropertyInvestment\PropertyInvestmentService;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PropertyInvestmentCampaignController extends Controller
{
    public function index(PropertyInvestmentCampaignsFilter $filters, int $propertyId): AnonymousResourceCollection
    {
        $campaigns = PropertyInvestmentCampaign::query()
            ->wherePropertyId($propertyId)
            ->filter($filters)
            ->with([
                'property' => ['location'],
            ])
            ->paginate(50);

        return PropertyInvestmentCampaignResource::collection($campaigns);
    }

    public function store(
        StorePropertyInvestmentRequest $request,
        Property $property,
        PropertyInvestmentCampaign $propertyInvestmentCampaign,
    ): PropertyInvestmentResource {
        if ($property->id !== $propertyInvestmentCampaign->property_id) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $amount = Money::create($request->amount);

        try {
            $propertyInvestment = PropertyInvestmentService::resolve()->invest($propertyInvestmentCampaign, $amount);
        } catch (InvalidInvestmentAmountException $e) {
            throw ValidationException::withMessages(['amount' => $e->getMessage()]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $propertyInvestment->load(['campaign' => ['property']]);

        return PropertyInvestmentResource::make($propertyInvestment);
    }
}
