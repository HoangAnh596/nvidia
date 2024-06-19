<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewFormRequest extends FormRequest
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
        $formRules = [
            'title' => [
                'required',
                'max:255'
            ],
            'content'=>'required',
            'file_upload' => [
                "mimes:jpg,bmp,png,gif",
                'max:1000'
            ]
        ];
        
        if($this->id == null){
            $formRules['file_upload'][] = "required";
        }
        return $formRules;
    }
    // validate
    public function messages()
    {
        return [
            'title.required' => 'title không được để trống',
            'title.max' => 'title không được quá 255 ký tự',
            'content.required' => 'content không được để trống',
            'file_upload.required' => 'file_upload không được để trống',
            'file_upload.mimes' => 'file_upload phải thuộc jpg,bmp,png,gif',
            'file_upload.max' => 'file_upload không được quá 2MB',
        ];
    }
}