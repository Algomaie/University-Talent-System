@extends('layouts.app')

@section('title', __('Manager Dashboard'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">{{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}</h1>
                        <p class="text-gray-900">{{ __('Manage submissions, evaluate student talents, and oversee competitions.') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('manager.competitions.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Create Competition') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">{{ __('Total Submissions') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_submissions'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">{{ __('Pending Evaluations') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_evaluations'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">{{ __('My Evaluations') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['my_evaluations'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100">
                            <i class="fas fa-trophy text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">{{ __('Nominated') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['nominated_submissions'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Quick Actions') }}</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <a href="{{ route('manager.competitions.index') }}" 
                               class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-900">{{ __('Manage Competitions') }}</h3>
                                    <p class="text-sm text-gray-500">{{ __('Create, edit, and archive competitions') }}</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('manager.evaluations.index') }}" 
                               class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-900">{{ __('Evaluate Submissions') }}</h3>
                                    <p class="text-sm text-gray-500">{{ __('Review and score student submissions') }}</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('manager.competitions.index') }}" 
                               class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <i class="fas fa-list-ol"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-900">{{ __('View Rankings') }}</h3>
                                    <p class="text-sm text-gray-500">{{ __('See competition rankings and results') }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Recent Activity') }}</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">{{ __('New competition created') }}</p>
                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="p-2 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">{{ __('Submission evaluated') }}</p>
                                    <p class="text-xs text-gray-500">5 hours ago</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">{{ __('Student nominated') }}</p>
                                    <p class="text-xs text-gray-500">1 day ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Pending Evaluations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Pending Evaluations') }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $stats['pending_evaluations'] }} {{ __('pending') }}
                        </span>
                    </div>
                    <div class="p-6">
                        @forelse($pending_evaluations as $submission)
                        <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition duration-150">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('manager.evaluations.create', $submission) }}" class="hover:text-blue-600">
                                        {{ $submission->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500 mr-3">{{ $submission->competition->title }}</span>
                                    <span class="text-xs text-gray-500">{{ __('By: :name', ['name' => $submission->user->name]) }}</span>
                                </div>
                                <div class="mt-2 flex items-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $submission->talent->name }}
                                    </span>
                                    <span class="text-xs text-gray-500 ml-2">{{ $submission->submitted_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('manager.evaluations.create', $submission) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                                    {{ __('Evaluate') }}
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-gray-300 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('All caught up!') }}</h3>
                            <p class="text-gray-500">{{ __('No pending evaluations at the moment.') }}</p>
                            <a href="{{ route('manager.competitions.index') }}" 
                               class="mt-4 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-200">
                                {{ __('View Competitions') }}
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Recent Submissions') }}</h2>
                            <a href="{{ route('manager.evaluations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                {{ __('View All') }} →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse($recent_submissions as $submission)
                        <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition duration-150">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('manager.evaluations.show', $submission) }}" class="hover:text-blue-600">
                                        {{ $submission->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500 mr-3">{{ $submission->competition->title }}</span>
                                    <span class="text-xs text-gray-500">{{ __('By: :name', ['name' => $submission->user->name]) }}</span>
                                </div>
                                <div class="mt-2 flex items-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $submission->status_badge['class'] }}">
                                        {{ $submission->status_badge['text'] }}
                                    </span>
                                    <span class="text-xs text-gray-500 ml-2">{{ $submission->submitted_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="ml-4 flex items-center">
                                <i class="{{ $submission->talent->icon }} text-gray-400 mr-3" style="color: {{ $submission->talent->color }}"></i>
                                <a href="{{ route('manager.evaluations.show', $submission) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    {{ __('View') }}
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-file-alt text-gray-300 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No submissions yet') }}</h3>
                            <p class="text-gray-500">{{ __('Students have not submitted any talents yet.') }}</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection