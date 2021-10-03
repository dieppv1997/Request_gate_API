<?php

namespace App\Http\Requests\Api\Requests;

use App\Http\Requests\Api\ApiRequest;

class IndexRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function attributes(): array
    {
        return [
           //
        ];
    }
}
