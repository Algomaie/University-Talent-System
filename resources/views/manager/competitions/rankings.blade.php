@extends('layouts.app')

@section('title', __('Competition Rankings'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Rankings for') }}: {{ $competition->title }}</h2>
                    <a href="{{ route('manager.competitions.show', $competition) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Competition') }}
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

                @if($rankings->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-list-ol text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No evaluated submissions found') }}</h3>
                        <p class="text-gray-500">{{ __('No submissions have been evaluated for this competition yet.') }}</p>
                        <a href="{{ route('manager.competitions.submissions', $competition) }}" 
                           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            {{ __('Evaluate Submissions') }}
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rank') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Student') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Talent') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Creativity') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Technical') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Presentation') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Overall') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($rankings as $index => $submission)
                                    <tr class="{{ $index < 3 ? 'bg-yellow-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-lg font-bold text-gray-900">
                                                @if($index === 0)
                                                    <i class="fas fa-trophy text-yellow-500"></i> 1
                                                @elseif($index === 1)
                                                    <i class="fas fa-trophy text-gray-300"></i> 2
                                                @elseif($index === 2)
                                                    <i class="fas fa-trophy text-yellow-800"></i> 3
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </div>
                                        </td>
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
                                            {{ number_format($submission->avg_creativity, 1) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($submission->avg_technical, 1) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($submission->avg_presentation, 1) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ number_format($submission->avg_overall, 1) }}
                                            </div>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $rankings->links() }}
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-end">
                        <button onclick="exportRankings()" 
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 mr-2">
                            <i class="fas fa-file-export mr-1"></i>{{ __('Export Rankings') }}
                        </button>
                        <button onclick="printRankings()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-print mr-1"></i>{{ __('Print Rankings') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function exportRankings() {
    // In a real implementation, this would export the rankings to a file
    alert('{{ __('Export functionality would be implemented here') }}');
}

function printRankings() {
    window.print();
}
</script>
@endsection