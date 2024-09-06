<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\Comment;
use App\Models\Infor;
use App\Models\News;
use App\Models\Product;
use App\Services\CategorySrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
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
        // Tin tức
        $blogs = News::where('is_outstand', 1)
            ->select('id', 'name', 'image', 'slug', 'alt_img', 'title_img', 'desc')
            ->orderBy('created_at', 'DESC')
            ->limit(12)->get();
        $cateBlogs = CategoryNew::where('is_menu', 1)->select('name', 'slug')->orderBy('created_at', 'ASC')->get();
        // Trang chủ ngoài
        // Lấy tất cả các danh mục có parent_id = 0
        $categories = Category::where('is_public', 1)
            ->select('id', 'name', 'slug', 'image', 'title_img', 'alt_img', 'is_serve')
            ->orderBy('stt_cate', 'ASC')
            ->get();

        // Lấy danh mục có is_serve = 1 có stt_cate từ nhỏ tới lớn 
        $cate = $categories->where('is_serve', 1);
        $ids = $cate->pluck('id');
        if ($ids->isEmpty()) {

            return view('cntt.home.index', compact('titleSeo', 'keywordSeo', 'descriptionSeo', 'categories', 'blogs', 'cateBlogs'));
        } else {
            $categoriesWithProducts = collect();
            foreach ($ids as $idCate) {
                $category = Category::find($idCate);
                if ($category) {
                    // Lấy tất cả các id danh mục con bao gồm cả id gốc
                    $allCategoryIds = array_merge([$idCate], $category->getAllChildrenIds());
                    // Lấy tất cả sản phẩm thuộc các danh mục đó
                    $products = Product::whereHas('category', function ($query) use ($allCategoryIds) {
                        $query->whereIn('product_categories.category_id', $allCategoryIds);
                    })->select('name', 'slug', 'price', 'image_ids')
                        ->where('is_outstand', 1)
                        ->orderBy('created_at', 'DESC')->get();
                    
                    foreach ($products as $product) {
                        $product->loadProductImages();
                    }

                    // tách sản phẩm nào thì thuộc danh mục sản phẩm đó
                    $categoriesWithProducts->push([
                        'category' => $category,
                        'products' => $products
                    ]);
                }
            }

            return view('cntt.home.index', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'categories', 'blogs', 'cateBlogs',
                'categoriesWithProducts'
            ));
        }
    }

    public function category(Request $request, $slug)
    {
        $cateMenu = Category::all();
        $cateMenu = $this->buildTree($cateMenu);

        $phoneInfors = Infor::where('is_public', 1)->orderBy('stt', 'ASC')->get();
        $slugs = explode('-', $slug);
        $mainCate = Category::where('slug', $slug)->with('children')->first(); // Lấy ra danh mục chính
        if (!empty($mainCate)) {
            // Seo Website
            $titleSeo = (!empty($mainCate->title_seo)) ? $mainCate->title_seo : config('common.title_seo');
            $keywordSeo = (!empty($mainCate->keyword_seo)) ? $mainCate->keyword_seo : config('common.keyword_seo');
            $descriptionSeo = (!empty($mainCate->des_seo)) ? $mainCate->des_seo : config('common.des_seo');

            // Lấy ra id của parent_id = 0 
            $cateParent = $mainCate->topLevelParent();
            $allParents = $mainCate->getAllParents();
            $filterCate = $cateParent->getFilterCates();
            $categoryIds = $mainCate->getAllChildrenIds();
            array_unshift($categoryIds, $mainCate->id); // Thêm ID danh mục chính vào danh sách

            $prOutstand = Product::where('is_outstand', 1)
                ->whereHas('category', function ($query) use ($categoryIds) {
                    $query->whereIn('category_id', $categoryIds);
                })->orderBy('created_at', 'DESC')
                ->take(10)->get();

            foreach ($prOutstand as $product) {
                    $product->loadProductImages();
                }
           
            // Bộ lọc sản phẩm
            $filters = $request->all();
            if (!empty($filters)) {
                $products = Product::query();
                $filterConditions = [];

                foreach ($filters as $key => $value) {
                    // Bỏ qua 'page' vì nó không phải là bộ lọc sản phẩm
                    if ($key === 'page') {
                        continue;
                    }

                    $filterIds = explode(',', $value);
                    if (count($filterIds) > 0) {
                        $filterConditions[] = $filterIds;
                    }
                }

                if (count($filterConditions) == 1) {
                    // Nếu chỉ có 1 bộ lọc, sử dụng whereIn trực tiếp
                    $products->whereHas('filters', function ($query) use ($filterConditions) {
                        $query->whereIn('filters_products.filter_id', $filterConditions[0]);
                    });
                } else {
                    // Nếu có nhiều bộ lọc, sử dụng where với nhiều whereIn bên trong whereHas
                    $products->where(function ($query) use ($filterConditions) {
                        foreach ($filterConditions as $filterIds) {
                            $query->whereHas('filters', function ($subQuery) use ($filterIds) {
                                $subQuery->whereIn('filters_products.filter_id', $filterIds);
                            });
                        }
                    });
                }
                $total = $products->count();
                // Xử lý phân trang
                $currentPage = $request->input('page', 1);
                // Tính số trang tối đa dựa trên số lượng sản phẩm và số lượng sản phẩm mỗi trang
                $lastPage = ceil($total / 10); // 10 là số sản phẩm mỗi trang, điều chỉnh nếu cần
                
                // Nếu số trang yêu cầu vượt quá số trang hiện có, đặt nó về trang cuối cùng
                if ($currentPage > $lastPage) {
                    $currentPage = $lastPage;
                }
                $products = $products->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'page', $currentPage);
                // Lấy URL hiện tại và xử lý chuỗi query
                $currentUrl = request()->fullUrl();
                $currentUrl = preg_replace('/(&|\?)page=\d+/', '', $currentUrl);
                $currentUrl = str_replace('%2C', ',', $currentUrl);

                // Gán URL đã xử lý vào phân trang
                $products->withPath($currentUrl);

                // Gán URL đã xử lý vào phân trang
                $products->withPath($currentUrl);
                
                return view('cntt.home.category', compact(
                    'titleSeo', 'keywordSeo', 'descriptionSeo',
                    'total', 'phoneInfors', 'cateParent',
                    'mainCate', 'allParents', 'products',
                    'prOutstand', 'filterCate', 'slugs'
                ));
            }

            $products = Product::where(function ($query) use ($categoryIds) {
                // Truy vấn các sản phẩm thuộc danh mục chính
                $query->whereHas('category', function ($query) use ($categoryIds) {
                    $query->whereIn('category_id', $categoryIds);
                });
                // Truy vấn các sản phẩm có danh mục phụ nằm trong danh sách các danh mục con của danh mục chính
                $query->orWhere(function ($query) use ($categoryIds) {
                    foreach ($categoryIds as $categoryId) {
                        $query->orWhereJsonContains('subCategory', (string)$categoryId);
                    }
                });
            })->orderBy('created_at', 'DESC')->paginate(10);

            foreach ($products as $product) {
                $product->loadProductImages();
            }

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
                'phoneInfors', 'cateParent', 'mainCate',
                'allParents', 'products', 'prOutstand',
                'filterCate', 'slugs'
            ));
        }

        $idPro = Product::where('slug', $slug)->value('id');
        $product = Product::with('category')->findOrFail($idPro);

        $categoryId = $product->category->pluck('id')->first();
        $parent = Category::where('id', $categoryId)->first();
        $allParents = $parent->getAllParents();

        // Seo Website
        $titleSeo = (!empty($product->title_seo)) ? $product->title_seo : config('common.title_seo');
        $keywordSeo = (!empty($product->keyword_seo)) ? $product->keyword_seo : config('common.keyword_seo');
        $descriptionSeo = (!empty($product->des_seo)) ? $product->des_seo : config('common.des_seo');

        $relatedProducts = $product->getRelatedProducts();
        $images = $product->getProductImages();

        // Comments 
        $commentsQuery = Comment::query(); // Khởi tạo query builder cho bảng comments
        
        if (Auth::check() && Auth::user()->role == 1) {
            // Nếu role = 1, lấy tất cả các comments cho sản phẩm này
            $commentsQuery->where('comments.product_id', $idPro)
                        ->where('comments.parent_id', 0)
                        ->with('replies') // Load các bình luận con
                        ->orderBy('comments.created_at', 'DESC');
        } else {
            // Nếu role khác 1, lấy các bình luận public hoặc bình luận của chính người dùng đó
            $commentsQuery->where('comments.product_id', $idPro)
                          ->where('comments.parent_id', 0)
                          ->where(function($query) {
                                $query->where('comments.is_public', 1) // Hiển thị bình luận công khai
                                    ->orWhere(function($query) {
                                    // Nếu bình luận của chính người dùng hiện tại, hiển thị nó bất kể is_public là gì
                                        $query->whereNotNull('comments.user_id')->where('comments.user_id', Auth::id());
                                    });
                            })
                          ->with('cmtChild') // Load các bình luận con
                          ->orderBy('comments.created_at', 'DESC');
        }

        $comments = $commentsQuery->get();

        // Tính tổng số bình luận (cha + con)
        $totalCommentsCount = Comment::where('product_id', $idPro)
        ->where(function ($query) {
            $query->where('parent_id', 0) // Bình luận cha
                ->orWhere(function ($query) {
                    $query->where('parent_id', '>', 0); // Bình luận con
                });
        })
        ->where(function($query) {
            if (!Auth::check() || Auth::user()->role != 1) {
                $query->where('is_public', 1) // Hiển thị bình luận công khai
                    ->orWhere(function($query) {
                        $query->whereNotNull('user_id')
                                ->where('user_id', Auth::id());
                    });
            }
        })
        ->count();
        $user = Auth::user();

        return view('cntt.home.show', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'phoneInfors', 'product', 'allParents',
            'parent', 'images', 'relatedProducts',
            'comments', 'totalCommentsCount', 'user'
        ));
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
                'keyword', 'nameCate', 'products',
                'phoneInfors', 'total'
            ));
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
                'keyword', 'nameCate', 'products',
                'phoneInfors', 'total'
            ));
        }
    }

    public function filters(Request $request)
    {
        $filters = $request->input('filters', null);

        if (!empty($filters)) {
            // Decode chuỗi JSON sang mảng
            $filtersArray = json_decode($filters, true);

            // Kiểm tra xem $filtersArray có phải là mảng không
            if (is_array($filtersArray)) {
                $products = Product::query();

                foreach ($filtersArray as $key => $values) {
                    if (is_array($values) && count($values) > 0) {
                        // Sử dụng whereHas để lọc sản phẩm dựa trên filter_id
                        $products->whereHas('filters', function ($query) use ($values) {
                            $query->whereIn('filters_products.filter_id', $values);
                        });
                    }
                }

                // Đếm tổng số sản phẩm thỏa mãn điều kiện
                $total = $products->count();

                return response()->json(['count' => $total]);
            } else {
                return response()->json(['error' => 'Invalid filters format'], 400);
            }
        } else {
            return response()->json(['count' => 0]);
        }
    }
}
