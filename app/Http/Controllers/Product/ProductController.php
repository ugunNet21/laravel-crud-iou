<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url',
        ]);

        $product = Product::create($request->all());

        return redirect()->route('products.show', $product->id);
    }

    public function show(Product $product)
    {
        $qrCode = QrCode::size(250)->generate($product->url);
        return view('products.show', compact('product', 'qrCode'));
    }
}
