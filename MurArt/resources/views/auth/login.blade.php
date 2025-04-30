@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-pattern">
    <div class="flex w-full max-w-[1200px] h-[600px] mx-4">
        <!-- Left Side - Wallpaper Preview -->
        <div class="hidden md:block w-2/3 bg-cover bg-center rounded-l-2xl overflow-hidden">
            <img src="{{ asset('imgs/4cda7b45d1b5c13919ef12f1fc20034f.jpg') }}" 
                 alt="Decorative Wallpaper" 
                 class="w-full h-full object-cover">
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full md:w-1/3 bg-white rounded-2xl md:rounded-l-none md:rounded-r-2xl shadow-xl p-8 flex flex-col justify-between">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Wall<span class="text-blue-600">Art</span></h1>
            </div>

            <div class="flex justify-center gap-8 mb-6">
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold border-b-2 border-blue-600 pb-1">Login</a>
                <a href="{{ route('register') }}" class="text-gray-400 hover:text-gray-600 transition-colors">Sign Up</a>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           placeholder="Enter your email"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           placeholder="Enter your password"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>
                    {{-- <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">Forgot Password?</a> --}}
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Login
                </button>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or login with</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3">
                    <button class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fab fa-google text-xl text-gray-600"></i>
                    </button>
                    <button class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fab fa-facebook-f text-xl text-gray-600"></i>
                    </button>
                    <button class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fab fa-linkedin-in text-xl text-gray-600"></i>
                    </button>
                </div>
            </div>

            <p class="text-center text-sm text-gray-600 mt-6">
                By continuing, you agree to WallArt's <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
            </p>
        </div>
    </div>
</div>

<style>
.bg-pattern {
    background-color: #f3f4f6;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239CA3AF' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
</style>
@endsection