<?php

namespace App\Http\Requests\Api\Categories;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191|unique:categories,name,'.$this->id,
            'status' => 'required|string|in:enable,disable',
            'user_id' => 'required|integer',
        ];
    }
}
