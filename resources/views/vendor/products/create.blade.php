@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add New Product') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">
                                {{ __('Product Name') }}
                            </label>
                            <input id="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                            @error('name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Description -->
                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">
                                {{ __('Description') }}
                            </label>
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Main Image -->
                        <div class="mt-4">
                            <label for="image" class="block font-medium text-sm text-gray-700">
                                {{ __('Product Image (Optional)') }}
                            </label>
                            <input id="image" type="file" name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG or GIF (MAX. 2MB).</p>
                            @error('image')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <label for="price" class="block font-medium text-sm text-gray-700">
                                {{ __('Price') }}
                            </label>
                            <input id="price" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" step="0.01" name="price" value="{{ old('price') }}" required />
                            @error('price')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sale Price -->
                        <div class="mt-4">
                            <label for="sale_price" class="block font-medium text-sm text-gray-700">
                                {{ __('Sale Price (Optional)') }}
                            </label>
                            <input id="sale_price" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" />
                            @error('sale_price')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="mt-4">
                            <label for="stock_quantity" class="block font-medium text-sm text-gray-700">
                                {{ __('Stock Quantity') }}
                            </label>
                            <input id="stock_quantity" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="stock_quantity" value="{{ old('stock_quantity') }}" required />
                            @error('stock_quantity')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Add Product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
