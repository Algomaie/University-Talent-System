<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'University Talents System') }} - @yield('title', __('Dashboard'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fallback CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        // Tailwind Configuration
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        // Unified color palette
                        primary: {
                            50: '#f0f0ff',
                            100: '#e0e0ff',
                            200: '#c1c1ff',
                            300: '#a2a2ff',
                            400: '#8383ff',
                            500: '#5D5CDE', // Main primary color
                            600: '#4A49C4', // Primary dark
                            700: '#3736AA',
                            800: '#242390',
                            900: '#111076',
                        },
                        secondary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        success: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        warning: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                        danger: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        },
                        neutral: {
                            50: '#fafafa',
                            100: '#f5f5f5',
                            200: '#e5e5e5',
                            300: '#d4d4d4',
                            400: '#a3a3a3',
                            500: '#737373',
                            600: '#525252',
                            700: '#404040',
                            800: '#262626',
                            900: '#171717',
                        }
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
        
        // Function to automatically hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Select all flash message elements
            const flashMessages = document.querySelectorAll('.alert, .bg-green-100, .bg-red-100, .bg-yellow-100');
            
            // Set timeout to hide each flash message after 5 seconds
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    // Fade out effect
                    message.style.transition = 'opacity 0.5s ease-out';
                    message.style.opacity = '0';
                    
                    // Remove element after fade out
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                }, 5000); // 5000 milliseconds = 5 seconds
            });
        });
    </script>

    <style>
        /* Enhanced font rendering for better consistency */
        html, body {
            font-family: 'Inter', sans-serif !important;
            font-feature-settings: "liga" 1, "kern" 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        
        /* Ensure all elements inherit the base font unless explicitly overridden */
        * {
            font-family: inherit;
        }
        
        /* Unified gradient background using primary colors */
        .gradient-bg {
            background: linear-gradient(135deg, #5D5CDE 0%, #4A49C4 100%);
        }
        
        .dark .gradient-bg {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        }
        
        /* Glass effect with unified colors */
        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(93, 92, 222, 0.2); /* Primary color with opacity */
        }
        
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.95);
            border: 1px solid rgba(93, 92, 222, 0.2); /* Primary color with opacity */
        }
        
        /* Floating shapes using unified primary gradient */
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
        
        /* RTL Support */
        [dir="rtl"] .space-x-reverse > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }
        
        /* Animation for flash messages */
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .slide-out-right {
            animation: slideOutRight 0.5s ease-out forwards;
        }
    </style>

    <!-- Additional CSS -->
    @stack('styles')
