@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome, Admin {{ Auth::user()->name }}!</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm">
                            <div class="font-bold">Pending Vendor Applications</div>
                            <div class="text-3xl font-extrabold">{{ $pendingVendorsCount }}</div>
                            <a href="{{ route('admin.vendors.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 block">View all vendor applications &rarr;</a>
                        </div>

                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md shadow-sm">
                            <div class="font-bold">Pending Product Approvals</div>
                            <div class="text-3xl font-extrabold">{{ $pendingProductsCount }}</div>
                            <a href="{{ route('admin.products.index') }}" class="text-yellow-600 hover:text-yellow-800 text-sm mt-2 block">View all product approvals &rarr;</a>
                        </div>

                        {{-- Add more admin statistics here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
