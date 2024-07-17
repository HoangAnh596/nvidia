<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Http\Helpers\Helper;
use App\Http\Requests\NewFormRequest;
use App\Models\CategoryNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $news = News::where('name', 'like', "%" . Helper::escape_like($keyword) . "%");
        
        $news = $news->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));
        $categories = CategoryNew::all();


        return view('admin.news.index', compact('news', 'keyword', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryNew::where('slug','<>','blogs')->get();
        
        return view('admin.news.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->insertOrUpdate($request);

        return redirect()->back()->with(['message' => 'Tạo mới thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $news = News::findOrFail($id);

    //     return view('admin.news.show', compact('news'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new = News::findOrFail($id);
        $categories = CategoryNew::where('slug','<>','blogs')->get();
        
        return view('admin.news.edit', compact('new', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return redirect(route('news.index'))->with(['message' => "Cập nhật tin tức thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::findOrFail($id)->delete();

        return redirect()->route('news.index')->with(['message' => 'Delete Success']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $new = empty($id) ? new News() : News::findOrFail($id);

        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $new->fill($request->all());
        $new->image = $path;
        // Xóa ảnh hiện tại nếu checkbox "Xóa Ảnh" được đánh dấu
        if ($request->has('delete_image') && $request->input('delete_image') == 1) {
            Storage::delete($new->image);
            $new->image = null;
        }
        $new->title_img = (isset($request->title_img)) ? $request->title_img : $request->name;
        $new->alt_img = (isset($request->alt_img)) ? $request->alt_img : $request->name;
        // dd($new);
        $new->save();
    }

    public function isCheckbox(Request $request)
    {
        $new = News::findOrFail($request->id);
        $new->is_outstand = $request->is_outstand;
        $new->save();

        return response()->json(['success' => true]);
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $id = $request->get('id');

        // Check if name exists, excluding the current new id
        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $nameExists = News::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = CategoryNew::where('slug', $slug)->exists() || News::where('slug', $slug)->exists();

        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists
        ]);
    }
}
