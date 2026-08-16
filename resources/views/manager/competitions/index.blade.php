@extends('layouts.app')

@section('title', __('My Competitions'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('My Competitions') }}</h2>
                    <a href="{{ route('manager.competitions.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>{{ __('Create Competition') }}
                    </a>
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

                @if($competitions->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-trophy text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No competitions found') }}</h3>
                        <p class="text-gray-500">{{ __('You have not created or managed any competitions yet.') }}</p>
                        <a href="{{ route('manager.competitions.create') }}" 
                           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            {{ __('Create your first competition') }}
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Start Date') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('End Date') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Submissions') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($competitions as $competition)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $competition->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($competition->description, 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $competition->status_badge['class'] }}">
                                                {{ $competition->status_badge['text'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $competition->start_date->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $competition->end_date->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $competition->submissions_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('manager.competitions.show', $competition) }}" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">
                                                {{ __('View') }}
                                            </a>
                                            <a href="{{ route('manager.competitions.edit', $competition) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                {{ __('Edit') }}
                                            </a>
                                            @if($competition->status !== 'closed')
                                                <form action="{{ route('manager.competitions.archive', $competition) }}" 
                                                      method="POST" 
                                                      class="inline-block"
                                                      onsubmit="return confirm('{{ __('Are you sure you want to archive this competition?') }}');">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        {{ __('Archive') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $competitions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection