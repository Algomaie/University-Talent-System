<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'University Talents System') }} - {{ __('Login') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#5D5CDE',
                        'primary-light': '#7B7AE8',
                        'primary-dark': '#4A49C4',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            },
            darkMode: 'class'
        }

        // Dark mode detection
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (event.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .dark .gradient-bg {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        }
        
        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.95);
            border: 1px solid rgba(75, 85, 99, 0.2);
        }
        
        .floating-shapes::before,
        .floating-shapes::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, #5D5CDE, #7B7AE8);
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }
        
        .floating-shapes::before {
            width: 200px;
            height: 200px;
            top: -100px;
            left: -100px;
            animation-delay: -2s;
        }
        
        .floating-shapes::after {
            width: 150px;
            height: 150px;
            bottom: -75px;
            right: -75px;
            animation-delay: -4s;
        }
    </style>
</head>
<body class="font-sans antialiased gradient-bg min-h-screen">
    <!-- Background Elements -->
    <div class="floating-shapes fixed inset-0 pointer-events-none overflow-hidden"></div>
    
    <!-- Main Container -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
        <!-- Logo/Header Section -->
        <div class="animate-slide-up mb-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white dark:bg-gray-800 rounded-full shadow-lg mb-4 animate-float">
                    <i class="fas fa-graduation-cap text-3xl text-primary"></i>
                </div>
                <!-- <h1 class="text-3xl font-bold text-white dark:text-gray-100 mb-2">{{ config('app.name', 'University Talents System') }}</h1> -->
                <p class="text-white/80 dark:text-gray-300 text-lg">{{ __('Student Talents System') }}</p>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="w-full sm:max-w-md animate-fade-in">
            <div class="glass-effect px-8 py-10 shadow-2xl sm:rounded-2xl transform transition-all duration-300 hover:scale-105">
                
                <!-- Flash Messages -->
                <div id="flash-messages" class="space-y-4 mb-6">
                    @if (session('status'))
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                <span class="block sm:inline font-medium">{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <span class="block sm:inline font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                <span class="block sm:inline font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-300 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-amber-500 mr-3"></i>
                                <span class="block sm:inline font-medium">{{ session('warning') }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Content Area -->
                <div id="main-content">
                    <!-- Welcome Content -->
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                            {{ __('Welcome Back') }}
                        </h2>
                        
                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Email Address') }}
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                           class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200 @error('email') border-red-500 @enderror"
                                           placeholder="{{ __('Enter your email') }}">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1 text-left">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Password') }}
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" required 
                                               class="w-full px-4 py-3 pr-12 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200 @error('password') border-red-500 @enderror"
                                               placeholder="{{ __('Enter your password') }}">
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" id="togglePassword">
                                            <i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1 text-left">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember_me" name="remember" type="checkbox" 
                                           class="h-4 w-4 text-primary focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-primary-dark transition-colors">
                                            {{ __('Forgot password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <button type="submit" 
                                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-medium rounded-xl text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                        <i class="fas fa-sign-in-alt group-hover:animate-pulse"></i>
                                    </span>
                                    {{ __('Sign In') }}
                                </button>
                            </div>
                        </form>

                        <!-- Additional Links -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Don't have an account?") }}
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary-dark transition-colors ml-1">
                                        {{ __('Register here') }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="txt">
                &copy; {{ date('Y') }} {{ config('app.name', 'University Talents System') }}. {{ __('All rights reserved.') }}
            </p>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            
            if (toggleButton && passwordInput) {
                toggleButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>