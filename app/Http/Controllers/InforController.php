<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Requests\InforFormRequest;
use App\Models\Infor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InforController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $infors = Infor::where('name', 'like', "%" . Helper::escape_like($keyWord) . "%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.infor.index', compact('infors', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.infor.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InforFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('infors.index'))->with(['message' => 'Tạo mới thành công']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infor = Infor::findOrFail($id);

        return view('admin.infor.edit', compact('infor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InforFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công hotline !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Infor::findOrFail($id)->delete();

        return redirect('/infors')->with(['message' => 'Xóa hotline thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $infor = empty($id) ? new Infor() : Infor::findOrFail($id);

        $infor->fill($request->all());
        
        $infor->stt = (isset($request->stt)) ? $request->stt : 999;
        $infor->user_id = Auth::id();

        $infor->save();
    }

    public function checkStt(Request $request){
        $sttInfor = $request->input('stt');
        if (!empty($sttInfor)) {
            $request->validate([
                'stt' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $infor = Infor::findOrFail($id);
        $infor->stt = (isset($sttInfor)) ? $sttInfor : 999;
        $infor->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $infor = Infor::findOrFail($request->id);
        if ($infor) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['send_price', 'is_public'])) {
                $infor->$field = $value;

                $infor->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Không tồn tại.']);
            }
        }
        return response()->json(['success' => false]);
    }
}
