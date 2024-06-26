<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                $originalPath = $request->uploadImg->storeAs('public/images/9/danh-muc', $imageName);
            } elseif (strpos($current_url, 'products') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/9/san-pham', $imageName);
            } elseif (strpos($current_url, 'cateNews') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/9/danh-muc-tin-tuc', $imageName);
            } elseif (strpos($current_url, 'news') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/9/tin-tuc', $imageName);
            } elseif (strpos($current_url, 'cateMenu') !== false) {
                $originalPath = $request->uploadImg->storeAs('public/images/9/menu', $imageName);
            }
            $newPath = str_replace('public', 'storage', $originalPath);

            return response()->json([
                'success' => 'Image uploaded successfully!',
                'image_name' => $newPath
            ]);
        }

        if ($request->hasFile('pr_image_ids')) {
            // Lấy URL hiện tại từ request
            $current_url = $request->input('current_url');
            $imageName = uniqid() . '-' . $request->pr_image_ids->getClientOriginalName();

            $originalPath = $request->pr_image_ids->storeAs('public/images/9/san-pham/anh-chi-tiet', $imageName);
            
            $newPath = str_replace('public', 'storage', $originalPath);

            return response()->json([
                'success' => 'Image uploaded successfully!',
                'image_name' => $newPath
            ]);
        }

        return response()->json(['error' => 'Image upload failed!'], 500);
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
