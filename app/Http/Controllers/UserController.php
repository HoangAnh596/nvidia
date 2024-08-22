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
        $keyword = $request->keyword;
        $role = $request->role;
        
        $userQuery = User::where(function($query) use ($keyword) {
            $query->where('name', 'like', "%" . Helper::escape_like($keyword) . "%")
                  ->orWhere('email', 'like', "%" . Helper::escape_like($keyword) . "%");
        });
        if ($role !== null && $role !== '') {
            $userQuery->where('role', $role);
        }

        $users = $userQuery->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));

        

        return view('admin.users.index', compact('users', 'keyword'));
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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [

        ]);

        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
            $imagePath = $request->image->storeAs(config('common.default_image_user') . 'public/images/tai-khoan', $newFileName);
            $data['image'] = str_replace('public', 'storage', $imagePath);
        }

        $user->update($data);

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
