@extends('layouts.app')
@section('content')
<div class="card shadow mb-4">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Edit Maker</h1>
        </div>
        <form class="makers" action="{{ route('makers.update', ['maker' => $maker->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group row">
                <input type="text" name="name" value="{{ $maker->name }}" class="form-control form-control-user" placeholder="Name">
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="code" value="{{ $maker->code }}" class="form-control form-control-user" placeholder="Code">
                </div>
                <div class="col-sm-6">
                <img src="{{ asset(\App\Http\Helpers\Helper::getPath('makers',$maker->image)) }}" style="width: 100px; height: 100px">
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