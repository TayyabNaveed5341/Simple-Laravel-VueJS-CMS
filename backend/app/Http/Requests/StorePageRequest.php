<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            //
            'parent_id'=>['nullable', 'integer', 'exists:pages,id'],
            'title'=>['required', 'string', 'max:200'],
            'slug'=>['required', 'string', 'regex:/[a-z_]/', 'max:200', 'unique:pages'],
            'content'=>['required', 'string'],
        ];
    }
}
