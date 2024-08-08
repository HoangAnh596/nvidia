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
        // dd($params); // "image_ids" => "["31"]"
        $productId = $params['id'] ?? null;
        $imageIds = json_decode($params['image_ids'] ?? '[]', true);
        // Kiểm tra nếu sản phẩm có id
        if (!empty($productId)) {
            $checkNameUpdate = DB::table('products')
                ->where('name', '=', $params['name'])
                ->where('id', '=', $productId)
                ->exists();
            
            if ($checkNameUpdate) {
                $ruleUpdateName = "required";
            }
            // Kiểm tra nếu sản phẩm đã có ảnh trong bảng ProductImages
            $hasImages = DB::table('product_images')
                ->where('id', '=', $imageIds) //
                ->exists();

            // Nếu sản phẩm đã có ảnh, không bắt buộc trường image
            $imageRules = $hasImages ? 'sometimes|array' : 'required|array';
            $imageItemRules = $hasImages ? 'sometimes|string' : 'required|string';
        } else {
            // Nếu là thêm mới sản phẩm, trường image là bắt buộc
            $imageRules = 'required|array';
            $imageItemRules = 'required|string';
        }

        return [
            'name' => isset($ruleUpdateName) ? $ruleUpdateName : 'required|unique:products',
            'content' => 'required',
            'category' => 'required',
            'code' => [
                'required',
                'regex:/^(?!-)(?!.*--)[A-Za-z0-9-]+(?<!-)$/',
                Rule::unique('products')->ignore($productId)
            ],
            'image' => $imageRules,
            'image.*' => $imageItemRules,
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
            'code.regex' => 'Mã sản phẩm chỉ được chứa chữ cái, số và dấu gạch ngang.',
            'code.unique' => 'Mã sản phẩm không được trùng.',
            'category.required' => 'Danh mục sản phẩm không được để trống',
            'content.required' => 'Mô tả không được để trống',
            'image.required' => 'Ảnh không được để trống',
        ];
    }
}
