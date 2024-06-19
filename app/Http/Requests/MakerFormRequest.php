<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakerFormRequest extends FormRequest
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
            'name' => 'required',
            'code' => [
                'required',
                'regex:/[A-Z0-9]$/',
                Rule::unique('makers')->ignore($this->maker)
            ],
            'image' => [
                "mimes:jpg,bmp,png,gif",
                'max:1000'
            ]
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name không được để trống',
            'code.required' => 'Code không được để trống',
            'code.regex' => 'Mã code không hợp lệ',
            'image.mimes' => 'image phải thuộc jpg,bmp,png,gif',
        ];
    }
}
