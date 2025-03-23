<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyInvestmentCampaignResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'percentage_raised' => $this->percentage_raised,
            'target_amount' => $this->target_amount->toFloat(),
            'number_of_investors' => $this->number_of_investors,
            'investment_multiple' => $this->value_per_share->toFloat(),
            'property' => PropertyResource::make($this->whenLoaded('property')),
        ];
    }
}
