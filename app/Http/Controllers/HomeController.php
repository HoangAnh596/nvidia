<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\CateMenu;
use App\Models\News;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        // Trang chủ ngoài
        $categories = Category::where('parent_id', 0)
        ->with('children')
        ->where('is_public', 1)
        ->orderBy('stt_cate', 'ASC')->take(5)
        ->get();

        // Lấy tất cả các danh mục có parent_id = 0
        $rootCategories = Category::where('parent_id', 0)->get();

        // Lấy tất cả các id của danh mục root và danh mục con của chúng
        $categoryIds  = [];
        foreach ($rootCategories as $category) {
            $categoryIds  = array_merge($categoryIds, [$category->id]);
        }
        // Lấy tất cả các danh mục có parent_id = 0
        $ids = Category::where('is_outstand', 1)->where('parent_id', 0)->pluck('id');
        if($ids->isEmpty()) {

            return view('cntt.home.index', compact('categories'));
        } else {
            foreach ($ids as $index => $value) {
                ${'idCate' . ($index + 1)} = $value;
            }
            $cate1 = $cate2 = $cate3 = null;
            // Lấy ra id categories đầu tiên 
            if (isset($idCate1)) {
                $cate1 = Category::find($idCate1);
                // Lấy tất cả các id danh mục con bao gồm cả id gốc
                $allCategoryIds = array_merge([$idCate1], $cate1->getAllChildrenIds());
                // Lọc danh sách id dựa trên mảng $categoryIds
                $filteredCategoryIds = array_intersect($allCategoryIds, $categoryIds);
                // Lấy tất cả sản phẩm thuộc các danh mục đó
                $pr1 = Product::whereHas('category', function ($query) use ($allCategoryIds) {
                    $query->whereIn('category_id', $allCategoryIds);
                })->take(8)->orderBy('created_at', 'DESC')->get();
            }
            //Lấy ra id categories thứ 2
            if(isset($idCate2)) {
                $cate2 = Category::find($idCate2);
                $allCategory2 = array_merge([$idCate2], $cate2->getAllChildrenIds());
                $filteredCategory2 = array_intersect($allCategory2, $categoryIds);
                $pr2 = Product::whereHas('category', function ($query) use ($allCategory2) {
                    $query->whereIn('category_id', $allCategory2);
                })->take(8)->orderBy('created_at', 'DESC')->get();
    
            }
            //Lấy ra id categories thứ 3
            if(isset($idCate3)) {
                $cate3 = Category::find($idCate3);
                $allCategory3 = array_merge([$idCate3], $cate3->getAllChildrenIds());
                $filteredCategory3 = array_intersect($allCategory3, $categoryIds);
                $pr3 = Product::whereHas('category', function ($query) use ($allCategory3) {
                    $query->whereIn('category_id', $allCategory3);
                })->take(8)->orderBy('created_at', 'DESC')->get();
    
            }
            $pr1 = $pr1 ?? collect();
            $pr2 = $pr2 ?? collect();
            $pr3 = $pr3 ?? collect();

            // Tin tức
            $blogs = News::where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(4)->get();
            return view('cntt.home.index', compact('categories', 'blogs', 'cate1', 'pr1', 'cate2', 'pr2', 'cate3', 'pr3'));
        }
    }
    
    public function category($slug)
    {
        $cateMenu = Category::all();
        $cateMenu = $this->buildTree($cateMenu);

        $category = Category::where('slug', $slug)->first();
        if (!empty($category)) {
            $categoryParentFind = Category::where('slug', $slug)
                ->with('children')
                ->first();

            $categoryIds = $category->getAllChildrenIds();
            array_unshift($categoryIds, $category->id); // Thêm ID danh mục chính vào danh sách

            $products = Product::whereHas('category', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })->get();

            return view('cntt.home.category', compact('cateMenu', 'category', 'categoryParentFind', 'products'));
        }

        $idPro = Product::where('slug', $slug)->value('id');
        $product = Product::with('category')->findOrFail($idPro);
        $images = Product::findOrFail($idPro)->getProductImages();
        $cateMenu = Category::all();
        $cateMenu = $this->buildTree($cateMenu);

        $pro = Product::findOrFail($idPro);

        if (!empty($pro->related_pro)) {
            $relatedProducts = $pro->getRelatedProducts();

            return view('cntt.home.show', compact('cateMenu', 'product', 'images', 'relatedProducts'));
        }

        return view('cntt.home.show', compact('cateMenu', 'product', 'images'));
    }

    private function buildTree($cateMenu, $parentId = 0)
    {
        $branch = [];

        foreach ($cateMenu as $category) {
            if ($category->parent_id == $parentId) {
                $children = $this->buildTree($cateMenu, $category->id);
                if ($children) {
                    $category->children = $children;
                }
                $branch[] = $category;
            }
        }

        return $branch;
    }
}
