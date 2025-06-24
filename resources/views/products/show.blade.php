@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                            @else
                                <img src="https://placehold.co/600x400/E5E7EB/1F2937?text=No+Image" alt="No Image" class="w-full h-auto object-cover rounded-lg shadow-md">
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                            <p class="text-gray-600 mt-2 text-sm">By <a href="#" class="text-indigo-600 hover:underline">{{ $product->user->name }}</a> (Vendor)</p>

                            <div class="mt-4 flex items-baseline">
                                @if ($product->sale_price)
                                    <span class="text-4xl font-extrabold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="text-lg text-gray-500 line-through ml-3">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="text-4xl font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <p class="mt-4 text-lg text-gray-800">{{ $product->description }}</p>

                            <div class="mt-6">
                                <p class="text-md font-semibold text-gray-700">Available Stock: {{ $product->stock_quantity }}</p>
                            </div>

                            <div class="mt-8">
                                <!-- Add to Cart button would go here -->
                                <button class="w-full bg-indigo-600 text-white py-3 px-6 rounded-md text-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
@endsection
