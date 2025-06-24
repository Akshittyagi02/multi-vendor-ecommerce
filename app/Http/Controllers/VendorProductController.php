<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // For slug generation

class VendorProductController extends Controller
{
    // REMOVED: The public function __construct() method.
    // The middleware is handled directly in routes/web.php for the vendor route group.

    /**
     * Display a listing of the products for the authenticated vendor.
     */
    public function index()
    {
        // Only show products belonging to the authenticated vendor
        $products = Auth::user()->products()->orderBy('created_at', 'desc')->get();
        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('vendor.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|lt:price|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product = new Product($request->all());
        $product->user_id = Auth::id(); // Assign the product to the authenticated vendor

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = 'storage/' . $imagePath;
        }

        // Generate slug
        $product->slug = Str::slug($request->name);

        // Products are pending approval by default
        $product->is_approved = false;

        $product->save();

        return redirect()->route('vendor.products.index')->with('success', 'Product created successfully and is awaiting admin approval!');
    }

    /**
     * Display the specified product. (Optional for vendor, usually managed via index/edit)
     */
    public function show(Product $product)
    {
        // Ensure the product belongs to the authenticated user if direct access is allowed
        if ($product->user_id !== Auth::id()) {
            abort(403); // Forbidden
        }
        return view('vendor.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Ensure the product belongs to the authenticated user
        if ($product->user_id !== Auth::id()) {
            abort(403); // Forbidden
        }
        return view('vendor.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Ensure the product belongs to the authenticated user
        if ($product->user_id !== Auth::id()) {
            abort(403); // Forbidden
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|lt:price|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product->fill($request->all());

        // Handle image upload if a new one is provided
        if ($request->hasFile('image')) {
            // Optional: Delete old image if it exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = 'storage/' . $imagePath;
        }

        // Re-generate slug if name changed
        if ($product->isDirty('name')) {
            $product->slug = Str::slug($request->name);
        }

        // Product needs re-approval if critical fields are changed (e.g., name, price, description)
        // You might define which fields trigger re-approval, for simplicity, we'll assume any update might.
        if ($product->isDirty(['name', 'description', 'price', 'sale_price', 'stock_quantity'])) {
             $product->is_approved = false; // Mark for re-approval
        }

        $product->save();

        return redirect()->route('vendor.products.index')->with('success', 'Product updated successfully and is awaiting re-approval if changes require it!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Ensure the product belongs to the authenticated user
        if ($product->user_id !== Auth::id()) {
            abort(403); // Forbidden
        }

        // Optional: Delete product image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('vendor.products.index')->with('success', 'Product deleted successfully!');
    }
}
