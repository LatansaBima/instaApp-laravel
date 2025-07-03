@extends('auth.layout.auth')

@section('auth')
<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 to-pink-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo and Title -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">InstaAPP</h1>
            <p class="text-gray-600">Sign in to see photos and videos from your friends</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="ri-check-line text-green-600 mr-2"></i>
                    <span class="text-green-800 text-sm">{{ session('success') }}</span>
                </div>
            </div>
            @endif
            
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="ri-error-warning-line text-red-600 mr-2"></i>
                    <span class="text-red-800 text-sm">{{ session('error') }}</span>
                </div>
            </div>
            @endif
            
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="ri-error-warning-line text-red-600 mr-2"></i>
                    <span class="text-red-800 text-sm font-medium">Please fix the following errors:</span>
                </div>
                <ul class="text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="flex items-center">
                        <i class="ri-subtract-line text-red-500 mr-2 text-xs"></i>
                        {{ $error }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login.authenticate')}}" method="POST" class="space-y-6">
                @csrf
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-mail-line text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-gray-900 placeholder-gray-500" 
                            placeholder="Enter your email" 
                            required 
                        />
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-lock-line text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-gray-900 placeholder-gray-500" 
                            placeholder="Enter your password" 
                            required 
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="ri-eye-off-line" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105"
                >
                    <i class="ri-login-circle-line mr-2"></i>
                    Sign In
                </button>
            </form>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <p class="text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-medium text-purple-600 hover:text-purple-500 transition-colors duration-200">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>

<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.className = 'ri-eye-line';
    } else {
        passwordField.type = 'password';
        toggleIcon.className = 'ri-eye-off-line';
    }
}
</script>
@endsection