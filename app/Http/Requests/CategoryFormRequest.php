<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryFormRequest extends FormRequest
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
        $params = $this->request->all();

        if (!empty($params['id'])) {
            $checkNameUpdate = DB::table('categories')->select('id')
            ->where('name', '=', $params['name'])
            ->where('id', '=', $params['id'])
            ->value('id');
        }
        if (!empty($params['id']) && ($params['id'] == $checkNameUpdate)) {
            $ruleUpdateName = "required";
        }

        return [
            'name' => (isset($ruleUpdateName)) ? $ruleUpdateName : 'required | unique:categories',
            'content'=>'required',
            'filepath'=>'required',
            'stt_cate' => (!empty($params['stt_cate'])) ? 'integer|min:0' : ''
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'name.unique' => 'Tên danh mục không được trùng.',
            'content.required' => 'Mô tả không được để trống',
            'filepath.required' => 'Ảnh không được để trống',
            'stt_cate.integer' => 'Số thứ tự phải là số nguyên.',
            'stt_cate.min' => 'Số thứ tự phải lớn 0',
        ];
    }
}