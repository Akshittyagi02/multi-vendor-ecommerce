<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // Import Product model
use Illuminate\Support\Facades\Session; // Ensure Session facade is imported

class CartController extends Controller
{
    /**
     * Display the shopping cart contents.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);

        $detailedCartItems = [];
        foreach ($cartItems as $productId => $itemData) {
            // Handle potentially malformed old session data by checking if $itemData is an array
            if (is_array($itemData) && isset($itemData['quantity'])) {
                $quantity = (int) $itemData['quantity'];
            } else {
                $quantity = (int) $itemData; // Expected scalar quantity
            }

            $productId = (int) $productId;

            $product = Product::find($productId);

            if ($product) {
                $itemPrice = (float) ($product->sale_price ?? $product->price);
                $subtotal = $itemPrice * $quantity;

                $detailedCartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            } else {
                // If product not found (e.g., deleted), remove from session cart
                unset($cartItems[$productId]);
                Session::put('cart', $cartItems);
                // Optionally log this: \Log::warning("Product ID {$productId} in cart not found in DB. Removed.");
            }
        }

        return view('cart.index', compact('detailedCartItems'));
    }

    /**
     * Add a product to the shopping cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = (int) $request->product_id;
        $quantity = (int) $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Update the quantity of a product in the shopping cart.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0', // Allows 0 to remove item
        ]);

        $productId = (int) $request->product_id;
        $quantity = (int) $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]); // Remove item if quantity is 0 or less
                $message = 'Product removed from cart.';
            } else {
                $cart[$productId] = $quantity; // Update quantity
                $message = 'Cart quantity updated.';
            }
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', $message);
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
    }

    /**
     * Remove a product from the shopping cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = (int) $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
    }
}
