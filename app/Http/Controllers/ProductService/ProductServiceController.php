<?php

namespace App\Http\Controllers\ProductService;

use App\Http\Controllers\Controller;
use App\Models\ProductService\ProductService;
use Illuminate\Http\Request;

class ProductServiceController extends Controller
{
    public function index()
    {
        return ProductService::all();
    }

    public function store(Request $request)
    {
        $product = ProductService::create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return ProductService::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = ProductService::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        ProductService::destroy($id);
        return response()->json(null, 204);
    }
}
