<?php

namespace App\Http\Controllers;

use App\Exports\ProductsCompareExport;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\Comment;
use App\Models\CompareProduct;
use App\Models\Group;
use App\Models\Infor;
use App\Models\News;
use App\Models\Product;
use App\Models\Slider;
use App\Services\CategoryNewSrc;
use App\Services\CategorySrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    protected $categorySrc;
    protected $categoryNewSrc;

    public function __construct(CategorySrc $categorySrc, CategoryNewSrc $categoryNewSrc)
    {
        $this->categorySrc = $categorySrc;
        $this->categoryNewSrc = $categoryNewSrc;
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

        // Sliders
        $sliders = Slider::where('is_public', 1)
            ->select('id', 'name', 'image', 'url', 'url_text', 'title', 'description', 'stt_slider', 'is_color')
            ->orderBy('stt_slider', 'ASC')
            ->orderBy('updated_at', 'DESC')->get();
        // $totalSlider = $sliders->count();
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

            return view('cntt.home.index', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'categories', 'blogs', 'cateBlogs',
                'sliders'));
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
                    // dd($products);
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
                'categoriesWithProducts', 'sliders'
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
        // dd($mainCate);
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

        $groupProducts = [];
        if (!empty($product->group_ids)) {
            // Chuyển đổi JSON thành mảng
            $groupIds = json_decode($product->group_ids, true);
            // Lấy các bản ghi từ bảng Group có id nằm trong groupIds
            $groupProducts = Group::select('id', 'name')->whereIn('id', $groupIds)->get();
        }
        
        return view('cntt.home.show', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'phoneInfors', 'product', 'allParents',
            'parent', 'images', 'relatedProducts',
            'comments', 'totalCommentsCount', 'user',
            'groupProducts'
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
        // dd(1);
        // Seo Website
        $titleSeo = config('common.title_seo');
        $keywordSeo = config('common.keyword_seo');
        $descriptionSeo = config('common.des_seo');
        $phoneInfors = Infor::where('is_public', 1)->orderBy('stt', 'ASC')->get();

        $keyword = $request->keyword;
        $searchCate = $request->cate;
        // dd($searchCate); // news;prod
        $nameCate = null;
        // Tách source và id từ giá trị searchCate 

        if (strpos($searchCate, '_') !== false) {
            list($source, $searchId) = explode('_', $searchCate);

            if ($source === 'news') {
                // Truy vấn bảng CategoryNew
                $nameCate = CategoryNew::where('id', $searchId)->value('name');
                $childrenIds = $this->categoryNewSrc->getAllChildrenIds($searchId);
                $newArray = array_merge([$searchId], $childrenIds);

                // Tìm kiếm bài viết theo tên hoặc mã sản phẩm
                $newsQuery = News::where(function ($query) use ($keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                })->when($newArray, function ($query) use ($newArray) {
                    $query->whereIn('cate_id', $newArray);
                });

                $total = $newsQuery->count();
                $news = $newsQuery->orderBy('created_at', 'DESC')->paginate(10);

                // Tính toán số lượng trang hiện có
                $currentPage = $request->input('page', 1);
                $lastPage = $news->lastPage();

                // Nếu trang yêu cầu vượt quá số trang hiện có, chuyển hướng đến trang cuối cùng
                if ($currentPage > $lastPage) {
                    $news = $newsQuery->orderBy('created_at', 'DESC')
                        ->paginate(16, ['*'], 'page', $lastPage);
                }

                return view('cntt.home.blogs.search', compact(
                    'titleSeo', 'keywordSeo', 'descriptionSeo',
                    'keyword', 'nameCate', 'news',
                    'phoneInfors', 'total'
                ));
            } elseif ($source === 'prod') {
                // Truy vấn bảng Category
                $nameCate = Category::where('id', $searchId)->value('name');
                $childrenIds = $this->categorySrc->getAllChildrenIds($searchId);
                $newArray = array_merge([$searchId], $childrenIds);

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
                $products = $productsQuery->orderBy('created_at', 'DESC')->paginate(16)->appends($request->except('page'));

                foreach ($products as $product) {
                    $product->loadProductImages();
                }

                // Tính toán số lượng trang hiện có
                $currentPage = $request->input('page', 1);
                $lastPage = $products->lastPage();

                // Nếu trang yêu cầu vượt quá số trang hiện có, chuyển hướng đến trang cuối cùng
                if ($currentPage > $lastPage) {
                    $products = $productsQuery->orderBy('created_at', 'DESC')
                        ->paginate(16, ['*'], 'page', $lastPage)->appends($request->except('page'));
                }

                return view('cntt.home.search', compact(
                    'titleSeo', 'keywordSeo', 'descriptionSeo',
                    'keyword', 'nameCate', 'products',
                    'phoneInfors', 'total'
                ));
            }
        } else {
            // Trường hợp $searchCate là 'news' hoặc 'prod' không có id
            if ($searchCate === 'news') {
                // Lấy tất cả bài viết
                $newsQuery = News::where('name', 'like', "%" . $keyword . "%");
    
                $total = $newsQuery->count();
                $news = $newsQuery->orderBy('created_at', 'DESC')->paginate(10)->appends($request->except('page'));
 
                // Tính toán số lượng trang hiện có
                $currentPage = $request->input('page', 1);
                $lastPage = $news->lastPage();
    
                // Nếu trang yêu cầu vượt quá số trang hiện có, chuyển hướng đến trang cuối cùng
                if ($currentPage > $lastPage) {
                    $news = $newsQuery->orderBy('created_at', 'DESC')
                        ->paginate(10, ['*'], 'page', $lastPage)->appends($request->except('page'));
                }
    
                return view('cntt.home.blogs.search', compact(
                    'titleSeo', 'keywordSeo', 'descriptionSeo',
                    'keyword', 'nameCate', 'news',
                    'phoneInfors', 'total'
                ));
    
            } elseif ($searchCate === 'prod') {
                // Lấy tất cả sản phẩm
                $productsQuery = Product::where(function ($query) use ($keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%")
                        ->orWhere('code', 'like', "%" . $keyword . "%");
                });
    
                $total = $productsQuery->count();
                $products = $productsQuery->orderBy('created_at', 'DESC')->paginate(16);
    
                foreach ($products as $product) {
                    $product->loadProductImages();
                }
    
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

    public function listPrice(Request $request)
    {
        $titleSeo = config('common.title_seo');
        $keywordSeo = config('common.keyword_seo');
        $descriptionSeo = config('common.des_seo');

        $key = $request->key;

        if(!empty($key)){
            $products = Product::where('code', 'like', "%$key%")
                ->select('slug', 'image_ids', 'code', 'title_seo')
                ->latest()->get();
            
            foreach ($products as $product) {
                    $product->loadProductImages();
                }
            
            return view('cntt.home.listPrice', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'key', 'products'
            ));
        }

        return view('cntt.home.listPrice', compact(
            'titleSeo', 'keywordSeo',
            'descriptionSeo', 'key'
        ));
    }

    public function compareProduct(Request $request)
    {
        // dd($request->all());
        $query = $request->input('query');
        $prodId = $request->input('id');
        $products = Product::findOrFail($prodId);
        
        // Lấy ra ID của các categories
        $categoryIds = $products->category()->pluck('categories.id')->first();
        // Lấy ra id của parent_id = 0 
        $cateId = Category::findOrFail($categoryIds)->topLevelParent()->id;
        // Kiểm tra nếu danh mục tồn tại
        if (!$cateId) {
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }
        $category = Category::findOrFail($cateId);
        $allCategoryIds = array_merge([$categoryIds], $category->getAllChildrenIds());
        
        // Lấy danh sách sản phẩm dựa trên từ khóa (tìm theo tên hoặc mã)
        $products = Product::whereHas('category', function ($query) use ($allCategoryIds) {
                $query->whereIn('product_categories.category_id', $allCategoryIds);
            })
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                ->orWhere('code', 'LIKE', "%$query%");
            })
            ->where('id', '!=', $prodId) // Loại bỏ sản phẩm có ID bằng $prodId
            ->orderBy('created_at', 'DESC')
            ->get();
        
        // Trả về kết quả dưới dạng JSON
        return response()->json($products);
    }

    public function compareCate(Request $request)
    {
        $search = $request->input('query');
        $cateId = $request->input('id');
        $product1 = $request->input('product1'); // 6
        $product2 = $request->input('product2'); // 7
        $categories = Category::findOrFail($cateId);
        // dd($categories);
        // Lấy tất cả danh mục con (bao gồm cả danh mục cha)
        $allCategoryIds = $this->getAllCategoryIds($categories);

        // Truy vấn sản phẩm theo danh mục, tên sản phẩm và loại bỏ sản phẩm 1 và 2
        $products = Product::whereHas('category', function ($query) use ($allCategoryIds) {
                $query->whereIn('product_categories.category_id', $allCategoryIds); // Lọc theo danh mục
            })
            ->when($search, function ($query) use ($search) {
                // Nếu có giá trị search, tìm kiếm sản phẩm theo tên
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->whereNotIn('id', [$product1, $product2]) // Loại bỏ sản phẩm 1 và 2
            ->get();
    
        // Trả về kết quả dưới dạng JSON
        return response()->json($products);
    }

    // Hàm đệ quy để lấy tất cả ID của danh mục con và chính danh mục cha
    protected function getAllCategoryIds($category)
    {
        $categoryIds = collect([$category->id]);

        if ($category->children->isNotEmpty()) {
            foreach ($category->children as $child) {
                $categoryIds = $categoryIds->merge($this->getAllCategoryIds($child));
            }
        }

        return $categoryIds;
    }

    public function compare($product)
    {
        // Tách chuỗi bằng dấu -vs-
        $products = explode('-vs-', $product);
    
        // Kiểm tra nếu có ít nhất là 2 lớn nhất 3
        if (count($products) >= 2 && count($products) <= 3) {
            $prod_1 = trim($products[0]); // dtdd-xiaomi-64gb
            $prod_2 = trim($products[1]); // dtdd-oppo-64-gb
            $prod_3 = count($products) === 3 ? trim($products[2]) : null; // Nếu có 3 phần tử, lấy phần tử thứ ba

            // Debug để kiểm tra kết quả
            $product1 = Product::where('slug', $prod_1)->firstOrFail();
            $product2 = Product::where('slug', $prod_2)->firstOrFail();
            $product3 = $prod_3 ? Product::where('slug', $prod_3)->first() : null;
            
            // Lấy ID của categories
            $cateId1 = $product1->category()->pluck('categories.id')->first();
            $cateId2 = $product2->category()->pluck('categories.id')->first();
            $cateId3 = $product3 ? $product3->category()->pluck('categories.id')->first() : null;
            dd($cateId1);
            // Lấy ra id của parent_id = 0 
            $parentId1 = Category::findOrFail($cateId1)->topLevelParent()->id;
            $parentId2 = Category::findOrFail($cateId2)->topLevelParent()->id;
            $parentId3 = $cateId3 ? Category::findOrFail($cateId3)->topLevelParent()->id : null;
            
            // Kiểm tra nếu danh mục của sản phẩm 1 và 2 không giống nhau
            if ($parentId1 !== $parentId2 || ($parentId3 && $parentId1 !== $parentId3)) {
                abort(404, 'Sản phẩm không thuộc cùng một danh mục');
            }
            // Lấy categories
            $category = Category::find($parentId1);
            $compareCates = $category->getCompareCates();
            // Lấy dữ liệu từ bảng Compare dựa trên compare_cate_id
            foreach ($compareCates as $compareCate) {
                // Truy xuất mối quan hệ với Compare
                $valueCompares[$compareCate->id] = $compareCate->valueCompares;
            }
            
            // Truy xuất dữ liệu so sánh giữa 2 sản phẩm
            $compareProduct1 = CompareProduct::where('product_id', $product1->id)->get()->keyBy('compare_id') ?? collect([]);
            $compareProduct2 = CompareProduct::where('product_id', $product2->id)->get()->keyBy('compare_id') ?? collect([]);

            // Nếu sản phẩm thứ 3 tồn tại, lấy dữ liệu so sánh cho sản phẩm thứ 3, nếu không thì đặt thành một collection rỗng
            $compareProduct3 = $product3 ? CompareProduct::where('product_id', $product3->id)->get()->keyBy('compare_id') : collect([]);
            // Lấy ảnh chính của từng sản phẩm nếu có
            $image1 = $product1 ? $product1->getMainImage() : null;
            $image2 = $product2 ? $product2->getMainImage() : null;
            $image3 = $product3 ? $product3->getMainImage() : null;

            $titleSeo = 'So sánh ' . $category->name .' '. $product1->code . ' và ' . $product2->code;
            if ($product3) {
                $titleSeo .= ' và ' . $product3->code;
            }
            $keywordSeo = config('common.keyword_seo');
            $descriptionSeo = $titleSeo;

            // Lấy tất cả danh mục con (bao gồm cả danh mục cha)
            $allCategoryIds = $this->getAllCategoryIds($category);

            // Truy vấn sản phẩm theo danh mục, tên sản phẩm và loại bỏ sản phẩm 1 và 2
            $saleProducts = Product::whereHas('category', function ($query) use ($allCategoryIds) {
                    $query->whereIn('product_categories.category_id', $allCategoryIds); // Lọc theo danh mục
                })->select('id', 'name', 'slug', 'price', 'image_ids')
                ->where('is_outstand', 1)
                ->whereNotIn('id', [$product1->id, $product2->id])
                ->latest('updated_at') // Sắp xếp theo updated_at mới nhất
                ->take(6) // Lấy 6 bản ghi
                ->get();
            
            // Lấy ảnh chính cho từng sản phẩm
            $saleProducts->each(function ($product) {
                $product->main_image = $product->getMainImage(); // Thêm ảnh chính vào đối tượng sản phẩm
            });
            
            // Hiển thị kết quả để kiểm tra
            
            return view('cntt.home.compare', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'product1', 'product2', 'product3', 'category',
                'compareProduct1', 'compareProduct2', 'compareProduct3',
                'compareCates', 'valueCompares', 'saleProducts',
                'image1', 'image2', 'image3'));
        } else {
            // Xử lý trường hợp không có dấu -vs- hoặc số phần tử không đúng
            abort(404, 'URL không hợp lệ');
        }
    }

    public function exportCompare(Request $request)
    {
        // Lấy danh sách ID sản phẩm từ request
        $productIds = $request->input('products');
        // Kiểm tra số lượng sản phẩm phải nằm trong khoảng từ 2 đến 3
        if (count($productIds) >= 2 && count($productIds) <= 3) {
            // $products = Product::whereIn('id', $productIds)->get();
            // Gán ID sản phẩm vào các biến theo thứ tự
            $prod_1 = $productIds[0]; // Sản phẩm thứ 1
            $prod_2 = $productIds[1]; // Sản phẩm thứ 2

            // Nếu có sản phẩm thứ 3 thì gán
            $prod_3 = isset($productIds[2]) ? $productIds[2] : null;

            // Debug để kiểm tra kết quả
            $product1 = Product::where('id', $prod_1)->firstOrFail();
            $product2 = Product::where('id', $prod_2)->firstOrFail();
            $product3 = $prod_3 ? Product::where('id', $prod_3)->first() : null;

            // Lấy ID của categories
            $cateId = $product1->category()->pluck('categories.id')->first();
            $parentId = Category::findOrFail($cateId)->topLevelParent()->id;
            // Lấy categories
            $category = Category::find($parentId);
            $compareCates = $category->getCompareCates();
            // Lấy dữ liệu từ bảng Compare dựa trên compare_cate_id
            foreach ($compareCates as $compareCate) {
                // Truy xuất mối quan hệ với Compare
                $valueCompares[$compareCate->id] = $compareCate->valueCompares;
            }

            // Truy xuất dữ liệu so sánh giữa 2 sản phẩm
            $compareProduct1 = CompareProduct::where('product_id', $product1->id)->get()->keyBy('compare_id') ?? collect([]);
            $compareProduct2 = CompareProduct::where('product_id', $product2->id)->get()->keyBy('compare_id') ?? collect([]);

            // Nếu sản phẩm thứ 3 tồn tại, lấy dữ liệu so sánh cho sản phẩm thứ 3, nếu không thì đặt thành một collection rỗng
            $compareProduct3 = $product3 ? CompareProduct::where('product_id', $product3->id)->get()->keyBy('compare_id') : collect([]);

            // Trả về file Excel
            return Excel::download(new ProductsCompareExport(
                $product1, $product2, $product3,
                $compareCates, $valueCompares,
                $compareProduct1, $compareProduct2, $compareProduct3
            ), 'products_compare.xlsx');
        } else {
            // Nếu không hợp lệ, trả về lỗi hoặc phản hồi tùy ý
            return response()->json([
                'error' => 'Số lượng sản phẩm để so sánh phải từ 2 đến 3'
            ], 400);
        }
    }
}
