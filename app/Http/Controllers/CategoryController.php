<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Helpers\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $categoryParents = Category::where('parent_id', 0)
            ->with('children')
            ->get();

        return view('admin.category.index', compact('categoryParents'));
    }

    public function isCheckbox(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['is_serve', 'is_parent', 'is_menu', 'is_outstand', 'is_public'])) {
                $category->$field = $value;

                $category->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Field does not exist.']);
            }
        }
        return response()->json(['success' => false]);
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $id = $request->get('id');

        // Check if name exists, excluding the current category id
        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $nameExists = Category::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = Category::where('slug', $slug)->exists() || Product::where('slug', $slug)->exists();
        
        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryParents = Category::where('parent_id', 0)
            ->with('children')
            ->get();

        return view('admin.category.create', compact('categoryParents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('categories.index'))->with(['message' => 'Create Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('id', $id)->with('children')->first();

        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::with('children')->where('parent_id', 0)->get();

        return view('admin.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return redirect(route('categories.index'))->with(['message' => "Updated category successfully !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect(route('categories.index'))->with(['message' => 'Delete Success']);
    }

    public function insertOrUpdate(CategoryFormRequest $request, $id = '')
    {
        $category = empty($id) ? new Category() : Category::findOrFail($id);

        $category->fill($request->all());
        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $category->image = $path;
        // Xóa ảnh hiện tại nếu checkbox "Xóa Ảnh" được đánh dấu
        if ($request->has('delete_image') && $request->input('delete_image') == 1) {
            Storage::delete($category->image);
            $category->image = null;
        }

        $category->title_img = (isset($request->title_img)) ? $request->title_img : $request->name;
        $category->alt_img = (isset($request->alt_img)) ? $request->alt_img : $request->name;
        $category->title_seo = (isset($request->title_seo)) ? $request->title_seo : $request->name;
        $category->keyword_seo = (isset($request->keyword_seo)) ? $request->keyword_seo : $request->name;
        $category->des_seo = (isset($request->des_seo)) ? $request->des_seo : $request->name;
        $category->stt_cate = (isset($request->stt_cate)) ? $request->stt_cate : 999;

        $category->save();
    }

    public function checkStt(Request $request){
        $sttCate = $request->input('stt_cate');
        if (!empty($sttCate)) {
            $request->validate([
                'stt_cate' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = Category::findOrFail($id);
        $category->stt_cate = (isset($sttCate)) ? $sttCate : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'STT updated successfully.']);
    }
}
