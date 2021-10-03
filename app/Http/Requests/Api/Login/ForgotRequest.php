<?php

namespace App\Http\Requests\Api\Login;

use App\Http\Requests\Api\ApiRequest;

class ForgotRequest extends ApiRequest
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
            'email' => 'required|email',
        ];
    }
    
    public function attributes(): array
    {
        return [
           //
        ];
    }
}
