<?php

namespace App\Http\Requests\Api\Departments;

use App\Http\Requests\Api\ApiRequest;

class StoreRequest extends ApiRequest
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
            'name' => 'required|max:191|unique:departments,name'
        ];
    }

    public function attributes(): array
    {
        return [
            //
        ];
    }
}
