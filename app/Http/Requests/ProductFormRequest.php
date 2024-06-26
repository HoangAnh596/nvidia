<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProductFormRequest extends FormRequest
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
            $checkNameUpdate = DB::table('products')->select('id')
            ->where('name', '=', $params['name'])
            ->where('id', '=', $params['id'])
            ->value('id');
        }
        if (!empty($params['id']) && ($params['id'] == $checkNameUpdate)) {
            $ruleUpdateName = "required";
        }

        return [
            'name' => (isset($ruleUpdateName)) ? $ruleUpdateName : 'required | unique:products',
            'content'=>'required',
            'category' => 'required',
            'code' => 'required',
        ];
    }
    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được bỏ trống.',
            'name.unique' => 'Tên sản phẩm không được trùng.',
            'code.required' => 'Mã sản phẩm không được để trống',
            'category.required' => 'Danh mục sản phẩm không được để trống',
            'content.required' => 'Mô tả không được để trống',
        ];
    }
}
