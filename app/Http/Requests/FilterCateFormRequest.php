<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FilterCateFormRequest extends FormRequest
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
            $checkNameUpdate = DB::table('filter_cate')->select('id')
            ->where('name', '=', $params['name'])
            ->where('id', '=', $params['id'])
            ->value('id');
        }
        if (!empty($params['id']) && ($params['id'] == $checkNameUpdate)) {
            $ruleUpdateName = "required";
        }

        return [
            'name' => (isset($ruleUpdateName)) ? $ruleUpdateName : 'required | unique:filter_cate',
            'cate_id' => 'required',
            'stt_filter' => (!empty($params['stt_filter'])) ? 'integer|min:0' : ''
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên bộ lọc không được bỏ trống.',
            'name.unique' => 'Tên bộ lọc không được trùng.',
            'cate_id.required' => 'Danh mục sản phẩm không được bỏ trống.',
            'stt_filter.integer' => 'Số thứ tự phải là số nguyên.',
            'stt_filter.min' => 'Số thứ tự phải lớn 0',
        ];
    }
}