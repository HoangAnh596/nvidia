<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Requests\FilterCateFormRequest;
use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterCate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilterCateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $filter = FilterCate::where('name', 'like', "%" . Helper::escape_like($keyword) . "%");
        
        $filter = $filter->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));

        return view('admin.filter.index', compact('filter', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $idCate = $request->cate_id;
        $categories = Category::with('children')->where('parent_id', 0)->get();

        return view('admin.filter.create', compact('idCate', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilterCateFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('categories.index'))->with(['message' => 'Tạo mới bộ lọc thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filter = FilterCate::findOrFail($id);
        // Lấy danh sách các bản ghi liên quan và sắp xếp theo created_at mới nhất
        $items = $filter->valueFilters()->orderBy('created_at', 'desc')->get();
        
        $categories = Category::with('children')->where('parent_id', 0)->get();

        return view('admin.filter.edit', compact('categories', 'filter', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilterCateFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return redirect(route('filter.index'))->with(['message' => "Danh mục đã cập nhật thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insertOrUpdate(FilterCateFormRequest $request, $id = '')
    {
        $filter = empty($id) ? new FilterCate() : FilterCate::findOrFail($id);
        $slug = Str::slug($request->name, '-');
        
        $filter->fill($request->all());
        $filter->stt_filter = (isset($request->stt_filter)) ? $request->stt_filter : 999;
        $filter->slug = $slug;
        $parentId = Category::find($request->cate_id)->topLevelParent();
        $idCategory = $parentId->id;
        $filter->cate_id = $idCategory;

        $filter->save();
        
        $filterIds = [];
        
        if (!empty($filter->id)) {
            $filterIds[] = $filter->id;
            // Tìm danh mục cụ thể
            $checkCate = Category::where('id', $idCategory);
            $checkFilterCate = $checkCate->value('filter_ids');
            $cate = Category::findOrFail($idCategory);
            // Danh mục chưa có filter_ids tồn tại
            if (empty($checkFilterCate)) {
                $cate->update([
                    $cate['filter_ids'] = json_encode(array_map('strval', $filterIds)),
                ]);
            }
            if (!empty($checkFilterCate)) {
                $arr_current = $checkFilterCate;
                // Danh mục đã tồn tại filter_ids
                $arr_new = $filterIds;
                $arr = array_unique(array_merge(json_decode($arr_current), array_map('strval', $arr_new)));
                $cate->update([
                    $cate->filter_ids = json_encode($arr),
                ]);
            }
        }

        // $idFilter = [];
        $data = $request->only(['key_word', 'stt']);
        
        if (!empty($filter->id) && !empty($request->key_word)) {
            // Kiểm tra xem cả hai mảng có cùng kích thước hay không
            if (count($data['key_word']) === count($data['stt'])) {
                // Lặp qua các phần tử và lưu vào bảng filter
                for ($i = 0; $i < count($data['key_word']); $i++) {
                    Filter::create([
                        'filter_id' => $filter->id,
                        'key_word' => $data['key_word'][$i],
                        'search' => $slug . '-' . Str::slug($data['key_word'][$i], '-'),
                        // 'search' => Helper::convertToCamelCase($request->name),
                        'stt' => $data['stt'][$i]
                    ]);
                }
            }
        }
    }

    public function isCheckbox(Request $request)
    {
        $filter = FilterCate::find($request->id);
        if ($filter) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['is_direction', 'is_public'])) {
                $filter->$field = $value;

                $filter->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Field does not exist.']);
            }
        }
        return response()->json(['success' => false]);
    }

    public function checkStt(Request $request){
        $sttFilter = $request->input('stt_filter');
        if (!empty($sttFilter)) {
            $request->validate([
                'stt_filter' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $filter = FilterCate::findOrFail($id);
        $filter->stt_filter = (isset($sttFilter)) ? $sttFilter : 999;
        $filter->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật Stt thành công.']);
    }
}
