<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->module_parent, // ví dụ: category
            'display_name' => array_search($request->module_parent, config('permissions.table_module')), // Lấy key tương ứng với module_parent để làm display_name
            'parent_id' => 0
        ]);

        $moduleChildrentConfig = config('permissions.module_childrent'); // Lấy mảng từ file cấu hình

        foreach ($request->module_childrent as $value) {
            // Tìm key (nhãn) tương ứng với giá trị hiện tại
            $name = array_search($value, $moduleChildrentConfig);

            Permission::create([
                'name' => $value, // Sử dụng nhãn từ cấu hình
                'display_name' => $name, // Sử dụng nhãn từ cấu hình
                'parent_id' => $permission->id,
                'key_code' => $value . '_' . $request->module_parent
            ]);
        }

        return back()->with(['message' => "Thêm mới thành công !"]);
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
        //
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
        //
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
}
