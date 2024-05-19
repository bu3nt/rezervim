<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'orderId' => ['required', 'integer'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'integer'],
            'products.*.name' => ['required', 'string'],
        ];
    }
}
