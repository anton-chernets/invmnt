<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'products' => 'required|array',
            'products.*.id' => [
                'required',
                'exists:products,id',
            ],
            'products.*.quantity' => [
                'required',
                'integer',
            ],
        ];
    }
}