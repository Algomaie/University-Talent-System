@extends('layouts.app')

@section('title', __('Submission Details'))

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Submission Details') }}</h2>
                    <a href="{{ route('student.submissions.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Submissions') }}
                    </a>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('General Information') }}</h3>
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
                        @if($submission->rejection_reason)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Rejection Reason') }}</h3>
                                <p class="text-red-600">{{ $submission->rejection_reason }}</p>
                            </div>
                        @endif
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

                @if($submission->evaluations->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Evaluations') }}</h3>
                        <div class="space-y-4">
                            @foreach($submission->evaluations as $evaluation)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-medium text-gray-900">{{ __('Evaluation by :name', ['name' => $evaluation->evaluator->name]) }}</h4>
                                        <span class="text-sm text-gray-500">{{ $evaluation->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                        <div>
                                            <p class="text-sm text-gray-500">{{ __('Creativity') }}</p>
                                            <p class="font-medium">{{ $evaluation->creativity_score }}/10</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">{{ __('Technical Skill') }}</p>
                                            <p class="font-medium">{{ $evaluation->technical_score }}/10</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">{{ __('Presentation') }}</p>
                                            <p class="font-medium">{{ $evaluation->presentation_score }}/10</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <p class="text-sm text-gray-500">{{ __('Overall Score') }}</p>
                                        <p class="font-medium text-xl">{{ $evaluation->overall_score }}/10 
                                            <span class="text-sm text-gray-500">({{ $evaluation->getScoreGrade() }})</span>
                                        </p>
                                    </div>
                                    
                                    @if($evaluation->is_nominated)
                                        <div class="mb-3 p-3 bg-purple-50 rounded-md">
                                            <p class="text-sm font-medium text-purple-800">
                                                <i class="fas fa-star text-purple-500 mr-1"></i>
                                                {{ __('Nominated') }}
                                            </p>
                                            @if($evaluation->nomination_reason)
                                                <p class="text-sm text-purple-700 mt-1">{{ $evaluation->nomination_reason }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('Comments') }}</p>
                                        <p class="text-gray-700">{{ $evaluation->comments }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-6">
                    @if(in_array($submission->status, ['pending', 'under_review']))
                        <a href="{{ route('student.submissions.edit', $submission) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                            {{ __('Edit') }}
                        </a>
                        <form action="{{ route('student.submissions.destroy', $submission) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('{{ __('Are you sure you want to delete this submission?') }}')">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection