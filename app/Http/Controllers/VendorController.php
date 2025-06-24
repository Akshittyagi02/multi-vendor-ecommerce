<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // For file uploads
use Illuminate\Support\Str; // For slug generation
use App\Models\Vendor;

class VendorController extends Controller
{
    public function becomeVendorForm()
    {
        // Check if the user is already a vendor
        if (Auth::user()->hasRole('vendor')) {
            return redirect()->route('vendor.dashboard')->with('info', 'You are already a vendor.');
        }
        // Check if a vendor request is pending for this user (optional)
        if (Auth::user()->vendor()->exists() && !Auth::user()->vendor->is_approved) {
             return redirect()->route('dashboard')->with('info', 'Your vendor application is pending approval.');
        }

        return view('vendor.become-vendor');
    }

    public function storeVendorApplication(Request $request)
    {
        $request->validate([
            'shop_name' => ['required', 'string', 'max:255', 'unique:vendors,shop_name'],
            'shop_description' => ['nullable', 'string'],
            'shop_phone' => ['nullable', 'string', 'max:20'],
            'shop_address' => ['nullable', 'string', 'max:255'],
            'shop_banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = Auth::user();

        // Handle shop banner upload
        $bannerPath = null;
        if ($request->hasFile('shop_banner')) {
            $bannerPath = $request->file('shop_banner')->store('public/shop_banners');
            $bannerPath = str_replace('public/', 'storage/', $bannerPath); // Adjust path for public access
        }

        // Create vendor entry (initially unapproved)
        $vendor = Vendor::create([
            'user_id' => $user->id,
            'shop_name' => $request->shop_name,
            'shop_slug' => Str::slug($request->shop_name),
            'shop_description' => $request->shop_description,
            'shop_phone' => $request->shop_phone,
            'shop_address' => $request->shop_address,
            'shop_banner' => $bannerPath,
            'is_approved' => false, // Requires admin approval
        ]);

        // We don't assign 'vendor' role here directly. Admin will assign it upon approval.
        // Or, you can assign it here and remove upon disapproval if you prefer that flow.

        return redirect()->route('dashboard')->with('success', 'Your vendor application has been submitted and is awaiting admin approval!');
    }

    public function vendorDashboard()
    {
        // Only allow vendors to access this
        if (!Auth::user()->hasRole('vendor')) {
            return redirect()->route('dashboard')->with('error', 'Access Denied: You are not a registered vendor.');
        }

        $vendor = Auth::user()->vendor;
        if (!$vendor || !$vendor->is_approved) {
             return redirect()->route('dashboard')->with('error', 'Your vendor account is not yet approved by admin.');
        }

        // For now, just a simple view. Later, we'll add statistics.
        return view('vendor.dashboard', compact('vendor'));
    }
}