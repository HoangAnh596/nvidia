<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class ContentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'uploadImg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('uploadImg')) {
            // Lấy URL hiện tại từ request
            $current_url = $request->input('current_url');
            $imageName = uniqid() . '-' . $request->uploadImg->getClientOriginalName();

            if (strpos($current_url, 'categories') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/danh-muc', $imageName);
            } elseif (strpos($current_url, 'products') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/san-pham', $imageName);
                // Đường dẫn tuyệt đối đến ảnh gốc
                $originalAbsolutePath = storage_path('app/' . $originalPath);
                // Đường dẫn tuyệt đối đến thư mục lưu ảnh nhỏ
                $smallPath = public_path('storage/images/san-pham/small/');
                $mediumPath = public_path('storage/images/san-pham/medium/');
                // Kiểm tra xem tệp ảnh gốc đã tồn tại chưa
                if (file_exists($originalAbsolutePath)) {
                    // Tạo ảnh nhỏ
                    $smallImage = Image::make($originalAbsolutePath)->resize(150, 150)->sharpen(10);; // Tạo ảnh nhỏ
                    $mediumImage = Image::make($originalAbsolutePath)->resize(300, 300)->sharpen(10);; // Tạo ảnh trung bình
                    
                    // dd($smallPath);
                    // Kiểm tra và tạo thư mục nếu chưa tồn tại
                    if (!file_exists($smallPath)) {
                        mkdir($smallPath, 0755, true);
                    }
                    if (!file_exists($mediumPath)) {
                        mkdir($mediumPath, 0755, true);
                    }

                    $smallImage->save($smallPath . $imageName, 100); // Lưu ảnh nhỏ
                    $mediumImage->save($mediumPath . $imageName, 100); // Lưu ảnh trung bình
                }
            } elseif (strpos($current_url, 'cateNews') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/danh-muc-tin-tuc', $imageName);
            } elseif (strpos($current_url, 'news') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/tin-tuc', $imageName);
            } elseif (strpos($current_url, 'cateMenu') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/menu', $imageName);
            } elseif (strpos($current_url, 'favicon') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/favicon', $imageName);
            }
            $newPath = str_replace('public', 'storage', $originalPath);

            return response()->json([
                'success' => 'Cập nhật hình ảnh thành công!',
                'image_name' => $newPath
            ]);
        }

        if ($request->hasFile('pr_image_ids')) {
            // Lấy URL hiện tại từ request
            $current_url = $request->input('current_url');
            $imageName = uniqid() . '-' . $request->pr_image_ids->getClientOriginalName();

            $originalPath = $request->pr_image_ids->storeAs('public/images/san-pham/anh-chi-tiet', $imageName);
            
            $newPath = str_replace('public', 'storage', $originalPath);

            return response()->json([
                'success' => 'Tải ảnh thành công!',
                'image_name' => $newPath
            ]);
        }

        return response()->json(['error' => 'Tải ảnh lên bị lỗi!'], 500);
    }

    public function checkSlug(Request $request)
    {
        $slug = $request->input('slug');
        
        $categoryCount = DB::table('categories')->where('slug', $slug)->count();
        $productCount = DB::table('products')->where('slug', $slug)->count();

        if ($categoryCount > 0 || $productCount > 0) {
            return response()->json(['exists' => true], 200);
        }

        return response()->json(['exists' => false], 200);
    }
}
