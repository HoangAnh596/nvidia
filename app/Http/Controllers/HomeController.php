<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\CateMenu;
use App\Models\Infor;
use App\Models\News;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
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
                })->take(10)->orderBy('created_at', 'DESC')->get();
            }
            //Lấy ra id categories thứ 2
            if(isset($idCate2)) {
                $cate2 = Category::find($idCate2);
                $allCategory2 = array_merge([$idCate2], $cate2->getAllChildrenIds());
                $filteredCategory2 = array_intersect($allCategory2, $categoryIds);
                $pr2 = Product::whereHas('category', function ($query) use ($allCategory2) {
                    $query->whereIn('category_id', $allCategory2);
                })->take(10)->orderBy('created_at', 'DESC')->get();
    
            }
            //Lấy ra id categories thứ 3
            if(isset($idCate3)) {
                $cate3 = Category::find($idCate3);
                $allCategory3 = array_merge([$idCate3], $cate3->getAllChildrenIds());
                $filteredCategory3 = array_intersect($allCategory3, $categoryIds);
                $pr3 = Product::whereHas('category', function ($query) use ($allCategory3) {
                    $query->whereIn('category_id', $allCategory3);
                })->take(10)->orderBy('created_at', 'DESC')->get();
    
            }
            $pr1 = $pr1 ?? collect();
            $pr2 = $pr2 ?? collect();
            $pr3 = $pr3 ?? collect();

            // Tin tức
            $blogs = News::where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(4)->get();
            return view('cntt.home.index', compact('categories', 'blogs', 'cate1', 'pr1', 'cate2', 'pr2', 'cate3', 'pr3'));
        }
    }
    
    public function category(Request $request, $slug)
    {
        $cateMenu = Category::all();
        $cateMenu = $this->buildTree($cateMenu);
        
        $phoneInfors = Infor::where('is_public', 1)->orderBy('stt', 'ASC')->get();
        $category = Category::where('slug', $slug)->first();
        if (!empty($category)) {
            $categoryParentFind = Category::where('slug', $slug)
                ->with('children')
                ->first();
            // Lấy ra id của parent_id = 0 
            $parentId = Category::findOrFail($categoryParentFind->id)->topLevelParent()->id;
            $cateParent = Category::findOrFail($parentId);
            $filterCate = $cateParent->getFilterCates();
            
            $categoryIds = $category->getAllChildrenIds();
            array_unshift($categoryIds, $category->id); // Thêm ID danh mục chính vào danh sách

            $prOutstand = Product::where('is_outstand', 1)
                ->whereHas('category', function ($query) use ($categoryIds) {
                    $query->whereIn('category_id', $categoryIds);
                })->orderBy('created_at', 'DESC')
                ->take(10)->get();
            // Bộ lọc sản phẩm

            $products = Product::whereHas('category', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })->orderBy('created_at', 'DESC')->paginate(10);
            // Tính toán số lượng trang hiện có
            $currentPage = $request->input('page', 1);
            $lastPage = $products->lastPage();

            // Nếu trang yêu cầu vượt quá số trang hiện có, chuyển hướng đến trang cuối cùng
            if ($currentPage > $lastPage) {
                $products = Product::whereHas('category', function ($query) use ($categoryIds) {
                    $query->whereIn('category_id', $categoryIds);
                })->orderBy('created_at', 'DESC')
                ->paginate(10, ['*'], 'page', $lastPage);
            }

            return view('cntt.home.category', compact('phoneInfors', 'cateParent', 'category', 'categoryParentFind', 'products', 'prOutstand', 'filterCate'));
        }

        $idPro = Product::where('slug', $slug)->value('id');
        $product = Product::with('category')->findOrFail($idPro);
        $relatedProducts = $product->getRelatedProducts();
        $images = $product->getProductImages();
        $product->load('category.parent.parent.parent');
        // $category = Category::where('id', $id)->with('children')->first();
        $allCategories = collect();

        foreach ($product->category as $category) {
            $currentCategory = $category;
            while ($currentCategory) {
                $allCategories->push($currentCategory);
                $currentCategory = $currentCategory->parent;
            }
        }

        // Loại bỏ các danh mục trùng lặp
        $uniqueCategories = $allCategories->unique('id')->sortBy('id');

        return view('cntt.home.show', compact('phoneInfors', 'product', 'images', 'relatedProducts', 'uniqueCategories'));
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
