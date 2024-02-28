<?php

namespace Modules\Search\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'needle' => 'required|string',
        ];
    }
}