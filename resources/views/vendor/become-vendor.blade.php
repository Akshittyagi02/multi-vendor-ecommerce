@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Become a Vendor') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Submit Your Vendor Application</h3>

                    <form method="POST" action="{{ route('vendor.store-application') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Shop Name -->
                        <div>
                            <label for="shop_name" class="block font-medium text-sm text-gray-700">
                                {{ __('Shop Name') }}
                            </label>
                            <input id="shop_name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="text" name="shop_name" value="{{ old('shop_name') }}" required autofocus />
                            @error('shop_name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shop Description -->
                        <div class="mt-4">
                            <label for="shop_description" class="block font-medium text-sm text-gray-700">
                                {{ __('Shop Description') }}
                            </label>
                            <textarea id="shop_description" name="shop_description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('shop_description') }}</textarea>
                            @error('shop_description')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shop Phone -->
                        <div class="mt-4">
                            <label for="shop_phone" class="block font-medium text-sm text-gray-700">
                                {{ __('Shop Phone') }}
                            </label>
                            <input id="shop_phone" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="text" name="shop_phone" value="{{ old('shop_phone') }}" />
                            @error('shop_phone')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shop Address -->
                        <div class="mt-4">
                            <label for="shop_address" class="block font-medium text-sm text-gray-700">
                                {{ __('Shop Address') }}
                            </label>
                            <input id="shop_address" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="text" name="shop_address" value="{{ old('shop_address') }}" />
                            @error('shop_address')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shop Banner -->
                        <div class="mt-4">
                            <label for="shop_banner" class="block font-medium text-sm text-gray-700">
                                {{ __('Shop Banner (Optional)') }}
                            </label>
                            <input id="shop_banner" type="file" name="shop_banner" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG or GIF (MAX. 2MB).</p>
                            @error('shop_banner')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Submit Application') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
