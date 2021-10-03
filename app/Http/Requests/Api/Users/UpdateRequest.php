<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Http\Request;

class UpdateRequest extends ApiRequest
{
    protected $id;
    public function __construct(Request $request)
    {
        $this->id = $request->id;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|max:191|unique:users,email,'.$this->id,
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
