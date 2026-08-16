@extends('layouts.app')

@section('title', __('Reports Management'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Reports Management') }}</h2>
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

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">{{ __('Submissions Report') }}</h3>
                        <p class="text-blue-600 mb-4">{{ __('Generate detailed reports on all submissions') }}</p>
                        <a href="{{ route('admin.reports.submissions') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('View Report') }}
                        </a>
                    </div>

                    <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                        <h3 class="text-lg font-semibold text-green-800 mb-2">{{ __('Evaluations Report') }}</h3>
                        <p class="text-green-600 mb-4">{{ __('Generate reports on evaluation scores and results') }}</p>
                        <a href="{{ route('admin.reports.evaluations') }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('View Report') }}
                        </a>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-6 border border-purple-200">
                        <h3 class="text-lg font-semibold text-purple-800 mb-2">{{ __('Participants Report') }}</h3>
                        <p class="text-purple-600 mb-4">{{ __('Generate reports on student participation') }}</p>
                        <a href="{{ route('admin.reports.participants') }}" class="inline-block bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('View Report') }}
                        </a>
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                        <h3 class="text-lg font-semibold text-yellow-800 mb-2">{{ __('Talents Report') }}</h3>
                        <p class="text-yellow-600 mb-4">{{ __('Generate reports on talent categories and distribution') }}</p>
                        <a href="{{ route('admin.reports.talents') }}" class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('View Report') }}
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Custom Report Generator') }}</h3>
                    <form id="report-form" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-900 mb-1">{{ __('Report Type') }}</label>
                                <select name="type" id="report_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" required>
                                    <option value="">{{ __('Select Report Type') }}</option>
                                    <option value="submissions">{{ __('Submissions') }}</option>
                                    <option value="evaluations">{{ __('Evaluations') }}</option>
                                    <option value="participants">{{ __('Participants') }}</option>
                                    <option value="talents">{{ __('Talents') }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-900 mb-1">{{ __('Format') }}</label>
                                <select name="format" id="format" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" required>
                                    <option value="">{{ __('Select Format') }}</option>
                                    <option value="pdf">{{ __('PDF') }}</option>
                                    <option value="excel">{{ __('Excel') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div id="filters-section" class="hidden mt-4 p-4 bg-white rounded-md border border-gray-200">
                            <h4 class="font-medium text-gray-900 mb-3">{{ __('Filters') }}</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="competition_id" class="block text-sm font-medium text-gray-900 mb-1">{{ __('Competition') }}</label>
                                    <select name="filters[competition_id]" id="competition_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                                        <option value="">{{ __('All Competitions') }}</option>
                                        @foreach(\App\Models\Competition::all() as $competition)
                                            <option value="{{ $competition->id }}">{{ $competition->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-900 mb-1">{{ __('Status') }}</label>
                                    <select name="filters[status]" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                                        <option value="">{{ __('All Statuses') }}</option>
                                        <option value="pending">{{ __('Pending') }}</option>
                                        <option value="approved">{{ __('Approved') }}</option>
                                        <option value="rejected">{{ __('Rejected') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="date_from" class="block text-sm font-medium text-gray-900 mb-1">{{ __('From Date') }}</label>
                                    <input type="date" name="filters[date_from]" id="date_from" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label for="date_to" class="block text-sm font-medium text-gray-900 mb-1">{{ __('To Date') }}</label>
                                    <input type="date" name="filters[date_to]" id="date_to" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <button type="button" id="toggle-filters" class="text-sm text-primary-600 hover:text-primary-800 mr-4">
                                {{ __('Show/Hide Filters') }}
                            </button>
                        </div>

                        <div class="mt-6">
                            <button type="submit" id="generate-btn" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Generate Report') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Generated Reports History -->
                <div class="mt-10">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Generated Reports') }}</h3>
                    
                    @if($reports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Title') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Type') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Date') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reports as $report)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $report->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($report->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $report->created_at->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.reports.download', $report) }}" class="text-primary-600 hover:text-primary-900">
                                            {{ __('Download') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $reports->links() }}
                    </div>
                    @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">{{ __('No reports generated yet.') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('report-form');
    const toggleFiltersBtn = document.getElementById('toggle-filters');
    const filtersSection = document.getElementById('filters-section');
    const generateBtn = document.getElementById('generate-btn');
    
    // Toggle filters section
    toggleFiltersBtn.addEventListener('click', function() {
        filtersSection.classList.toggle('hidden');
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const data = {};
        
        // Convert FormData to object
        for (let [key, value] of formData.entries()) {
            // Handle nested filters
            if (key.startsWith('filters[')) {
                if (!data.filters) data.filters = {};
                const filterKey = key.match(/\[(.*?)\]/)[1];
                data.filters[filterKey] = value;
            } else {
                data[key] = value;
            }
        }
        
        // Disable button and show loading
        generateBtn.disabled = true;
        generateBtn.textContent = '{{ __('Generating...') }}';
        
        // Send AJAX request
        fetch('{{ route('admin.reports.generate') }}', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // If not JSON, throw an error
                throw new Error('Server returned non-JSON response');
            }
        })
        .then(data => {
            if (data.success) {
                // Show success message
                alert('{{ __('Report generated successfully!') }}');
                // Reload the page to show the new report in history
                location.reload();
            } else {
                alert(data.message || '{{ __('An error occurred while generating the report.') }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __('An error occurred while generating the report. Please try again.') }}');
        })
        .finally(() => {
            // Re-enable button
            generateBtn.disabled = false;
            generateBtn.textContent = '{{ __('Generate Report') }}';
        });
    });
});
</script>
@endsection