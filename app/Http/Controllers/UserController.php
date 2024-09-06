<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Helpers\Helper;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $role;
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $role = $request->role;

        $userQuery = User::where(function ($query) use ($keyword) {
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
        $roles = $this->role->all();

        return view('admin.users.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        try {
            // Bengin transaction
            DB::beginTransaction();

            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password)
            ]);

            if ($request->hasFile('image')) {
                $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
                $imagePath = $request->image->storeAs(config('common.default_image_path') . 'users', $newFileName);
                $user->image = str_replace(config('common.default_image_path') . 'users', '', $imagePath);
            }

            $user->save();
            $user->roles()->attach($request->role_id);
            event(new Registered($user));

            DB::commit();

            return redirect('admin/users')->with(['message' => 'Tạo mới thành công']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--- Line: ' . $e->getLine());
            // Xử lý lỗi (có thể ghi log, hiển thị thông báo lỗi, ...)
            return redirect()->back()->with(['error' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.']);
        }
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
        $roles = $this->role->all();

        return view('admin.users.edit', compact('user', 'roles'));
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
        try {
            // Bengin transaction
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ], []);

            $data = $request->only(['name', 'email']);
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
                $imagePath = $request->image->storeAs(config('common.default_image_user') . 'public/images/tai-khoan', $newFileName);
                $data['image'] = str_replace('public', 'storage', $imagePath);
            }

            $user->update($data);
            $user->roles()->sync($request->role_id);

            DB::commit();

            return back()->with(['message' => 'Cập nhật thành công']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--- Line: ' . $e->getLine());
            // Xử lý lỗi (có thể ghi log, hiển thị thông báo lỗi, ...)
            return redirect()->back()->with(['error' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Xóa tất cả các quan hệ vai trò của người dùng trong bảng role_user
        $user->roles()->detach();

        // Xóa người dùng
        $user->delete();

        return redirect()->back()->with(['message' => 'Xóa tài khoản thành công']);
    }
}
