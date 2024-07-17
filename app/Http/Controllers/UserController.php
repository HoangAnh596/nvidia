<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Helpers\Helper;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $users = user::where('name', 'like', "%" . Helper::escape_like($keyWord) . "%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.users.index', compact('users', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'role' => $request->role,
            'password' => Hash::make($request->passwordd)
        ]);

        if ($request->hasFile('image')) {
            $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
            $imagePath = $request->image->storeAs(config('common.default_image_path') . 'users', $newFileName);
            $user->image = str_replace(config('common.default_image_path') . 'users', '', $imagePath);
        }
        $user->save();
        event(new Registered($user));

        return redirect('admin/users')->with(['message' => 'Tạo mới thành công']);
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
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->fill([
            'email' => $request->email,
            'name' => $request->name,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        if ($request->hasFile('image')) {
            $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
            $imagePath = $request->image->storeAs(config('common.default_image_path') . 'users', $newFileName);
            $user->image = str_replace(config('common.default_image_path') . 'users', '', $imagePath);
        }
        $user->save();

        return redirect('admin/users')->with(['message' => 'Cập nhật thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with(['message' => 'Xóa tài khoản thành công']);
    }
}
