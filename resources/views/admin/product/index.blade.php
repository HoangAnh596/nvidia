@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chi tiết sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Search of product" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="form-group">
                        <select name="cate" class="form-control">
                            <option value="">Category</option>
                            @if(isset($categories))
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ \Request::get('cate') == $category->id ? "selected ='selected'" : "" }}> {{ $category->name }} </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                <a href="{{ route('product.create') }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-circle-plus"></i> CREATE</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-1">No.</th>
                            <th class="col-sm-4">Name</th>
                            <th class="col-sm-3">Code</th>
                            <th class="col-sm-2">Image</th>
                            <th class="col-sm-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ (($products->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>
                                <img src="{{ \App\Http\Helpers\Helper::getPath($product->image) }}" class="img-fluid">
                            </td>
                            <td>
                                <a href="{{ asset('admin/products/'.$product->id.'/edit') }}" class="btn-sm">Chỉnh sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection