<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductListController extends Controller
{
    public function index()
    {
        // Only fetch products that are approved by the admin
        $products = Product::where('is_approved', true)
                           ->orderBy('created_at', 'desc')
                           ->get();
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Ensure the product is approved before showing details
        if (!$product->is_approved) {
            abort(404); // Or redirect to a "product not found/unavailable" page
        }
        return view('products.show', compact('product'));
    }
}