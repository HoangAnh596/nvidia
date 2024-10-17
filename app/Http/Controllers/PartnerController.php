<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerFormRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function index() {
        $partners = Partner::latest()->paginate(10);
        return view('admin.partner.index', compact('partners'));
    }

    public function create() {
        return view('admin.partner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnerFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('partners.index'))->with(['message' => 'Tạo mới thành công']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);

        return view('admin.partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PartnerFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công danh mục footer !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Partner::findOrFail($id)->delete();

        return redirect(route('partners.index'))->with(['message' => 'Xóa thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $partner = empty($id) ? new Partner() : Partner::findOrFail($id);

        $partner->fill($request->all());

        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $partner->image = $path;
        $partner->stt = (isset($request->stt)) ? $request->stt : 999;
        $partner->user_id = Auth::id();
        
        $partner->save();
    }

    public function checkStt(Request $request){
        $sttPartner = $request->input('stt');
        if (!empty($sttPartner)) {
            $request->validate([
                'stt' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $partner = Partner::findOrFail($id);
        $partner->stt = (isset($sttPartner)) ? $sttPartner : 999;
        $partner->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $partner = Partner::findOrFail($request->id);

        if ($partner) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['is_tab', 'is_public'])) {
                $partner->$field = $value;

                $partner->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Không tồn tại.']);
            }
        }
        return response()->json(['success' => false]);
    }
}
