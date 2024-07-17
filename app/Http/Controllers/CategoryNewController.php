<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Requests\CategoryNewFormRequest;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryNewController extends Controller
{
    public function index(Request $request)
    {
        $cateNew = CategoryNew::where('parent_id', 0)
            ->with('children')
            ->get();
        // $cateNew = CategoryNew::latest()->paginate(10)->appends($request->except('page'));

        return view('admin.cateNew.index', compact('cateNew'));
    }

    public function isCheckbox(Request $request)
    {
        $category = CategoryNew::find($request->id);
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
        $nameExists = CategoryNew::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = CategoryNew::where('slug', $slug)->exists() || News::where('slug', $slug)->exists();

        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cateNewParents = CategoryNew::where('parent_id', 0)
            ->with('children')
            ->get();
        
        return view('admin.cateNew.create', compact('cateNewParents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryNewFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('cateNews.index'))->with(['message' => 'Create Success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = CategoryNew::findOrFail($id);
        $categories = CategoryNew::with('children')->where('parent_id', 0)->get();
        // Lấy ra sản phẩm liên quan
        if (!empty($category->related_pro)) {
            $relatedPro = $category->getRelatedPro();

            return view('admin.cateNew.edit', compact('category', 'categories', 'relatedPro'));
        }
        
        return view('admin.cateNew.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryNewFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return redirect(route('cateNews.index'))->with(['message' => "Updated category successfully !"]);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $category = empty($id) ? new CategoryNew() : CategoryNew::findOrFail($id);

        if (!empty($request['related_pro'])) {
            $request['related_pro'] = json_encode($request->related_pro);
        }

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
        $category->stt_new = (isset($request->stt_new)) ? $request->stt_new : 999;

        $category->save();
    }

    public function search(Request $request)
    {
        $related_pro = [];
        if ($search = $request->name) {
            $related_pro = Product::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($related_pro);
    }

    public function checkStt(Request $request){
        $sttNew = $request->input('stt_new');
        if (!empty($sttNew)) {
            $request->validate([
                'stt_new' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = CategoryNew::findOrFail($id);
        $category->stt_new = (isset($sttNew)) ? $sttNew : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'STT updated successfully.']);
    }
}
