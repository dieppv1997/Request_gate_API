<?php

namespace App\Http\Requests\Api\Departments;

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
            'name' => 'required|max:191|unique:departments,name,'.$this->id
        ];
    }

    public function attributes(): array
    {
        return [
            //
        ];
    }
}
