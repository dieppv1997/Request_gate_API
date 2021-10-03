<?php

namespace App\Http\Requests\Api\Requests;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Support\Facades\Config;

class UpdateRequest extends ApiRequest
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
        $todayDate = date('Y-m-d H:i:s');
        return [
            'category_id' => 'required',
            'content' => 'required',
            'due_date' =>'required|'.Config::get('date'.'due_date').'|after_or_equal:'.$todayDate,
            'admin_id' => 'required',
            'title' => 'required|max:191',
            'status_admin' => 'required',
            'priority' => 'required',
            'status_manager' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
           //
        ];
    }
}
