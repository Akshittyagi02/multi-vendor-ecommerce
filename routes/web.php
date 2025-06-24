<?php

use Intervention\Image\ImageManagerStatic; // This seems to be from your custom test route, keep for now
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Ensure Auth facade is used
use App\Models\User;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Session; // Needed for Session::put
use Illuminate\Support\Facades\App; // Needed for App::setLocale
use Spatie\Permission\Models\Role;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Language Switcher Route
Route::get('lang/{lang}', function (string $lang) {
    $allowedLanguages = ['en', 'es', 'fr', 'hi']; // Define allowed languages

    if (in_array($lang, $allowedLanguages)) {
        Session::put('locale', $lang); // Store in session
        App::setLocale($lang); // Set for current request
    }
    return redirect()->back();
})->name('lang.switch');

// Publicly accessible product listing
Route::get('/', [ProductListController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductListController::class, 'show'])->name('products.show');

// Cart and Wishlist Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update'); // Route for updating cart quantities
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove'); // Route for removing items
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

// Removed the problematic qty-increment and qty-decrement routes
// Route::get('qty-increment/{rowId}',[CartController::class, 'qty-Increment'])->name('qty-increment');
// Route::get('qty-decrement/{rowId}',[CartController::class, 'qty-Decrement'])->name('qty-decrement');

// New route for testing user table and image processing (assuming ImageManagerStatic is set up)
Route::get('/image', function(Request $request){ // Added Request type-hint
    // Ensure you have a 'public' disk configured in config/filesystems.php
    // And that the image 'OIP.jpg' exists in a location accessible by ImageManagerStatic
    // This part of the code needs a proper file path or file upload to work.
    // For local testing, ensure 'OIP.jpg' is in the public directory or handle it as an upload.
    try {
        // Example: If OIP.jpg is in the public directory
        $imagePath = public_path('OIP.jpg');
        if (file_exists($imagePath)) {
            $img = ImageManagerStatic::make($imagePath);
            $img->crop(400, 400);
            $img->save(public_path('OIP1.jpg'), 80);
            return "Image processed and saved as OIP1.jpg";
        } else {
            return "OIP.jpg not found in public directory.";
        }
    } catch (\Exception $e) {
        return "Error processing image: " . $e->getMessage();
    }
})->name('image.process'); // Added a name for clarity

Route::get('/test', function(UsersDataTable $dataTable){
    return $dataTable->render('test');
})->name('test');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        // If user is an admin, redirect to admin dashboard
        if ($user->isAdmin()) { // Using isAdmin() helper defined in User model
            return redirect()->route('admin.dashboard');
        }
        // If user is a vendor and approved, redirect to vendor dashboard
        if ($user->hasRole('vendor') && $user->vendor && $user->vendor->is_approved) {
            return redirect()->route('vendor.dashboard');
        }
        // Default dashboard for customers or pending vendors
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vendor Application Routes
    Route::get('/become-vendor', [VendorController::class, 'becomeVendorForm'])->name('vendor.become-vendor');
    Route::post('/become-vendor', [VendorController::class, 'storeVendorApplication'])->name('vendor.store-application');

    // Vendor Specific Routes (protected by vendor role and approval status)
    Route::middleware('can:vendor')->prefix('vendor')->name('vendor.')->group(function () { // Changed back to 'can:vendor' for consistency with Gate
        Route::get('/dashboard', [VendorController::class, 'vendorDashboard'])->name('dashboard');

        // Product Management Routes
        Route::resource('products', VendorProductController::class);
    });

    // Admin Specific Routes (protected by 'admin' gate)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Vendor Management
        Route::get('/vendors', [AdminController::class, 'vendors'])->name('vendors.index');
        Route::post('/vendors/{vendor}/approve', [AdminController::class, 'approveVendor'])->name('vendors.approve');
        Route::post('/vendors/{vendor}/disapprove', [AdminController::class, 'disapproveVendor'])->name('vendors.disapprove');

        // Product Management
        Route::get('/products', [AdminController::class, 'products'])->name('products.index');
        Route::post('/products/{product}/approve', [AdminController::class, 'approveProduct'])->name('products.approve');
        Route::post('/products/{product}/disapprove', [AdminController::class, 'disapproveProduct'])->name('products.disapprove');
    });
});

require __DIR__.'/auth.php';
