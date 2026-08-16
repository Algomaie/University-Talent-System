@extends('layouts.app')

@section('title', __('Nominated Submissions'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Nominated Submissions') }}</h2>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if($submissions->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-trophy text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No nominated submissions') }}</h3>
                        <p class="text-gray-500">{{ __('There are currently no submissions nominated by managers.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Student') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Competition') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Talent') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Submitted At') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($submissions as $submission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $submission->user->avatarUrl }}" alt="{{ $submission->user->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $submission->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $submission->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $submission->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($submission->description, 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $submission->competition->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $submission->talent->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $submission->submitted_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.nominated.approve', $submission) }}" 
                                               class="text-green-600 hover:text-green-900 mr-3"
                                               onclick="event.preventDefault(); 
                                                        if(confirm('{{ __('Are you sure you want to approve this nomination?') }}')) {
                                                            document.getElementById('approve-form-{{ $submission->id }}').submit();
                                                        }">
                                                {{ __('Approve') }}
                                            </a>
                                            <a href="{{ route('admin.nominated.reject', $submission) }}" 
                                               class="text-red-600 hover:text-red-900"
                                               onclick="event.preventDefault(); 
                                                        if(confirm('{{ __('Are you sure you want to reject this nomination?') }}')) {
                                                            document.getElementById('reject-form-{{ $submission->id }}').submit();
                                                        }">
                                                {{ __('Reject') }}
                                            </a>
                                            
                                            <!-- Hidden forms for approve and reject actions -->
                                            <form id="approve-form-{{ $submission->id }}" 
                                                  action="{{ route('admin.nominated.approve', $submission) }}" 
                                                  method="POST" 
                                                  class="hidden">
                                                @csrf
                                            </form>
                                            
                                            <form id="reject-form-{{ $submission->id }}" 
                                                  action="{{ route('admin.nominated.reject', $submission) }}" 
                                                  method="POST" 
                                                  class="hidden">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    <!-- Display nomination reason if available -->
                                    @if($submission->evaluations->where('is_nominated', true)->first())
                                        @php
                                            $nomination = $submission->evaluations->where('is_nominated', true)->first();
                                        @endphp
                                        @if($nomination->nomination_reason)
                                            <tr class="bg-purple-50">
                                                <td colspan="6" class="px-6 py-3">
                                                    <div class="text-sm">
                                                        <strong>{{ __('Nomination Reason:') }}</strong> 
                                                        <span class="text-purple-700">{{ $nomination->nomination_reason }}</span>
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            {{ __('Nominated by:') }} {{ $nomination->evaluator->name }} 
                                                            {{ __('on') }} {{ $nomination->created_at->format('Y-m-d H:i') }}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
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