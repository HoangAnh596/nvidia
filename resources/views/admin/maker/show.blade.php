@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-2 text-gray-800">Detail Makers</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <a href="{{ route('makers.index') }}" class="btn btn-danger">Back</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $maker->id }}</td>
                            <td>{{ $maker->code }}</td>
                            <td>{{ $maker->name }}</td>
                            <td><img src="{{ asset(\App\Http\Helpers\Helper::getPath('makers',$maker->image)) }}" alt="" style="width: 100px; height: 100px"></td>
                            <td>
                                <a class="btn btn-primary" href="{{ asset('admin/makers/'.$maker->id.'/edit') }}"><i class="fa fa-edit"></i> Edit</a>
                                <form action="{{ route('makers.destroy', ['maker' => $maker->id]) }}" method="post">
                                    @csrf
                                    @method('Delete')
                                    <input type="submit" class="btn btn-success" value="Delete" onclick="return confirm('Do you really want to delete?')" />
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection