@extends('layouts.error')

@section('title', 'Access Denied')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-md overflow-hidden p-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-100 mb-6">
                <i class="fas fa-lock text-4xl text-red-600"></i>
            </div>
            
            <h1 class="text-3xl font-heading font-bold text-navy mb-2">Access Denied</h1>
            <p class="text-lg text-charcoal/70 mb-8">
                You don't have permission to access this page.
            </p>
            
            <div class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" 
                   class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-navy hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                    <i class="fas fa-home mr-2"></i> Return to Home
                </a>
                
                @auth
                <a href="{{ url()->previous() }}" 
                   class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                    <i class="fas fa-arrow-left mr-2"></i> Go Back
                </a>
                @endauth
                
                @guest
                <a href="{{ route('login') }}" 
                   class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
                @endguest
            </div>
        </div>
    </div>
    
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>
            If you believe this is an error, please contact support.
        </p>
    </div>
</div>
@endsection