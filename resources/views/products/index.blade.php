@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('All Products') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-100"> {{-- Added a light gray background to the section --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> {{-- Stronger shadow for the main container --}}
                <div class="p-6 sm:p-8 text-gray-900"> {{-- Increased padding for larger screens --}}
                    @if ($products->isEmpty())
                        <div class="flex items-center justify-center h-48"> {{-- Centered and taller message --}}
                            <p class="text-gray-500 text-lg">No products available yet. Check back soon!</p>
                        </div>
                    @else
                        @if($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class ="close" data-dismiss="alert">x</button>
                                <strong>{{$message}}</strong>
                        
                            </div>

                        @endif



                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 xl:gap-8"> {{-- Increased gap for larger screens --}}
                            @foreach ($products as $product)
                                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-lg"> {{-- Rounded corners, shadow, and hover effects --}}
                                    <a href="{{ route('products.show', $product->slug) }}" class="block"> {{-- Made the image clickable --}}
                                        @if ($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110"> {{-- Image hover effect --}}
                                        @else
                                            <img src="https://placehold.co/400x300/E5E7EB/1F2937?text=No+Image" alt="No Image" class="w-full h-48 object-cover">
                                        @endif
                                    </a>
                                    <div class="p-4 flex flex-col flex-grow"> {{-- Added flex-grow for consistent card height --}}
                                        <h3 class="text-xl font-bold text-gray-900 mb-1 line-clamp-1"> {{-- Bolder and larger product name --}}
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 line-clamp-2 flex-grow mb-3"> {{-- Flex-grow for description --}}
                                            {{ $product->description }}
                                        </p>
                                        <div class="mt-auto"> {{-- Pushes price and stock to the bottom --}}
                                            <div class="flex items-baseline justify-between mb-2">
                                                @if ($product->sale_price)
                                                    <span class="text-2xl font-extrabold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="text-base text-gray-500 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="text-2xl font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                                <span class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">By: <span class="font-medium text-indigo-600">{{ $product->user->name }}</span></p>
                                        </div>
                                        <div class="mt-4">
                                            {{-- Add to Cart Form --}}
                                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1"> {{-- Default quantity --}}
                                                <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"> {{-- Enhanced button styling --}}
                                                    Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
