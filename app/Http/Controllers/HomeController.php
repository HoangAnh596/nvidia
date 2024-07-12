<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Infor;
use App\Models\News;
use App\Models\Product;
use App\Services\CategorySrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const TEXT_SEO = "CNTT Shop";
    protected $categorySrc;

    public function __construct(CategorySrc $categorySrc)
    {
        $this->categorySrc = $categorySrc;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        // Seo Website
        $titleSeo = config('common.title_seo');
        $keywordSeo = config('common.keyword_seo');
        $descriptionSeo = config('common.des_seo');

        // Trang chủ ngoài
        // Lấy tất cả các danh mục có parent_id = 0
        $categories = Category::where('is_public', 1)
            ->select('id', 'name', 'slug', 'image', 'title_img', 'alt_img', 'is_serve')
            ->orderBy('stt_cate', 'ASC')
            ->get();

        // Lấy danh mục có is_serve = 1 có stt_cate từ nhỏ tới lớn 
        $cate = $categories->where('is_serve', 1)->load('children');
        $ids = $cate->pluck('id');
        // Tin tức
        $blogs = News::where('is_outstand', 1)->select('id', 'name', 'image', 'slug', 'alt_img', 'title_img')
            ->orderBy('created_at', 'DESC')->get();
        if ($ids->isEmpty()) {

            return view('cntt.home.index', compact('titleSeo', 'keywordSeo', 'descriptionSeo', 'categories', 'blogs'));
        } else {
            $categoriesWithProducts = collect();
            foreach ($ids as $idCate) {
                $category = Category::find($idCate);
                
                if ($category) {
                    // Lấy tất cả các id danh mục con bao gồm cả id gốc
                    $allCategoryIds = array_merge([$idCate], $category->getAllChildrenIds());
            
                    // Lấy tất cả sản phẩm thuộc các danh mục đó
                    $products = Product::whereHas('category', function ($query) use ($allCategoryIds) {
                        $query->whereIn('category_id', $allCategoryIds);
                    })->select('name', 'slug', 'image', 'alt_img', 'title_img', 'price')
                        ->where('is_outstand', 1)
                        ->orderBy('created_at', 'DESC')->get();

                    // tách sản phẩm nào thì thuộc danh mục sản phẩm đó
                    $categoriesWithProducts->push([
                        'category' => $category,
                        'products' => $products
                    ]);
                }
            }
            
            return view('cntt.home.index', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'categories', 'blogs', 'categoriesWithProducts'
            ));
        }
    }

    public function category(Request $request, $slug)
    {
        $cateMenu = Category::all();
        $cateMenu = $this->buildTree($cateMenu);

        $phoneInfors = Infor::where('is_public', 1)->orderBy('stt', 'ASC')->get();
        $category = Category::where('slug', $slug)->first();

        if (!empty($category)) {
            // Seo Website
            $titleSeo = (!empty($category->title_seo)) ? $category->title_seo : config('common.title_seo');
            $keywordSeo = (!empty($category->keyword_seo)) ? $category->keyword_seo : config('common.keyword_seo');
            $descriptionSeo = (!empty($category->des_seo)) ? $category->des_seo : config('common.des_seo');
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

            return view('cntt.home.category', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'phoneInfors', 'cateParent', 'category',
                'categoryParentFind', 'products', 'prOutstand', 'filterCate'));
        }

        $idPro = Product::where('slug', $slug)->value('id');
        $product = Product::with('category')->findOrFail($idPro);
        // Seo Website
        $titleSeo = (!empty($product->title_seo)) ? $product->title_seo : config('common.title_seo');
        $keywordSeo = (!empty($product->keyword_seo)) ? $product->keyword_seo : config('common.keyword_seo');
        $descriptionSeo = (!empty($product->des_seo)) ? $product->des_seo : config('common.des_seo');

        $relatedProducts = $product->getRelatedProducts();
        $images = $product->getProductImages();
        $product->load('category.parent.parent.parent');
        
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

        return view('cntt.home.show', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'phoneInfors', 'product',
            'images', 'relatedProducts', 'uniqueCategories'));
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

    // Xử lý tìm kiếm
    public function search(Request $request)
    {
        // Seo Website
        $titleSeo = config('common.title_seo');
        $keywordSeo = config('common.keyword_seo');
        $descriptionSeo = config('common.des_seo');
        $phoneInfors = Infor::where('is_public', 1)->orderBy('stt', 'ASC')->get();

        $keyword = $request->keyword;
        $categoryId = $request->cate;

        $nameCate = null;
        if ($categoryId != 0) {
            $nameCate = Category::where('id', $categoryId)->value('name');
        }
        // Lấy ra các id con của nó
        if (!empty($categoryId)) {
            $childrenIds = $this->categorySrc->getAllChildrenIds($categoryId);
            $newArray = array_merge([$categoryId], $childrenIds);

            // Tìm kiếm sản phẩm theo tên hoặc mã sản phẩm
            $productsQuery = Product::where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%" . $keyword . "%")
                    ->orWhere('code', 'like', "%" . $keyword . "%");
            })->when($newArray, function ($query) use ($newArray) {
                $query->whereHas('category', function ($q) use ($newArray) {
                    $q->whereIn('category_id', $newArray);
                });
            });

            $total = $productsQuery->count();
            $products = $productsQuery->orderBy('created_at', 'DESC')->paginate(16);
            // Tính toán số lượng trang hiện có
            $currentPage = $request->input('page', 1);
            $lastPage = $products->lastPage();

            // Nếu trang yêu cầu vượt quá số trang hiện có, chuyển hướng đến trang cuối cùng
            if ($currentPage > $lastPage) {
                $products = $productsQuery->orderBy('created_at', 'DESC')
                    ->paginate(16, ['*'], 'page', $lastPage);
            }

            return view('cntt.home.search', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'keyword', 'nameCate',
                'products', 'phoneInfors', 'total'));
        } else {
            // Tìm kiếm sản phẩm theo tên hoặc mã sản phẩm
            $productsQuery = Product::where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%" . $keyword . "%")
                    ->orWhere('code', 'like', "%" . $keyword . "%");
            });

            $total = $productsQuery->count();
            $products = $productsQuery->orderBy('created_at', 'DESC')->paginate(16);
            // Tính toán số lượng trang hiện có
            $currentPage = $request->input('page', 1);
            $lastPage = $products->lastPage();

            // Nếu trang yêu cầu vượt quá số trang hiện có, chuyển hướng đến trang cuối cùng
            if ($currentPage > $lastPage) {
                $products = $productsQuery->orderBy('created_at', 'DESC')
                    ->paginate(16, ['*'], 'page', $lastPage);
            }

            return view('cntt.home.search', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'keyword', 'nameCate',
                'products', 'phoneInfors', 'total'));
        }
    }
}
