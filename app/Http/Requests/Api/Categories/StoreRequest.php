<?php

namespace App\Http\Requests\Api\Categories;

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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191|unique:categories,name',
            'status' => 'required|string|in:enable,disable',
            'user_id' => 'required|integer',
        ];
    }
}
