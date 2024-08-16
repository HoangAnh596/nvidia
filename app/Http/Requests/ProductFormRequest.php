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
        $productId = $params['id'] ?? null;
        $imageIds = json_decode($params['image_ids'] ?? '[]', true);
        // Đảm bảo $imageIds là một mảng, nếu không chuyển nó thành một mảng rỗng
        if (!is_array($imageIds)) {
            $imageIds = [];
        }
        // Kiểm tra nếu sản phẩm có id
        if (!empty($params['id'])) {
            $checkNameUpdate = DB::table('products')
                ->where('name', '=', $params['name'])
                ->where('id', '=', $params['id'])
                ->exists();

            if ($checkNameUpdate) {
                $ruleUpdateName = "required";
            }

            // Chỉ tiếp tục nếu $imageIds không rỗng
            if (!empty($imageIds)) {
                // Sử dụng whereIn để kiểm tra nếu bất kỳ id nào tồn tại trong bảng product_images
                $hasImages = DB::table('product_images')
                    ->whereIn('id', $imageIds) // Sử dụng whereIn để kiểm tra danh sách ID
                    ->exists();

                // Đặt quy tắc xác thực dựa trên kết quả kiểm tra
                $imageRules = $hasImages ? 'sometimes|array' : 'required|array';
                $imageItemRules = $hasImages ? 'sometimes|string' : 'required|string';
            } else {
                // Nếu $imageIds rỗng, không có hình ảnh nào hợp lệ để kiểm tra
                $imageRules = 'required|array';
                $imageItemRules = 'required|string';
            }
        } 
        else {
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
            'filepath' => $imageRules,
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
            'filepath.required' => 'Ảnh không được để trống',
        ];
    }
}
