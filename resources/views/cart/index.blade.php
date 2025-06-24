@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Shopping Cart') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    {{-- Session messages for success/error --}}
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (empty($detailedCartItems))
                        <div class="flex items-center justify-center h-48">
                            <p class="text-gray-500 text-lg">Your shopping cart is empty. Start adding some products!</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($detailedCartItems as $item)
                                        @php
                                            $product = $item['product'];
                                            $quantity = $item['quantity'];
                                            $itemPrice = $product->sale_price ?? $product->price;
                                            $subtotal = $itemPrice * $quantity;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if ($product->image)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                                    @else
                                                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/40x40/E5E7EB/1F2937?text=No+Img" alt="No Image">
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                        <div class="text-xs text-gray-500">By: {{ $product->user->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($itemPrice, 2) }}
                                                @if ($product->sale_price)
                                                    <span class="text-xs text-red-500 line-through block">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{-- Quantity Update Form --}}
                                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PATCH') {{-- Laravel uses PATCH for updates --}}
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="number" name="quantity" value="{{ $quantity }}" min="0" class="w-20 form-input rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <button type="submit" class="bg-indigo-500 text-white p-2 rounded-md hover:bg-indigo-600 transition duration-150 ease-in-out">Update</button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                                ${{ number_format($subtotal, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- Remove Item Form --}}
                                                <form action="{{ route('cart.remove') }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this product from your cart?');">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-right text-base font-bold text-gray-900">Total</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-base font-bold text-gray-900">${{ number_format($total, 2) }}</td>
                                        <td></td> {{-- Empty cell for the actions column --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Proceed to Checkout
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
