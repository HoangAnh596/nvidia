@extends('layouts.app')
@section('content')
<div class="card shadow mb-4">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Edit User</h1>
        </div>
        <form class="user" action="{{ route('users.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
        @method('PUT')    
        @csrf
            <div class="form-group row">
                <input type="text" name="name" class="form-control form-control-user" id="exampleFirstName" value="{{ $user->name }}">
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="1" <?php if ($user->role == '1') {
                            echo 'selected="selected"';
                        } ?>>Admin
                        </option>
                        <option value="0" <?php if ($user->role == '0') {
                            echo 'selected="selected"';
                        } ?>>User
                        </option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <img src="{{ \App\Http\Helpers\Helper::getPath($user->image) }}" alt="" style="width: 100px; height: 100px">
                    <label for="exampleFormControlFile1">Avatar</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image" >
                </div>
            </div>
            <div class="form-group">
                <input type="text" name="email"class="form-control form-control-user" id="exampleInputEmail" value="{{ $user->email }}">
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                </div>
                <div class="col-sm-6">
                <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
            <hr>
        </form>
    </div>
</div>
@endsection