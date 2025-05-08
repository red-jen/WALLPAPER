@extends('layouts.app')

@section('title', 'Authentication')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-pattern">
    <div class="flex w-full max-w-[1200px] h-[700px] mx-4">
        <!-- Left Side - Wallpaper Preview -->
        <div class="hidden md:block w-2/3 bg-cover bg-center rounded-l-2xl overflow-hidden relative">
            <!-- Logo -->
            <img src="{{ asset('imgs/logo.png') }}" 
                 alt="MurArt Logo" 
                 class="absolute top-4 left-4 h-14 z-10">
                 
            <!-- Main background image - now using venice image -->
            <img src="{{ asset('imgs/venice (1).jpg') }}" 
                 alt="Decorative Wallpaper" 
                 class="w-full h-full object-cover">
                 
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
            
            <div class="absolute bottom-10 left-10 text-white z-10 max-w-lg">
                <h2 class="text-3xl font-bold mb-3">Transform your walls into works of art</h2>
                <p class="text-lg text-gray-200">Join MurArt and discover a world of custom wallpaper designs created by talented artists.</p>
            </div>
        </div>

        <!-- Right Side - Auth Form -->
        <div class="w-full md:w-1/3 bg-white rounded-2xl md:rounded-l-none md:rounded-r-2xl shadow-xl p-8 flex flex-col justify-between relative">
            <div class="text-center mb-6">
                <img src="{{ asset('imgs/logo.png') }}" alt="MurArt Logo" class="h-16 mx-auto mb-4">
            </div>

            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary bg-opacity-5 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 right-0 w-24 h-24 bg-secondary bg-opacity-5 rounded-full -mr-12 -mb-12"></div>

            <div class="flex justify-center gap-8 mb-6">
                <button id="loginTab" class="text-primary font-semibold border-b-2 border-primary pb-1">Login</button>
                <button id="registerTab" class="text-gray-400 hover:text-gray-600 transition-colors">Sign Up</button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="login_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" 
                           id="login_email" 
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
                    <label for="login_password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" 
                           id="login_password" 
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
                </div>

                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-opacity-90 transition-colors">
                    Login
                </button>
            </form>

            <!-- Register Form -->
            <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-6 hidden">
                @csrf
                
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           placeholder="Enter your full name"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="register_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" 
                           id="register_email" 
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
                    <label class="block text-sm font-medium text-gray-700">I am a</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                            <input type="radio" 
                                   name="role" 
                                   value="client" 
                                   class="sr-only" 
                                   {{ old('role', 'client') == 'client' ? 'checked' : '' }}>
                            <span class="flex flex-1 items-center justify-center">
                                <span class="flex flex-col items-center">
                                    <i class="fas fa-user text-xl mb-1"></i>
                                    <span class="block text-sm font-medium">Client</span>
                                </span>
                            </span>
                            <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
                        </label>

                        <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                            <input type="radio" 
                                   name="role" 
                                   value="designer" 
                                   class="sr-only" 
                                   {{ old('role') == 'designer' ? 'checked' : '' }}>
                            <span class="flex flex-1 items-center justify-center">
                                <span class="flex flex-col items-center">
                                    <i class="fas fa-paint-brush text-xl mb-1"></i>
                                    <span class="block text-sm font-medium">Designer</span>
                                </span>
                            </span>
                            <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
                        </label>
                    </div>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="register_password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" 
                           id="register_password" 
                           name="password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           placeholder="Create a password"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                           placeholder="Confirm your password"
                           required>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms" 
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                               required>
                    </div>
                    <label for="terms" class="ml-2 block text-sm text-gray-600">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-opacity-90 transition-colors">
                    Create Account
                </button>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
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
        </div>
    </div>
</div>

<style>
.bg-pattern {
    background-color: #f3f4f6;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239CA3AF' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* Custom radio button styles */
input[type="radio"]:checked + span span i {
    color: var(--primary-color);
}

input[type="radio"]:checked + span + span {
    border-color: var(--primary-color);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    // Function to switch between forms
    function switchForm(isLogin) {
        if (isLogin) {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginTab.classList.add('text-primary', 'border-b-2', 'border-primary');
            loginTab.classList.remove('text-gray-400');
            registerTab.classList.remove('text-primary', 'border-b-2', 'border-primary');
            registerTab.classList.add('text-gray-400');
        } else {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            registerTab.classList.add('text-primary', 'border-b-2', 'border-primary');
            registerTab.classList.remove('text-gray-400');
            loginTab.classList.remove('text-primary', 'border-b-2', 'border-primary');
            loginTab.classList.add('text-gray-400');
        }
    }

    // Event listeners for tab switching
    loginTab.addEventListener('click', () => switchForm(true));
    registerTab.addEventListener('click', () => switchForm(false));

    // Role selection highlight
    const roleInputs = document.querySelectorAll('input[name="role"]');
    roleInputs.forEach(input => {
        input.addEventListener('change', function() {
            roleInputs.forEach(ri => {
                const border = ri.parentElement.querySelector('span:last-child');
                if (ri.checked) {
                    border.classList.add('border-primary');
                    ri.parentElement.querySelector('i').classList.add('text-primary');
                } else {
                    border.classList.remove('border-primary');
                    ri.parentElement.querySelector('i').classList.remove('text-primary');
                }
            });
        });
    });
});
</script>
@endsection