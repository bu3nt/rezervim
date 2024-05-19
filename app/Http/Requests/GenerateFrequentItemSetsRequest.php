<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateFrequentItemSetsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'support' => ['required', 'integer'],
            'confidence' => ['required', 'integer'],
        ];
    }
}
