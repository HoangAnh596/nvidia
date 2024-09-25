<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->pro_id;
        $product = Product::findOrFail($id);
        $imgProduct = $product->getMainImage();
        
        $selectedCateIds = $product->category->pluck('id')->toArray();

        $groupSelected = [];
        if (!empty($product->group_ids)) {
            // Chuyển đổi JSON thành mảng
            $groupIds = json_decode($product->group_ids, true);
            // Lấy các bản ghi từ bảng Group có id nằm trong groupIds
            $groupSelected = Group::select('id', 'name', 'parent_id', 'cate_id')
                ->whereIn('id', $groupIds)->get();
        }
        // Nhóm sản phẩm
        $allGroups = Group::with('products')
            ->select('id', 'name', 'parent_id', 'cate_id')
            ->where(function ($query) use ($selectedCateIds, $product) {
                $query->whereIn('cate_id', $selectedCateIds)
                    ->orWhere(function ($query) use ($product) {
                        $query->where('cate_id', 0)
                            ->where('parent_id', $product->id);
                    });
            })
        ->get();
        
        // Truy vấn groupProduct với điều kiện cate_id = 0 và parent_id là id của sản phẩm
        $groupProducts = Group::with('products')
            ->select('id', 'name', 'parent_id', 'cate_id')
            ->where('cate_id', 0)
            ->where('parent_id', $product->id)
            ->get();
        // dd($groupProducts);
        $allProducts = Product::all();

        return view('admin.groupPro.add', compact(
            'product', 'imgProduct', 'allGroups',
            'selectedCateIds', 'allProducts',
            'groupSelected', 'groupProducts'
        ));
    }
}
