@extends('layouts.app')

@section('title', __('Student Dashboard'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                <h1 class="text-2xl font-bold mb-2">{{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}</h1>
                <p class="text-blue-100">{{ __('Track your submissions and participate in new competitions.') }}</p>
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
                            <p class="text-sm font-medium text-gray-600">{{ __('Pending Review') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_submissions'] }}</p>
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
                            <p class="text-sm font-medium text-gray-600">{{ __('Approved') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['approved_submissions'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100">
                            <i class="fas fa-bell text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">{{ __('Notifications') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['unread_notifications'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Submissions -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Recent Submissions') }}</h2>
                            <a href="{{ route('student.submissions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                {{ __('View All') }} →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse($recent_submissions as $submission)
                        <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('student.submissions.show', $submission) }}" class="hover:text-blue-600">
                                        {{ $submission->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500">{{ $submission->competition->title }}</p>
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
                            <p class="text-gray-500 mb-4">{{ __('Start by submitting your first talent to a competition.') }}</p>
                            <a href="{{ route('student.submissions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                {{ __('Create Submission') }}
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Open Competitions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Open Competitions') }}</h2>
                    </div>
                    <div class="p-6">
                        @forelse($open_competitions as $competition)
                        <div class="mb-4 last:mb-0">
                            <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $competition->title }}</h3>
                            <p class="text-xs text-gray-500 mb-2">
                                {{ __('Deadline: :date', ['date' => $competition->registration_deadline->format('M d, Y')]) }}
                            </p>
                            <a href="{{ route('student.submissions.create', $competition->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                {{ __('Participate') }} →
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm">{{ __('No open competitions at the moment.') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Notifications -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Recent Notifications') }}</h2>
                    </div>
                    <div class="p-6">
                        @forelse($recent_notifications as $notification)
                        <div class="mb-4 last:mb-0">
                            <div class="flex items-start">
                                <i class="{{ $notification->type_icon }} mr-3 mt-0.5"></i>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $notification->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($notification->message, 80) }}</p>
                                    <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm">{{ __('No notifications yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection