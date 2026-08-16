<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'University Talents System') }} - @yield('title', __('Welcome'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Compiled CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark' || 
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script>
        // Tailwind Configuration
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
            width: 500px;
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
        
        /* RTL Support */
        [dir="rtl"] .space-x-reverse > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }
        
        /* Ensure Inter font is used throughout the application */
        body, html {
            font-family: 'Inter', sans-serif !important;
        }
    </style>

    <!-- Additional CSS -->
    @stack('styles')
</head>
<body class="font-sans antialiased gradient-bg min-h-screen dark:bg-gray-900 dark:text-gray-100">
    <!-- Background Elements -->
    <div class="floating-shapes fixed inset-0 pointer-events-none overflow-hidden"></div>
    
    <div class="min-h-screen flex flex-col relative z-10">
 
        <!-- Flash Messages -->
        <div id="flash-messages" class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl relative shadow-sm mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                        <span class="block sm:inline font-medium">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl relative shadow-sm mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="block sm:inline font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl relative shadow-sm mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                        <span class="block sm:inline font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-300 px-4 py-3 rounded-xl relative shadow-sm mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-amber-500 mr-3"></i>
                        <span class="block sm:inline font-medium">{{ session('warning') }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-grow flex items-center justify-center p-4 sm:p-6">
            <div class="max-w-7xl mx-auto">
                <div class="glass-effect shadow-xl overflow-hidden rounded-2xl p-8 sm:p-10 animate-fade-in">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="glass-effect border-t border-gray-200 dark:border-gray-700 mt-12 mx-4 sm:mx-6 lg:mx-8 rounded-t-xl">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-graduation-cap text-2xl text-primary me-2"></i>
                            <h3 class="text-lg font-semibold dark:text-gray-100">
                                {{ config('app.name', 'University Talents System') }}
                            </h3>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ __('Digital platform for managing university student talents and competitions.') }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold dark:text-gray-100 mb-4">
                            {{ __('Quick Links') }}
                        </h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary-light transition-colors">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary-light transition-colors">{{ __('About') }}</a></li>
                            <li><a href="{{ route('login') }}" class="text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary-light transition-colors">{{ __('Login') }}</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-600 hover:text-primary dark:text-gray-400 dark:hover:text-primary-light transition-colors">{{ __('Register') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold dark:text-gray-100 mb-4">
                            {{ __('Contact Us') }}
                        </h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                            <li class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                <span>info@university-talents.edu</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone mr-2"></i>
                                <span>+1 (555) 123-4567</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>123 University Street, City, Country</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-6 text-center">
                   <p class="txt">
                        &copy; {{ date('Y') }} {{ config('app.name', 'University Talents System') }}. {{ __('All rights reserved.') }}
                    </p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>