@extends('layouts.guest')

@section('title', __('University Student Talents and Competitions Management System'))

@section('content')
<div class="relative overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>

            <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                @include('layouts.navigation')
            </div>

            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">{{ __('University Student Talents and') }}</span>
                        <span class="block text-indigo-600 xl:inline">{{ __('Competitions Management System') }}</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        {{ __('A comprehensive platform for managing student talents and competitions in universities. Showcase your skills, participate in events, and get recognized for your achievements.') }}
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                {{ __('Get Started') }}
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="{{ route('about') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                {{ __('Learn More') }}
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1523580494863-cdf639d8e7e1?ixlib=rb-1.2.1&auto=format&fit=crop&w=2850&q=80" alt="">
    </div>
</div>

<!-- Features -->
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">{{ __('Features') }}</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                {{ __('Everything you need to manage student talents') }}
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                {{ __('Our system provides a complete solution for students, competition managers, and administrators to collaborate effectively.') }}
            </p>
        </div>

        <div class="mt-10">
            <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{ __('For Students') }}</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        {{ __('Easily submit your talents and track their status. Participate in competitions and showcase your skills to the university community.') }}
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{ __('For Competition Managers') }}</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        {{ __('Evaluate submissions using standardized criteria. Nominate outstanding participants for further consideration by the administration.') }}
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{ __('For Administrators') }}</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        {{ __('Manage users, competitions, and talent categories. Generate reports and analytics to understand participation trends and outcomes.') }}
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{ __('Multilingual Support') }}</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        {{ __('Fully supports both Arabic and English languages. Users can switch between languages with a single click.') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="text-center">
                <p class="text-4xl font-extrabold text-indigo-600">{{ $stats['total_students'] }}</p>
                <p class="mt-2 text-base text-gray-500">{{ __('Students') }}</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-extrabold text-indigo-600">{{ $stats['total_competitions'] }}</p>
                <p class="mt-2 text-base text-gray-500">{{ __('Competitions') }}</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-extrabold text-indigo-600">{{ $stats['total_submissions'] }}</p>
                <p class="mt-2 text-base text-gray-500">{{ __('Submissions') }}</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-extrabold text-indigo-600">{{ $stats['total_talents'] }}</p>
                <p class="mt-2 text-base text-gray-500">{{ __('Talent Types') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            <span class="block">{{ __('Ready to get started?') }}</span>
            <span class="block text-indigo-600">{{ __('Join our community today.') }}</span>
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            <div class="inline-flex rounded-md shadow">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Create Account') }}
                </a>
            </div>
            <div class="ml-3 inline-flex rounded-md shadow">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                    {{ __('Sign In') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection