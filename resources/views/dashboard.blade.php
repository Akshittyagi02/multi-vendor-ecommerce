@extends('layouts.app') 

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    @auth
                        @if (Auth::user()->isAdmin())
                            <p class="mt-4 text-green-600">Welcome, Admin!</p>
                        @elseif (Auth::user()->hasRole('vendor') && Auth::user()->vendor && Auth::user()->vendor->is_approved)
                            <p class="mt-4 text-blue-600">Welcome, Approved Vendor!</p>
                        @elseif (Auth::user()->hasRole('vendor') && Auth::user()->vendor && !Auth::user()->vendor->is_approved)
                            <p class="mt-4 text-yellow-600">Your vendor application is pending approval.</p>
                        @else
                            <p class="mt-4 text-gray-600">Welcome, Customer!</p>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
