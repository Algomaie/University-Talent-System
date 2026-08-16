@extends('layouts.app')

@section('title', __('Competition Details'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">{{ __('Competition Details') }}</h2>
                    <a href="{{ route('admin.competitions.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        {{ __('Back to Competitions') }}
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Title (Arabic)') }}</h3>
                        <p class="text-gray-900">{{ $competition->title_ar }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Title (English)') }}</h3>
                        <p class="text-gray-900">{{ $competition->title_en }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Start Date') }}</h3>
                        <p class="text-gray-900">{{ $competition->start_date->format('Y-m-d') }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('End Date') }}</h3>
                        <p class="text-gray-900">{{ $competition->end_date->format('Y-m-d') }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Registration Deadline') }}</h3>
                        <p class="text-gray-900">{{ $competition->registration_deadline->format('Y-m-d') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Description (Arabic)') }}</h3>
                    <p class="text-gray-900 whitespace-pre-line">{{ $competition->description_ar }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Description (English)') }}</h3>
                    <p class="text-gray-900 whitespace-pre-line">{{ $competition->description_en }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Status') }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $competition->getStatusBadgeAttribute()['class'] }}">
                            {{ $competition->getStatusBadgeAttribute()['text'] }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Max Submissions Per Student') }}</h3>
                        <p class="text-gray-900">{{ $competition->max_participants ?? __('Unlimited') }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Allowed Talents') }}</h3>
                        <ul class="list-disc pl-5 text-gray-900">
                            @foreach($competition->allowedTalentsList() as $talent)
                                <li>{{ $talent->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.competitions.edit', $competition) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Edit') }}
                    </a>
                    
                    <form action="{{ route('admin.competitions.destroy', $competition) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this competition?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection