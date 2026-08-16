@extends('layouts.guest')

@section('title', __('University Student Talents & Competitions System'))

@section('content')
<div class="relative bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-500 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/25 backdrop-blur-sm"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-6 leading-tight animate-fade-in">
            🎓 {{ __('University Student Talents & Competitions System') }}
        </h1>
        <p class="text-lg sm:text-xl text-indigo-100 max-w-3xl mx-auto leading-relaxed mb-8 animate-slide-up">
            {{ __('Discover, develop, and showcase your talents within your university community using a unified digital platform.') }}
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8 animate-fade-in">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-700 font-semibold rounded-full hover:bg-indigo-100 transition">
                {{ __('Get Started') }}
            </a>
            <a href="{{ route('about') }}" class="px-8 py-4 border border-white text-white rounded-full hover:bg-white/10 transition">
                {{ __('Learn More') }}
            </a>
        </div>
    </div>
</div>

<!-- Features -->
<section class="py-20 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-8 text-indigo-700 dark:text-indigo-400">{{ __('Key Features') }}</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-12">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 hover:-translate-y-1 hover:shadow-lg transition">
                <i class="fas fa-user-graduate text-indigo-600 dark:text-indigo-400 text-3xl mb-3"></i>
                <h3 class="text-lg font-semibold mb-2">{{ __('For Students') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Easily register your talents, participate in competitions, and showcase your achievements.') }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 hover:-translate-y-1 hover:shadow-lg transition">
                <i class="fas fa-trophy text-indigo-600 dark:text-indigo-400 text-3xl mb-3"></i>
                <h3 class="text-lg font-semibold mb-2">{{ __('For Competition Managers') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Evaluate submissions and support talented students using standardized criteria.') }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 hover:-translate-y-1 hover:shadow-lg transition">
                <i class="fas fa-cogs text-indigo-600 dark:text-indigo-400 text-3xl mb-3"></i>
                <h3 class="text-lg font-semibold mb-2">{{ __('For Administrators') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Manage users, competitions, and reports in a central dashboard.') }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 hover:-translate-y-1 hover:shadow-lg transition">
                <i class="fas fa-language text-indigo-600 dark:text-indigo-400 text-3xl mb-3"></i>
                <h3 class="text-lg font-semibold mb-2">{{ __('Multilingual Support') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Seamlessly switch between English and Arabic with full RTL/LTR compatibility.') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="py-16 bg-white dark:bg-gray-950 text-center transition-colors">
    <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div>
            <p class="text-4xl font-extrabold text-indigo-600 dark:text-indigo-400">{{ $stats['total_students'] ?? 0 }}</p>
            <p class="text-gray-600 dark:text-gray-300">{{ __('Students') }}</p>
        </div>
        <div>
            <p class="text-4xl font-extrabold text-indigo-600 dark:text-indigo-400">{{ $stats['total_competitions'] ?? 0 }}</p>
            <p class="text-gray-600 dark:text-gray-300">{{ __('Competitions') }}</p>
        </div>
        <div>
            <p class="text-4xl font-extrabold text-indigo-600 dark:text-indigo-400">{{ $stats['total_submissions'] ?? 0 }}</p>
            <p class="text-gray-600 dark:text-gray-300">{{ __('Submissions') }}</p>
        </div>
        <div>
            <p class="text-4xl font-extrabold text-indigo-600 dark:text-indigo-400">{{ $stats['total_talents'] ?? 0 }}</p>
            <p class="text-gray-600 dark:text-gray-300">{{ __('Talent Types') }}</p>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center">
    <h2 class="text-3xl font-bold mb-4">{{ __('Ready to join?') }}</h2>
    <p class="text-indigo-100 mb-8">{{ __('Start your journey today and showcase your talent in university competitions!') }}</p>
    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-700 font-semibold rounded-full hover:bg-indigo-100 transition">
        {{ __('Create an Account') }}
    </a>
</section>

<!-- Dark Mode Toggle -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggle = document.createElement('button');
        toggle.innerHTML = '🌙 / ☀️';
        toggle.className = 'fixed bottom-5 right-5 bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:bg-indigo-700 transition';
        toggle.onclick = () => {
            document.documentElement.classList.toggle('dark');
        };
        document.body.appendChild(toggle);
    });
</script>
@endsection
