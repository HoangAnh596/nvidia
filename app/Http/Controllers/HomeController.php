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
        $categories = Category::all();
        // Lấy tất cả các danh mục có parent_id = 0
        $rootCategories = Category::where('parent_id', 0)->get();

        // Lấy tất cả các id của danh mục root và danh mục con của chúng
        $categoryIds  = [];
        foreach ($rootCategories as $category) {
            $categoryIds  = array_merge($categoryIds, [$category->id]);
        }

        $idCategory = 1;  // id = switch
        // Lấy danh mục gốc
        $category = Category::find($idCategory);
        // Nếu danh mục không tồn tại, trả về một thông báo lỗi
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        // Lấy tất cả các id danh mục con bao gồm cả id gốc
        $allCategoryIds = array_merge([$idCategory], $category->getAllChildrenIds());
        // Lọc danh sách id dựa trên mảng $categoryIds
        $filteredCategoryIds = array_intersect($allCategoryIds, $categoryIds);
        // Lấy tất cả sản phẩm thuộc các danh mục đó
        $products = Product::whereHas('category', function ($query) use ($allCategoryIds) {
            $query->whereIn('category_id', $allCategoryIds);
        })->orderBy('created_at', 'DESC')->get();

        $idWifi = 2;  // id = wifi
        $cate = Category::find($idWifi);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        $allCateIds = array_merge([$idWifi], $cate->getAllChildrenIds());
        $filCategoryIds = array_intersect($allCateIds, $categoryIds);
        $proWifi = Product::whereHas('category', function ($query) use ($allCateIds) {
            $query->whereIn('category_id', $allCateIds);
        })->get();

        return view('cntt.home.index', compact('categories', 'products', 'proWifi'));
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
