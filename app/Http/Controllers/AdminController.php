<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\User; // To assign vendor role

class AdminController extends Controller
{
    // REMOVED: The public function __construct() method that applied middleware.
    // Authorization for admin routes is now handled by the 'can:admin' middleware
    // defined in routes/web.php and the 'admin' Gate in AuthServiceProvider.php.

    public function dashboard()
    {
        $pendingVendorsCount = Vendor::where('is_approved', false)->count();
        $pendingProductsCount = Product::where('is_approved', false)->count();
           
        return view('admin.dashboard', compact('pendingVendorsCount', 'pendingProductsCount'));
    }

    public function vendors()
    {
        $vendors = Vendor::with('user')->orderBy('is_approved')->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function approveVendor(Vendor $vendor)
    {
        $vendor->update(['is_approved' => true]);
        // Assign the 'vendor' role to the associated user
        $vendor->user->assignRole('vendor');

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor "' . $vendor->shop_name . '" approved successfully!');
    }

    public function disapproveVendor(Vendor $vendor)
    {
        // Remove 'vendor' role and set to unapproved
        $vendor->update(['is_approved' => false]);
        $vendor->user->removeRole('vendor');
        // Optionally, also unapprove all their products
        $vendor->products()->update(['is_approved' => false]);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor "' . $vendor->shop_name . '" disapproved and their products unapproved.');
    }

    public function products()
    {
        $products = Product::with('user')->orderBy('is_approved')->get();
        return view('admin.products.index', compact('products'));
    }

    public function approveProduct(Product $product)
    {
        $product->update(['is_approved' => true]);
        return redirect()->route('admin.products.index')->with('success', 'Product "' . $product->name . '" approved successfully!');
    }

    public function disapproveProduct(Product $product)
    {
        $product->update(['is_approved' => false]);
        return redirect()->route('admin.products.index')->with('success', 'Product "' . $product->name . '" disapproved.');
    }
}
