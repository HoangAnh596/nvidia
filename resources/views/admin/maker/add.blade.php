@extends('layouts.app')
@section('content')
<div class="card shadow">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Create maker</h1>
        </div>
        <form class="user" action="{{ route('makers.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <input type="text" name="name" class="form-control form-control-user" id="exampleFirstName" placeholder="Name">
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name="code" class="form-control form-control-user"  placeholder="Code">
                </div>
                <div class="col-sm-6">
                    <label for="exampleFormControlFile1">Avatar</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
            <hr>
        </form>
    </div>
</div>
@endsection