</head>
<body class="font-sans antialiased gradient-bg min-h-screen">
    <!-- Background Elements -->
    <div class="floating-shapes fixed inset-0 pointer-events-none overflow-hidden"></div>
    
    <div class="min-h-screen flex flex-col relative z-10">
        <!-- Navigation -->
        <nav x-data="{ open: false }" class="glass-effect border-b border-gray-200 dark:border-gray-700 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center">
                                <i class="fas fa-graduation-cap text-2xl text-primary me-2 animate-float"></i>
                                <span class="font-bold text-xl text-gray-900 dark:text-gray-100">
                                    {{ config('app.name', 'University Talents System') }}
                                </span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                            @auth
                                @if(auth()->user()->isStudent())
                                    <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.*')">
                                        <i class="fas fa-home me-2"></i>
                                        {{ __('Dashboard') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('student.submissions.index')" :active="request()->routeIs('student.submissions.*')">
                                        <i class="fas fa-file-upload me-2"></i>
                                        {{ __('My Submissions') }}
                                    </x-nav-link>
                                @elseif(auth()->user()->isManager())
                                    <x-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.*')">
                                        <i class="fas fa-home me-2"></i>
                                        {{ __('Dashboard') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('manager.evaluations.index')" :active="request()->routeIs('manager.evaluations.*')">
                                        <i class="fas fa-clipboard-check me-2"></i>
                                        {{ __('Evaluations') }}
                                    </x-nav-link>
                                @elseif(auth()->user()->isAdmin())
                                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                        <i class="fas fa-home me-2"></i>
                                        {{ __('Dashboard') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                        <i class="fas fa-users me-2"></i>
                                        {{ __('Users') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('admin.competitions.index')" :active="request()->routeIs('admin.competitions.*')">
                                        <i class="fas fa-trophy me-2"></i>
                                        {{ __('Competitions') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('admin.talents.index')" :active="request()->routeIs('admin.talents.*')">
                                        <i class="fas fa-star me-2"></i>
                                        {{ __('Talents') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                                        <i class="fas fa-chart-bar me-2"></i>
                                        {{ __('Reports') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                                        <i class="fas fa-history me-2"></i>
                                        {{ __('Audit Logs') }}
                                    </x-nav-link>
                                @endif
                            @else
                                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                    <i class="fas fa-home me-2"></i>
                                    {{ __('Home') }}
                                </x-nav-link>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Side Of Navbar -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <!-- Language Switcher -->
                        <div class="relative me-4">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <i class="fas fa-globe me-1"></i>
                                        {{ strtoupper(app()->getLocale()) }}
                                        <i class="fas fa-caret-down ms-1"></i>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('language.switch', 'en') }}" dir="ltr">
                                        English
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('language.switch', 'ar') }}" dir="rtl">
                                        العربية
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Authentication Links -->
                        @auth
                            <!-- Notifications -->
                            <div class="relative me-4" x-data="{ open: false }" @click.outside="open = false">
                                <button @click="open = !open" class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span id="notificationCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                                </button>
                                
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-80 origin-top-right rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                    <div class="p-4">
                                        <div class="flex justify-between items-center mb-3">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Notifications') }}</h3>
                                            <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div id="notificationsList" class="max-h-60 overflow-y-auto">
                                            <div class="px-4 py-3 text-gray-500 text-sm">{{ __("No new notifications") }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Dropdown -->
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                        <div class="me-2">{{ Auth::user()->name }}</div>
                                        <div class="ms-1">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        <i class="fas fa-user-circle me-2"></i>
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @else
                            <x-nav-link :href="route('login')">
                                {{ __('Log in') }}
                            </x-nav-link>

                            @if (Route::has('register'))
                                <x-nav-link :href="route('register')" class="ms-4">
                                    {{ __('Register') }}
                                </x-nav-link>
                            @endif
                        @endauth
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    @auth
                        @if(auth()->user()->isStudent())
                            <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.*')">
                                <i class="fas fa-home me-2"></i>
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('student.submissions.index')" :active="request()->routeIs('student.submissions.*')">
                                <i class="fas fa-file-upload me-2"></i>
                                {{ __('My Submissions') }}
                            </x-responsive-nav-link>
                        @elseif(auth()->user()->isManager())
                            <x-responsive-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.*')">
                                <i class="fas fa-home me-2"></i>
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('manager.evaluations.index')" :active="request()->routeIs('manager.evaluations.*')">
                                <i class="fas fa-clipboard-check me-2"></i>
                                {{ __('Evaluations') }}
                            </x-responsive-nav-link>
                        @elseif(auth()->user()->isAdmin())
                            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <i class="fas fa-home me-2"></i>
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                <i class="fas fa-users me-2"></i>
                                {{ __('Users') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.competitions.index')" :active="request()->routeIs('admin.competitions.*')">
                                <i class="fas fa-trophy me-2"></i>
                                {{ __('Competitions') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.talents.index')" :active="request()->routeIs('admin.talents.*')">
                                <i class="fas fa-star me-2"></i>
                                {{ __('Talents') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                                <i class="fas fa-chart-bar me-2"></i>
                                {{ __('Reports') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                                <i class="fas fa-history me-2"></i>
                                {{ __('Audit Logs') }}
                            </x-responsive-nav-link>
                        @endif
                    @else
                        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            <i class="fas fa-home me-2"></i>
                            {{ __('Home') }}
                        </x-responsive-nav-link>
                    @endauth
                </div>

                <!-- Responsive Settings Options -->
                @auth
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <x-responsive-nav-link :href="route('profile.edit')">
                                <i class="fas fa-user-circle me-2"></i>
                                {{ __('Profile') }}
                            </x-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-center md:text-left mb-4 md:mb-0">
                        <p class="txt">
                            &copy; {{ date('Y') }} {{ config('app.name', 'University Talents System') }}. {{ __('All rights reserved.') }}
                        </p>
                    </div>
                    <div class="flex space-x-6 txt">
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <i class="fab fa-facebook-f txt"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <i class="fab fa-twitter txt"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <i class="fab fa-instagram txt"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <i class="fab fa-linkedin-in txt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-yellow-100, .alert');
            
            flashMessages.forEach(function(message) {
                // Add close button to flash messages
                const closeButton = document.createElement('button');
                closeButton.innerHTML = '&times;';
                closeButton.className = 'absolute top-0 right-0 px-4 py-3 text-xl font-bold';
                closeButton.onclick = function() {
                    hideFlashMessage(message);
                };
                
                // Position relative for parent if not already set
                if (getComputedStyle(message).position === 'static') {
                    message.style.position = 'relative';
                }
                
                message.appendChild(closeButton);
                
                // Auto-hide after 5 seconds
                setTimeout(function() {
                    hideFlashMessage(message);
                }, 5000);
            });
            
            function hideFlashMessage(message) {
                message.style.transition = 'all 0.5s ease-out';
                message.style.opacity = '0';
                message.style.transform = 'translateX(100%)';
                
                setTimeout(function() {
                    if (message.parentNode) {
                        message.parentNode.removeChild(message);
                    }
                }, 500);
            }
            
            // Load unread notifications count
            @auth
            loadUnreadCount();
            setInterval(loadUnreadCount, 30000); // Check every 30 seconds
            @endauth
        });

        function loadUnreadCount() {
            fetch('{{ route("api.notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const countElement = document.getElementById('notificationCount');
                    if (countElement) {
                        if (data.count > 0) {
                            countElement.textContent = data.count > 99 ? '99+' : data.count;
                            countElement.classList.remove('hidden');
                        } else {
                            countElement.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error loading notification count:', error));
        }

        function loadNotifications() {
            // This would load actual notifications via AJAX
            // For now, showing placeholder
            const notificationsList = document.getElementById('notificationsList');
            if (notificationsList) {
                notificationsList.innerHTML = '<div class="px-4 py-3 text-gray-500 text-sm">{{ __("No new notifications") }}</div>';
            }
        }
    </script>

    @stack('scripts')
</body>
</html>