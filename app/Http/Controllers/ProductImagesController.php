<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImagesController extends Controller
{
    public function destroy($id)
    {
        $image = ProductImages::findOrFail($id);
        $product_id = $image->product_id;
        // Xóa ảnh nếu cần thiết (ví dụ xóa file trên server)
        Storage::delete($image->image);

        $image->delete();
        // Tìm sản phẩm liên quan
        $product = Product::findOrFail($product_id);
        // dd($product);
        
        // Cập nhật mảng images_id trong bảng products
        $imagesIds = json_decode($product->image_ids, true);
        if (($key = array_search($id, $imagesIds)) !== false) {
            unset($imagesIds[$key]);
        }

        $product->image_ids = json_encode(array_values($imagesIds));
        $product->save();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    public function checkStt(Request $request){
        $sttImg = $request->input('stt_img');
        if (!empty($sttImg)) {
            $request->validate([
                'stt_img' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = ProductImages::findOrFail($id);
        $category->stt_img = (isset($sttImg)) ? $sttImg : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'STT updated successfully.']);
    }
}
