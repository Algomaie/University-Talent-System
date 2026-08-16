@extends('layouts.app')

@section('title', __('Competition Submissions'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Submissions for') }}: {{ $competition->title }}</h2>
                    <a href="{{ route('manager.competitions.show', $competition) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Competition') }}
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-1 student submissions found') }}</p>
                        <a href="{{ route('manager.competitions.show', $competition) }}" 
                           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            {{ __('Back to Competition Details') }}
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Student') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Talent') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Submission Date') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('My Evaluation') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($submissions as $submission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $submission->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $submission->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $submission->talent->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $submission->created_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($submission->status === 'nominated')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ __('Nominated') }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ __('Submitted') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @php
                                                $evaluation = $submission->evaluations->first();
                                            @endphp
                                            @if($evaluation)
                                                <span class="text-green-600">{{ __('Evaluated') }}</span>
                                                <div class="text-xs text-gray-500">
                                                    {{ __('Score') }}: {{ $evaluation->overall_score }}/100
                                                </div>
                                            @else
                                                <span class="text-yellow-600">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('manager.evaluations.show', $submission) }}" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">
                                                {{ __('View') }}
                                            </a>
                                            @if(!$evaluation)
                                                <a href="{{ route('manager.evaluations.create', $submission) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    {{ __('Evaluate') }}
                                                </a>
                                            @else
                                                <a href="{{ route('manager.evaluations.edit', [$submission, $evaluation]) }}" 
                                                   class="text-green-600 hover:text-green-900 mr-3">
                                                    {{ __('Edit Evaluation') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection