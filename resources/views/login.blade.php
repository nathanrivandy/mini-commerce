    @extends('app')

    @section('title', 'Masuk - Mini Commerce')

    @section('content')
        <div class="min-h-screen bg-[#F9CDD5] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <!-- Sakura Decorations -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Sakura di kiri atas -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-10 left-10 w-20 h-20 opacity-30 animate-pulse">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-32 left-32 w-16 h-16 opacity-20 animate-pulse" 
             style="animation-delay: 0.5s;">
        
        <!-- Sakura di kanan atas -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-16 right-16 w-24 h-24 opacity-50 animate-pulse" 
             style="animation-delay: 1s;">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-40 right-40 w-14 h-14 opacity-50 animate-pulse" 
             style="animation-delay: 1.5s;">
        
         <!-- Sakura di kiri bawah -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-20 left-24 w-20 h-20 opacity-50 animate-pulse" 
             style="animation-delay: 1.2s;">
             
        <!-- Sakura di kanan bawah -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-20 right-24 w-20 h-20 opacity-50 animate-pulse" 
             style="animation-delay: 1.2s;">
    </div>

        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="bg-[#B83556] rounded-full p-4"> 
                        <i class="fas fa-store text-white text-3xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Selamat Datang Kembali
                </h2>
                <p class="text-gray-600">
                    Masuk ke akun Mini Commerce Anda
                </p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form method="POST" action="{{ route('auth.login.post') }}" class="space-y-6">
                    @csrf
                    
                   <!-- Email Field -->
<div>
    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-envelope mr-2 text-[#B83556]"></i>Email
    </label>
    <input id="email" 
           name="email" 
           type="email" 
           value="{{ old('email') }}"
           required 
           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors @error('email') border-red-500 @enderror"
           placeholder="Masukkan email Anda">
    @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Password Field -->
<div>
    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-lock mr-2 text-[#B83556]"></i>Password
    </label>
    <div class="relative">
        <input id="password" 
               name="password" 
               type="password" 
               required 
               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors @error('password') border-red-500 @enderror"
               placeholder="Masukkan password Anda">
        <button type="button" 
                onclick="togglePassword()" 
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
            <i id="password-icon" class="fas fa-eye"></i>
        </button>
    </div>
    @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>


                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                        <input id="remember" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-[#B83556] focus:ring-[#B83556] border-gray-300 rounded">
<label for="remember" class="ml-2 text-sm text-gray-700">
    Ingat saya
</label>

                        </div>
                        <a href="#" class="text-sm text-[#B83556] hover:text-[#B83556] font-medium">Lupa password?
</a>

                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-[#B83556] text-white py-3 px-4 rounded-lg font-semibold hover:bg-[#FF9CBF] focus:outline-none focus:ring-2 focus:ring-[#10B981] focus:ring-offset-2 transition-colors hover:text-[#B83556]">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
        </button>

                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau</span>
                        </div>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('auth.register') }}" class="font-medium text-[#B83556] hover:text-[#B83556] transition-colors">
    Daftar sekarang
</a>

                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-[#B83556] hover:text-[#B83556] font-medium transition-colors">
    <i class="fas fa-arrow-left mr-2"></i>
    Kembali ke Beranda
</a>

                </a>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

    // Auto-hide error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessages = document.querySelectorAll('.text-red-600');
        errorMessages.forEach(function(message) {
            setTimeout(function() {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.style.display = 'none';
                }, 500);
            }, 5000);
        });
    });
    </script>
    @endpush
