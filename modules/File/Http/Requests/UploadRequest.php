<?php

namespace Modules\File\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'files' => ['required'],
            'id' => ['required', 'integer'],
            'model' => ['required', 'string', Rule::in(['Article','Product'])],
        ];
    }
}
