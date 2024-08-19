<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->input('name');
        // dd($name);
        $productTag = ProductTag::create(
            ['name' => $name],
        );
        // dd($productTag);
        return response()->json($productTag);
    }
}
