@extends('layouts.app')

@section('title', __('Manager Dashboard'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                <h1 class="text-2xl font-bold mb-2">{{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}</h1>
                <p class="text-blue-100">{{ __('Manage submissions and evaluate student talents.') }}</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
                    <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="{{ route('manager.evaluations.show', $submission) }}" class="hover:text-blue-600">
                                    {{ $submission->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500">{{ $submission->competition->title }}</p>
                            <p class="text-xs text-gray-500">{{ __('By: :name', ['name' => $submission->user->name]) }}</p>
                            <div class="flex items-center mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $submission->status_badge['class'] }}">
                                    {{ $submission->status_badge['text'] }}
                                </span>
                                <span class="text-xs text-gray-500 ml-2">{{ $submission->submitted_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <i class="{{ $submission->talent->icon }} text-gray-400" style="color: {{ $submission->talent->color }}"></i>
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

            <!-- Pending Evaluations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Pending Evaluations') }}</h2>
                </div>
                <div class="p-6">
                    @forelse($pending_evaluations as $submission)
                    <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="{{ route('manager.evaluations.create', $submission) }}" class="hover:text-blue-600">
                                    {{ $submission->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500">{{ $submission->competition->title }}</p>
                            <p class="text-xs text-gray-500">{{ __('By: :name', ['name' => $submission->user->name]) }}</p>
                            <div class="mt-1">
                                <span class="text-xs text-gray-500">{{ $submission->submitted_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('manager.evaluations.create', $submission) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition duration-200">
                                {{ __('Evaluate') }}
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-check-circle text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('All caught up!') }}</h3>
                        <p class="text-gray-500">{{ __('No pending evaluations at the moment.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection