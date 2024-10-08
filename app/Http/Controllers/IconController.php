<?php

namespace App\Http\Controllers;

use App\Http\Requests\IconFormRequest;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $icons = Icon::where('name', 'like', "%$keyWord%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.icon.index', compact('icons', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.icon.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IconFormRequest $request)
    {
        try {
            $this->insertOrUpdate($request);
            // Lưu thông báo thành công vào session
            return redirect(route('icons.index'))->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            // Có lỗi xảy ra
            // Lưu thông báo lỗi vào session
            return redirect(route('icons.create'))->with('error', 'Cập nhật thất bại!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $icon = Icon::findOrFail($id);

        return view('admin.icon.edit', compact('icon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IconFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công Icon !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Icon::findOrFail($id)->delete();

        return redirect('admin/icons')->with(['message' => 'Xóa thành công']);
    }

    public function insertOrUpdate(IconFormRequest $request, $id = '')
    {
        $icon = empty($id) ? new Icon() : Icon::findOrFail($id);

        $icon->fill($request->all());

        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $icon->image = $path;
        $icon->stt = (isset($request->stt)) ? $request->stt : 999;
        $icon->user_id = Auth::id();

        $icon->save();
    }

    public function checkStt(Request $request){
        $sttIcon = $request->input('stt');
        if (!empty($sttIcon)) {
            $request->validate([
                'stt' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $icon = Icon::findOrFail($id);
        $icon->stt = (isset($sttIcon)) ? $sttIcon : 999;
        $icon->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $icon = Icon::findOrFail($request->id);
        $icon->is_public = $request->is_public;
        $icon->save();

        return response()->json(['success' => true]);
    }
}
