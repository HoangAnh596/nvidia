<?php

namespace App\Http\Controllers;

use App\Models\Favicon;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.favicon.add');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $favicon = Favicon::findOrFail(1);
        // dd($favicon);
        return view('admin.favicon.edit', compact('favicon'));
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
        $favicon = Favicon::findOrFail(1);

        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $favicon->image = $path;
        $favicon->save();

        return redirect('/admin')->with(['message' => 'Cập nhật hình ảnh favicon thành công']);
    }
}
