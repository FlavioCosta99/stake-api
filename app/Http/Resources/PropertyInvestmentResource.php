<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyInvestmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'campaign' => PropertyInvestmentCampaignResource::make($this->whenLoaded('campaign')),
            'property' => PropertyResource::make($this->whenLoaded('property')),
            'amount' => $this->shares_total_value->toFloat(),
            'percentage' => $this->percentage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
