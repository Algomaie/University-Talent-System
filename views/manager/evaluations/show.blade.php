@extends('layouts.app')

@section('title', __('Submission Details'))

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Submission Details') }}</h2>
                    <a href="{{ route('manager.evaluations.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Evaluations') }}
                    </a>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Student Information') }}</h3>
                            <div class="space-y-2">
                                <p><strong>{{ __('Name:') }}</strong> {{ $submission->user->name }}</p>
                                <p><strong>{{ __('Student ID:') }}</strong> {{ $submission->user->student_id }}</p>
                                <p><strong>{{ __('Department:') }}</strong> {{ $submission->user->department }}</p>
                                <p><strong>{{ __('Academic Level:') }}</strong> {{ $submission->user->academic_level }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Submission Information') }}</h3>
                            <div class="space-y-2">
                                <p><strong>{{ __('Title:') }}</strong> {{ $submission->title }}</p>
                                <p><strong>{{ __('Competition:') }}</strong> {{ $submission->competition->title }}</p>
                                <p><strong>{{ __('Talent:') }}</strong> {{ $submission->talent->name }}</p>
                                <p><strong>{{ __('Status:') }}</strong> 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->statusBadge['class'] }}">
                                        {{ $submission->statusBadge['text'] }}
                                    </span>
                                </p>
                                <p><strong>{{ __('Submitted At:') }}</strong> {{ $submission->submitted_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Description') }}</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $submission->description }}</p>
                </div>

                @if($submission->files && count($submission->filesUrl) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Files') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($submission->filesUrl as $file)
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center">
                                        @if(in_array($file['type'], ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="h-16 w-16 object-cover rounded">
                                        @elseif(in_array($file['type'], ['mp4', 'mov', 'avi']))
                                            <video class="h-16 w-16 object-cover rounded" controls>
                                                <source src="{{ $file['url'] }}" type="video/{{ $file['type'] }}">
                                                {{ __('Your browser does not support the video tag.') }}
                                            </video>
                                        @else
                                            <div class="h-16 w-16 flex items-center justify-center bg-gray-200 rounded">
                                                <i class="fas fa-file-alt text-2xl text-gray-500"></i>
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $file['name'] }}</p>
                                            <a href="{{ $file['url'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm">{{ __('View') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('manager.evaluations.create', $submission) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Evaluate This Submission') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection