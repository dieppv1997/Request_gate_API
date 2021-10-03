<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;

class StoreRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|max:191|unique:users,email',
            'role_id' => 'required|integer',
            'department_id' => 'required|integer',
            'status' => 'required|string|in:active,inactive'
        ];
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }
}
