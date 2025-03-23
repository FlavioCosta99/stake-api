<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyInvestmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'regex:/^\d{1,15}(\.\d{2})?$/',
            ],
        ];
    }
}
