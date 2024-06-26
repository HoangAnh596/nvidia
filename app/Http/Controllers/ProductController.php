<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Requests\ProductFormRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Maker;
use App\Models\ProductImages;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $products = Product::where('name', 'like', "%" . Helper::escape_like($keyword) . "%");

        if ($request->get('cate')) {
            // $products->where('ca_id', $request->cate);
        }

        $products = $products->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));

        $categories = Category::all();

        return view('admin.product.index', compact('products', 'keyword', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)
        ->with('children')
        ->get();

        return view('admin.product.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect()->back()->with(['message' => 'Tạo mới sản phẩm thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::with('children')->where('parent_id', 0)->get();
        // Lấy ra sản phẩm liên quan
        $pro = Product::findOrFail($id);
        
        $images = $pro->getProductImages();
        $relatedProducts = $pro->getRelatedProducts();
        $productTags = $pro->getProductTags();
        
        return view('admin.product.edit', compact('product', 'categories', 'images' ,'relatedProducts', 'productTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return redirect(route('product.index'))->with(['message' => "Cập nhật sản phẩm thành công!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect(route('product.index'))->with(['message' => 'Delete product success']);
    }

    public function insertOrUpdate(ProductFormRequest $request, $id = '')
    {
        $product = empty($id) ? new Product() : Product::findOrFail($id);

        if(!empty($request['related_pro'])) {
            $request['related_pro'] = json_encode($request->related_pro);
        }
        
        if(!empty($request['tag_ids'])) {
            $inputArray = $request->tag_ids;
            $numericArray = array_filter($inputArray, function($value) {
                return is_numeric($value);
            });
            
            // Chuyển mảng thành các giá trị số (không bắt buộc, nếu cần thiết)
            $numericArray = array_map('strval', $numericArray);
            
            // Đặt lại các khóa của mảng
            $numericArray = array_values($numericArray);
            $request['tag_ids'] = json_encode($numericArray);
        }

        // Xóa ảnh hiện tại nếu checkbox "Xóa Ảnh" được đánh dấu
        if ($request->has('delete_image') && $request->input('delete_image') == 1) {
            Storage::delete($product->image);
            $product->image = null;
        }
        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $product->fill($request->all());
        $product->image = $path;
        $product->title_img = (isset($request->title_img)) ? $request->title_img : $request->name;
        $product->alt_img = (isset($request->alt_img)) ? $request->alt_img : $request->name;
        
        // Thêm mới images con vào bảng Product_Images
        $idPrImage = [];
        $pathPrImages = parse_url($request->filepathPrImages, PHP_URL_PATH);
        if ($request->hasFile('pr_image_ids') || !empty($pathPrImages)) {
            
            if (strpos($pathPrImages, '/') === 0) {
                $pathPrImages = substr($pathPrImages, 1);
            }
            
            $productImage = ProductImages::create(
                [
                    'title' => (isset($request->title_pr_images)) ? $request->title_pr_images : $request->name,
                    'alt' => (isset($request->alt_pr_images)) ? $request->alt_pr_images : $request->name,
                    'image' => $pathPrImages,
                    'stt_img' => (isset($request->stt_img)) ? $request->stt_img : 999,
                ]
            );
            $idPrImage[] = $productImage->id;
        }
        
        if (isset($request->id)) {
            if(empty($product->image_ids)){
                $product['image_ids'] = json_encode(array_map('strval', $idPrImage));
            }
            $arr_current = $product->image_ids;
            $arr_new = $idPrImage;
            $product->image_ids = json_encode(array_merge(json_decode($arr_current), array_map('strval', $arr_new)));
        }
        if (!empty($idPrImage) && !isset($request->id)) {
            $product['image_ids'] = json_encode(array_map('strval', $idPrImage));
        }
        
        if(!empty($id)) {
            // Cập nhật mối quan hệ belongsToMany
            $cate_current = DB::table('product_categories')->where('product_id', $id)->value('category_id');
            $cate_new = (int)($request->category);
            if($cate_new != $cate_current) {
                $product->category()->detach();
            }
        }
        
        $product->save();
        $product->category()->attach($request->category);
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $id = $request->get('id');

        // Check if name exists, excluding the current product id
        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $nameExists = Product::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = Category::where('slug', $slug)->exists() || Product::where('slug', $slug)->exists();

        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists
        ]);
    }

    public function search(Request $request)
    {
        $related_pro = [];
        if ($search = $request->name) {
            $related_pro = Product::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($related_pro);
    }

    public function searchTags(Request $request)
    {
        $query = [];
        if ($search = $request->name) {
            $query = ProductTag::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($query);
    }
}
