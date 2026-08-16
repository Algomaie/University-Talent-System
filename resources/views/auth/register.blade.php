<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'University Talents System') }} - {{ __('Register') }}</title>

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
                <p class="text-white/80 dark:text-gray-300 text-lg">{{ __('Student Talents System') }}</p>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="w-full sm:max-w-2xl animate-fade-in">
            <div class="glass-effect px-8 py-10 shadow-2xl sm:rounded-2xl transform transition-all duration-300">
                
                <!-- Flash Messages -->
                <div id="flash-messages" class="space-y-4 mb-6">
                    @if(session('error'))
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <span class="block sm:inline font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                <span class="block sm:inline font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl relative shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                <span class="block sm:inline font-medium">{{ __('Please correct the following errors:') }}</span>
                            </div>
                            <ul class="list-disc pl-5 space-y-1 mt-2 text-left">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Content Area -->
                <div id="main-content">
                    <!-- Welcome Content -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ __('Create Your Account') }}
                        </h2>
                        <!-- <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Fill in your details to get started') }}</p> -->
                    
                        <div class="text-center pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ __('Already have an account?') }} 
                                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary-dark transition-colors">{{ __('Sign In') }}</a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Registration Form -->
                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <i class="fas fa-user-circle text-primary mr-2"></i> {{ __('Personal Information') }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Full Name') }}
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200"
                                        placeholder="{{ __('Enter your full name') }}">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Email Address') }}
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200"
                                        placeholder="{{ __('your@email.com') }}">
                                </div>

                                <div>
                                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Student ID') }}
                                    </label>
                                    <input type="text" name="student_id" id="student_id" value="{{ old('student_id') }}" required
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200"
                                        placeholder="{{ __('Enter your student ID') }}">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Phone Number') }}
                                    </label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" maxlength="10"
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200"
                                        placeholder="{{ __('10-digit phone number') }}">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-left">{{ __('Enter 10-digit phone number') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information Section -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <i class="fas fa-graduation-cap text-primary mr-2"></i> {{ __('Academic Information') }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Department') }}
                                    </label>
                                    <select name="department" id="department"
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200">
                                        <option value="">{{ __('Select your department') }}</option>
                                        <option value="Computer Science" {{ old('department') === 'Computer Science' ? 'selected' : '' }}>{{ __('Computer Science') }}</option>
                                        <option value="Engineering" {{ old('department') === 'Engineering' ? 'selected' : '' }}>{{ __('Engineering') }}</option>
                                        <option value="Business" {{ old('department') === 'Business' ? 'selected' : '' }}>{{ __('Business') }}</option>
                                        <option value="Medicine" {{ old('department') === 'Medicine' ? 'selected' : '' }}>{{ __('Medicine') }}</option>
                                        <option value="Arts" {{ old('department') === 'Arts' ? 'selected' : '' }}>{{ __('Arts') }}</option>
                                        <option value="Science" {{ old('department') === 'Science' ? 'selected' : '' }}>{{ __('Science') }}</option>
                                        <option value="Law" {{ old('department') === 'Law' ? 'selected' : '' }}>{{ __('Law') }}</option>
                                        <option value="Education" {{ old('department') === 'Education' ? 'selected' : '' }}>{{ __('Education') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="academic_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Academic Level') }}
                                    </label>
                                    <select name="academic_level" id="academic_level"
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200">
                                        <option value="">{{ __('Select your level') }}</option>
                                        <option value="Freshman" {{ old('academic_level') === 'Freshman' ? 'selected' : '' }}>{{ __('Freshman (Year 1)') }}</option>
                                        <option value="Sophomore" {{ old('academic_level') === 'Sophomore' ? 'selected' : '' }}>{{ __('Sophomore (Year 2)') }}</option>
                                        <option value="Junior" {{ old('academic_level') === 'Junior' ? 'selected' : '' }}>{{ __('Junior (Year 3)') }}</option>
                                        <option value="Senior" {{ old('academic_level') === 'Senior' ? 'selected' : '' }}>{{ __('Senior (Year 4)') }}</option>
                                        <option value="Graduate" {{ old('academic_level') === 'Graduate' ? 'selected' : '' }}>{{ __('Graduate Student') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information Section -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <i class="fas fa-lock text-primary mr-2"></i> {{ __('Account Information') }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Account Type') }}
                                    </label>
                                    <select name="role" id="role" required
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200">
                                        <option value="">{{ __('Select Account Type') }}</option>
                                        <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>{{ __('Student') }}</option>
                                        <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>{{ __('Competition Manager') }}</option>
                                                                         </select>
                                </div>

                                <div>
                                    <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Profile Picture') }}
                                    </label>
                                    <div class="flex items-center">
                                        <label class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200 cursor-pointer flex items-center justify-center bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <i class="fas fa-upload mr-2 text-gray-500 dark:text-gray-400"></i>
                                            <span id="avatar-label">{{ __('Choose a file') }}</span>
                                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-left">{{ __('JPG, PNG, or GIF (max 2MB)') }}</p>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Password') }}
                                    </label>
                                    <input type="password" name="password" id="password" required
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200"
                                        placeholder="{{ __('Create a strong password') }}">
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left">
                                        {{ __('Confirm Password') }}
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                        class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200"
                                        placeholder="{{ __('Confirm your password') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="terms" id="terms" class="rounded border-gray-300 text-primary shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 h-4 w-4 mt-1" required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="text-gray-700 dark:text-gray-300">
                                        {{ __('I agree to the') }} <a href="#" class="text-primary hover:text-primary-dark font-medium">{{ __('Terms and Conditions') }}</a> {{ __('and') }} <a href="#" class="text-primary hover:text-primary-dark font-medium">{{ __('Privacy Policy') }}</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-medium rounded-xl text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-user-plus group-hover:animate-pulse"></i>
                                </span>
                                {{ __('Create Account') }}
                            </button>
                        </div>

                        <div class="text-center pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ __('Already have an account?') }} 
                                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary-dark transition-colors">{{ __('Sign In') }}</a>
                            </p>
                        </div>
                    </form>
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
        // Update avatar label when file is selected
        document.getElementById('avatar').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : '{{ __('Choose a file') }}';
            document.getElementById('avatar-label').textContent = fileName;
        });

        // Phone number validation
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            if (value.length > 10) {
                value = value.substring(0, 10); // Limit to 10 digits
            }
            e.target.value = value;
        });
    </script>
</body>
</html>