@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Vendor Dashboard') }} - {{ $vendor->shop_name }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Welcome to your Vendor Dashboard, {{ Auth::user()->name }}!</p>
                    @if (!$vendor->is_approved)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-4" role="alert">
                            <p class="font-bold">Pending Approval</p>
                            <p>Your shop application is currently pending admin approval. You will gain full access once approved.</p>
                        </div>
                    @else
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
                            <p class="font-bold">Shop Approved!</p>
                            <p>Your shop is now active and ready. Start adding products!</p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('vendor.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Manage Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
