@extends('layouts.app')

@section('title', __('Admin Dashboard'))

@section('content')
<div class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Hero Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl mb-8">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute top-0 right-0 -mt-4 -mr-16 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-24 h-24 bg-white opacity-5 rounded-full"></div>
            
            <div class="relative p-8 lg:p-12">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-6 lg:mb-0">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mr-4 backdrop-blur-sm">
                                <i class="fas fa-crown text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-white mb-2">
                                    {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}
                                </h1>
                                <p class="text-white text-opacity-90 text-lg">
                                    {{ __('Manage users, competitions, talents, and system reports.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.competitions.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Create Competition') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Students -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full transform translate-x-16 -translate-y-16 group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">{{ __('Total Students') }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_students'] }}</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-trending-up text-green-500 text-sm mr-1"></i>
                                <span class="text-sm text-green-500 font-medium">+12% from last month</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Managers -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full transform translate-x-16 -translate-y-16 group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">{{ __('Active Managers') }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_managers'] }}</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-check-circle text-green-500 text-sm mr-1"></i>
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">All active</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user-tie text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Competitions -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full transform translate-x-16 -translate-y-16 group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">{{ __('Total Competitions') }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_competitions'] }}</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-calendar text-purple-500 text-sm mr-1"></i>
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">This year</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-trophy text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Submissions -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full transform translate-x-16 -translate-y-16 group-hover:scale-110 transition-transform duration-300"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">{{ __('Total Submissions') }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_submissions'] }}</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-upload text-orange-500 text-sm mr-1"></i>
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">All time</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 bg-yellow-100 dark:bg-yellow-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-alt text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Pending Submissions -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 rounded-2xl p-6 border border-blue-200 dark:border-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <h3 class="font-semibold text-blue-900 dark:text-blue-100">{{ __('Pending') }}</h3>
                        </div>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['pending_submissions'] }}</p>
                        <p class="text-sm text-blue-600 dark:text-blue-300 mt-1">{{ __('Awaiting review') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="w-16 h-16 bg-blue-200 dark:bg-blue-700 rounded-full flex items-center justify-center">
                            <span class="text-2xl">⏳</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approved Submissions -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900 dark:to-emerald-900 rounded-2xl p-6 border border-green-200 dark:border-green-700">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                            <h3 class="font-semibold text-green-900 dark:text-green-100">{{ __('Approved') }}</h3>
                        </div>
                        <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $stats['approved_submissions'] }}</p>
                        <p class="text-sm text-green-600 dark:text-green-300 mt-1">{{ __('Successfully approved') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="w-16 h-16 bg-green-200 dark:bg-green-700 rounded-full flex items-center justify-center">
                            <span class="text-2xl">✅</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rejected Submissions -->
            <div class="bg-gradient-to-br from-red-50 to-pink-100 dark:from-red-900 dark:to-pink-900 rounded-2xl p-6 border border-red-200 dark:border-red-700">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-times-circle text-white"></i>
                            </div>
                            <h3 class="font-semibold text-red-900 dark:text-red-100">{{ __('Rejected') }}</h3>
                        </div>
                        <p class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $stats['rejected_submissions'] }}</p>
                        <p class="text-sm text-red-600 dark:text-red-300 mt-1">{{ __('Not approved') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="w-16 h-16 bg-red-200 dark:bg-red-700 rounded-full flex items-center justify-center">
                            <span class="text-2xl">❌</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Quick Actions -->
            <div class="xl:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-bolt mr-3"></i>
                            {{ __('Quick Actions') }}
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <a href="{{ route('admin.users.index') }}" 
                           class="group flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-blue-100 hover:to-indigo-100 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300 transform hover:scale-105">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-users-cog text-white"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                    {{ __('Manage Users') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Create, edit, and manage user accounts') }}</p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all duration-300"></i>
                        </a>
                        
                        <a href="{{ route('admin.competitions.index') }}" 
                           class="group flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-green-100 hover:to-emerald-100 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300 transform hover:scale-105">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-trophy text-white"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400">
                                    {{ __('Manage Competitions') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Create, edit, and manage competitions') }}</p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-green-500 group-hover:translate-x-1 transition-all duration-300"></i>
                        </a>
                        
                        <a href="{{ route('admin.talents.index') }}" 
                           class="group flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-purple-100 hover:to-pink-100 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300 transform hover:scale-105">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-star text-white"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400">
                                    {{ __('Manage Talents') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Define and manage talent categories') }}</p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-500 group-hover:translate-x-1 transition-all duration-300"></i>
                        </a>
                        
                        <a href="{{ route('admin.nominated.index') }}" 
                           class="group flex items-center p-4 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-yellow-100 hover:to-orange-100 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300 transform hover:scale-105">
                            <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-award text-white"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-400">
                                    {{ __('Nominated Submissions') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Approve or reject nominations') }}</p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-yellow-500 group-hover:translate-x-1 transition-all duration-300"></i>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-history mr-3"></i>
                            {{ __('Recent Activity') }}
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-user-plus text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('New user registered') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">2 hours ago</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-trophy text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('New competition created') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">1 day ago</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-file-upload text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('New submission received') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">2 days ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Recent Submissions -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <i class="fas fa-file-alt mr-3"></i>
                                {{ __('Recent Submissions') }}
                            </h2>
                            <a href="{{ route('admin.nominated.index') }}" class="inline-flex items-center text-white hover:text-purple-200 font-medium transition-colors duration-300">
                                {{ __('View All') }}
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($recentSubmissions->isEmpty())
                            <div class="text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No submissions yet') }}</h3>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('Students have not submitted any talents yet.') }}</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($recentSubmissions as $submission)
                                <div class="group p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-300 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-300">
                                                {{ $submission->title }}
                                            </h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                <span class="flex items-center">
                                                    <i class="fas fa-user mr-1"></i>
                                                    {{ $submission->user->name }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $submission->talent->name }}
                                                </span>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $submission->statusBadge['class'] }}">
                                                    {{ $submission->statusBadge['text'] }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $submission->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('admin.nominated.index') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors duration-300 group-hover:scale-105 transform">
                                                {{ __('View') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Active Competitions -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-6">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <i class="fas fa-trophy mr-3"></i>
                                {{ __('Active Competitions') }}
                            </h2>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                                {{ $activeCompetitions->count() }} {{ __('active') }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($activeCompetitions->isEmpty())
                            <div class="text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-trophy text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No active competitions') }}</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('There are currently no active competitions.') }}</p>
                                <a href="{{ route('admin.competitions.create') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                    <i class="fas fa-plus mr-2"></i>
                                    {{ __('Create Competition') }}
                                </a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($activeCompetitions as $competition)
                                <div class="group p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-300 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors duration-300">
                                                {{ $competition->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                {{ __('Start: :start - End: :end', [
                                                    'start' => $competition->start_date->format('M d, Y'),
                                                    'end' => $competition->end_date->format('M d, Y')
                                                ]) }}
                                            </p>
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $competition->statusBadge['class'] }}">
                                                    {{ $competition->statusBadge['text'] }}
                                                </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $competition->submissions_count }} {{ __('submissions') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('admin.competitions.edit', $competition) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition-colors duration-300 group-hover:scale-105 transform">
                                                {{ __('Manage') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- System Management -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-6">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-cogs mr-3"></i>
                            {{ __('System Management') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Audit Logs -->
                            <div class="group p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-history text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                            {{ __('Audit Logs') }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('View system activity and user actions') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.audit-logs.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium group-hover:translate-x-2 transition-all duration-300">
                                    {{ __('View Logs') }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>

                            <!-- Database Backups -->
                            <div class="group p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-green-400 dark:hover:border-green-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-database text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400">
                                            {{ __('Database Backups') }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Manage database backups and restoration') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.backups.index') }}" class="inline-flex items-center text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 font-medium group-hover:translate-x-2 transition-all duration-300">
                                    {{ __('Manage Backups') }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>

                            <!-- Reports -->
                            <div class="group p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-purple-400 dark:hover:border-purple-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-chart-bar text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400">
                                            {{ __('Reports') }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Generate system reports and analytics') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium group-hover:translate-x-2 transition-all duration-300">
                                    {{ __('View Reports') }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                            
                            <!-- Nominated Submissions -->
                            <div class="group p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-yellow-400 dark:hover:border-yellow-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-award text-yellow-600 dark:text-yellow-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-400">
                                            {{ __('Nominated Submissions') }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Approve or reject manager nominations') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.nominated.index') }}" class="inline-flex items-center text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300 font-medium group-hover:translate-x-2 transition-all duration-300">
                                    {{ __('Manage Nominations') }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

/* Auto dark mode detection */
@media (prefers-color-scheme: dark) {
    .dark-auto { @apply dark; }
}
</style>

<script>
// Auto detect dark mode preference
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark');
}

// Listen for changes in color scheme preference
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    if (event.matches) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});

// Add staggered animation to cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.grid > div');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate-fade-in-up');
        }, index * 100);
    });
});
</script>
@endsection