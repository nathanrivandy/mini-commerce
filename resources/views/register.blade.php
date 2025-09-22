@extends('app')

@section('title', 'Daftar - Mini Commerce')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="bg-primary-600 rounded-full p-4">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                Bergabung dengan Kami
            </h2>
            <p class="text-gray-600">
                Buat akun baru di Mini Commerce untuk mulai berbelanja
            </p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('auth.register.post') }}" class="space-y-6">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-primary-600"></i>Nama Lengkap
                    </label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           value="{{ old('name') }}"
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap Anda">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-primary-600"></i>Email
                    </label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           value="{{ old('email') }}"
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors @error('email') border-red-500 @enderror"
                           placeholder="Masukkan email Anda">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-primary-600"></i>Password
                    </label>
                    <div class="relative">
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors @error('password') border-red-500 @enderror"
                               placeholder="Masukkan password Anda">
                        <button type="button" 
                                onclick="togglePassword('password')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-primary-600"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               required 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors @error('password_confirmation') border-red-500 @enderror"
                               placeholder="Konfirmasi password Anda">
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <i id="password_confirmation-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
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

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('auth.login') }}" 
                       class="font-medium text-primary-600 hover:text-primary-700 transition-colors">
                        Masuk sekarang
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const passwordIcon = document.getElementById(fieldId + '-icon');
    
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



// Confirm password validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    // Create match indicator if doesn't exist
    if (!document.getElementById('password-match')) {
        const matchDiv = document.createElement('div');
        matchDiv.id = 'password-match';
        matchDiv.className = 'mt-1 text-xs';
        this.parentNode.parentNode.appendChild(matchDiv);
    }
    
    const matchIndicator = document.getElementById('password-match');
    
    // Hide indicator if either field is empty
    if (confirmPassword.length === 0 || password.length === 0) {
        matchIndicator.innerHTML = '';
        this.classList.remove('border-red-500', 'border-green-500');
        return;
    }
    
    if (password === confirmPassword) {
        matchIndicator.innerHTML = '<span style="color: #059669 !important; font-weight: 500;"><i class="fas fa-check mr-1"></i>Password cocok</span>';
        this.classList.remove('border-red-500');
        this.classList.add('border-green-500');
    } else {
        matchIndicator.innerHTML = '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Password tidak cocok</span>';
        this.classList.remove('border-green-500');
        this.classList.add('border-red-500');
    }
});

// Also add validation for password field
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    const matchIndicator = document.getElementById('password-match');
    
    // Hide indicator if either field is empty
    if (password.length === 0 || confirmPassword.length === 0) {
        if (matchIndicator) {
            matchIndicator.innerHTML = '';
        }
        const confirmField = document.getElementById('password_confirmation');
        confirmField.classList.remove('border-red-500', 'border-green-500');
        return;
    }
    
    // Only show validation if match indicator exists (meaning user has typed in confirm field)
    if (matchIndicator && confirmPassword.length > 0) {
        const confirmField = document.getElementById('password_confirmation');
        
        if (password === confirmPassword) {
            matchIndicator.innerHTML = '<span style="color: #059669 !important; font-weight: 500;"><i class="fas fa-check mr-1"></i>Password cocok</span>';
            confirmField.classList.remove('border-red-500');
            confirmField.classList.add('border-green-500');
        } else {
            matchIndicator.innerHTML = '<span class="text-red-600"><i class="fas fa-times mr-1"></i>Password tidak cocok</span>';
            confirmField.classList.remove('border-green-500');
            confirmField.classList.add('border-red-500');
        }
    }
});

// Auto-hide error messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const errorMessages = document.querySelectorAll('.text-red-600');
    errorMessages.forEach(function(message) {
        if (message.classList.contains('text-red-600') && message.tagName === 'P') {
            setTimeout(function() {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.style.display = 'none';
                }, 500);
            }, 5000);
        }
    });
});
</script>
@endpush