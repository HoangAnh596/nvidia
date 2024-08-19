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
        } else {
            $ruleUpdateName = "required | unique:categories";
        }

        // Kiểm tra tính duy nhất của slug trong cả hai bảng
        $uniqueSlugRule = function ($attribute, $value, $fail) use ($params) {
            $slugExistsInCategory = DB::table('categories')
                ->where('slug', $value)
                ->where('id', '!=', $params['id'] ?? 0)
                ->exists();

            $slugExistsInProducts = DB::table('products')
                ->where('slug', $value)
                ->exists();

            if ($slugExistsInCategory || $slugExistsInProducts) {
                $fail('Danh mục không được trùng.');
            }
        };

        // Đặt điều kiện cho slug
        $slugRule = !empty($params['id'])
            ? ['in:' . DB::table('categories')->where('id', $params['id'])->value('slug'), $uniqueSlugRule]
            : ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $uniqueSlugRule];

        return [
            'name' => $ruleUpdateName,
            'content' => 'required',
            'filepath' => 'required',
            'stt_cate' => (!empty($params['stt_cate'])) ? 'integer|min:0' : '',
            'slug' => $slugRule,
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
            'slug.required' => 'Url không được bỏ trống.',
            'slug.unique' => 'Url không được trùng.',
            'slug.regex' => 'Url chỉ được phép chứa chữ cái thường, số và dấu gạch ngang.',
            'slug.in' => 'Không được thay đổi slug',
        ];
    }
}
