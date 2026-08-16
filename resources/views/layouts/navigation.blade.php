<nav x-data="{ open: false }" class="glass-effect border-b border-gray-200 dark:border-gray-700 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? (auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isManager() ? route('manager.dashboard') : route('admin.dashboard'))) : route('home') }}" class="flex items-center">
                        <i class="fas fa-graduation-cap text-2xl text-primary me-2 animate-float"></i>
                        <span class="font-bold text-xl text-gray-900 dark:text-gray-100">
                            {{ config('app.name', 'University Talents System') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                @if (auth()->check())
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <x-nav-link :href="auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isManager() ? route('manager.dashboard') : route('admin.dashboard'))" :active="request()->routeIs(
                        auth()->user()->isStudent() ? 'student.dashboard' : 
                        (auth()->user()->isManager() ? 'manager.dashboard' : 'admin.dashboard')
                    )">
                        <i class="fas fa-home me-2"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if(auth()->user()->isStudent())
                        <x-nav-link :href="route('student.submissions.index')" :active="request()->routeIs('student.submissions.*')">
                            <i class="fas fa-file-upload me-2"></i>
                            {{ __('My Submissions') }}
                        </x-nav-link>
                    @elseif(auth()->user()->isManager())
                        <x-nav-link :href="route('manager.evaluations.index')" :active="request()->routeIs('manager.evaluations.*')">
                            <i class="fas fa-clipboard-check me-2"></i>
                            {{ __('Evaluations') }}
                        </x-nav-link>
                    @elseif(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <i class="fas fa-users me-2"></i>
                            {{ __('Users') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                            <i class="fas fa-history me-2"></i>
                            {{ __('Audit Logs') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.backups.index')" :active="request()->routeIs('admin.backups.*')">
                            <i class="fas fa-database me-2"></i>
                            {{ __('Backups') }}
                        </x-nav-link>
                    @endif
                </div>
                @else
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        <i class="fas fa-home me-2"></i>
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('About') }}
                    </x-nav-link>
                </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            @if (auth()->check())
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Language Switcher -->
                <div class="me-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('language.switch', 'ar') }}" 
                           class="px-3 py-1 rounded-md text-sm font-medium {{ app()->getLocale() === 'ar' ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            العربية
                        </a>
                        <a href="{{ route('language.switch', 'en') }}"
                           class="px-3 py-1 rounded-md text-sm font-medium {{ app()->getLocale() === 'en' ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            English
                        </a>
                    </div>
                </div>
                
                <!-- Notifications -->
                <div class="me-4 relative">
                    <button id="notificationsButton" class="relative p-2 rounded-full text-gray-700 dark:text-gray-300 hover:text-primary-500 focus:outline-none focus:text-primary-500">
                        <i class="fas fa-bell text-lg"></i>
                        <span id="notificationCount" class="hidden absolute -top-1 -end-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
                    </button>
                    
                    <!-- Notifications Dropdown -->
                    <div id="notificationsDropdown" class="hidden absolute end-0 mt-2 w-80 glass-effect rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Notifications') }}</h3>
                        </div>
                        <div id="notificationsList" class="max-h-64 overflow-y-auto">
                            <!-- Notifications will be loaded here -->
                        </div>
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white/30 dark:bg-gray-700/30 hover:text-primary-500 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle text-lg me-2"></i>
                                <div>{{ Auth::user()->name }}</div>
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user me-2"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 transform hover:scale-105">
                    {{ __('Register') }}
                </a>
            </div>
            @endif

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-primary-500 focus:outline-none focus:text-primary-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @if (auth()->check())
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isManager() ? route('manager.dashboard') : route('admin.dashboard'))" :active="request()->routeIs(
                auth()->user()->isStudent() ? 'student.dashboard' : 
                (auth()->user()->isManager() ? 'manager.dashboard' : 'admin.dashboard')
            )">
                <i class="fas fa-home me-2"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(auth()->user()->isStudent())
                <x-responsive-nav-link :href="route('student.submissions.index')" :active="request()->routeIs('student.submissions.*')">
                    <i class="fas fa-file-upload me-2"></i>
                    {{ __('My Submissions') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->isManager())
                <x-responsive-nav-link :href="route('manager.evaluations.index')" :active="request()->routeIs('manager.evaluations.*')">
                    <i class="fas fa-clipboard-check me-2"></i>
                    {{ __('Evaluations') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    <i class="fas fa-users me-2"></i>
                    {{ __('Users') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                    <i class="fas fa-history me-2"></i>
                    {{ __('Audit Logs') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.backups.index')" :active="request()->routeIs('admin.backups.*')">
                    <i class="fas fa-database me-2"></i>
                    {{ __('Backups') }}
                </x-responsive-nav-link>
            @endif
        </div>
        @else
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                <i class="fas fa-home me-2"></i>
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('About') }}
            </x-responsive-nav-link>
        </div>
        @endif

        <!-- Responsive Settings Options -->
        @if (auth()->check())
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-700 dark:text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user me-2"></i>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    <i class="fas fa-user-plus me-2"></i>
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
        </div>
        @endif
    </div>
</nav>