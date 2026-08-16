@extends('layouts.app')

@section('title', __('Talents Report'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Talents Report') }}</h2>
                    <a href="{{ route('admin.reports.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Reports') }}
                    </a>
                </div>

                <!-- Filters -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                        </div>

                        <div class="md:col-span-3 flex justify-end space-x-2">
                            <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Filter') }}
                            </button>
                            <a href="{{ route('admin.reports.talents') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Clear') }}
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Report Data -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('ID') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name (Arabic)') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name (English)') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Description') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Status') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Total Submissions') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Created At') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="report-data">
                            <!-- Data will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Export Options -->
                <div class="mt-6 flex space-x-4">
                    <button onclick="generateReport('pdf')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Export to PDF') }}
                    </button>
                    <button onclick="generateReport('excel')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Export to Excel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load report data
    loadReportData();
    
    // Reload data when filters change
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        loadReportData();
    });
});

function loadReportData() {
    // Get filter values
    const filters = {};
    const status = document.getElementById('status').value;
    
    if (status) filters.status = status;
    
    // Show loading
    document.getElementById('report-data').innerHTML = '<tr><td colspan="7" class="px-6 py-4 text-center">{{ __('Loading...') }}</td></tr>';
    
    // Fetch data
    fetch('{{ route('admin.reports.talents') }}?' + new URLSearchParams(filters))
        .then(response => response.json())
        .then(data => {
            renderTableData(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('report-data').innerHTML = '<tr><td colspan="7" class="px-6 py-4 text-center text-red-500">{{ __('Error loading data') }}</td></tr>';
        });
}

function renderTableData(data) {
    const tbody = document.getElementById('report-data');
    tbody.innerHTML = '';
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-4 text-center">{{ __('No data found') }}</td></tr>';
        return;
    }
    
    data.forEach(talent => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${talent.id}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${talent.name_ar}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${talent.name_en}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${talent.description_ar || talent.description_en || ''}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    ${talent.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${talent.status.charAt(0).toUpperCase() + talent.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${talent.submissions_count || 0}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${talent.created_at ? new Date(talent.created_at).toLocaleDateString() : ''}</td>
        `;
        tbody.appendChild(row);
    });
}

function generateReport(format) {
    // Get current filters
    const filters = {};
    const status = document.getElementById('status').value;
    
    if (status) filters.status = status;
    
    // Create form data for report generation
    const formData = {
        type: 'talents',
        format: format,
        filters: filters
    };
    
    // Send request to generate report
    fetch('{{ route('admin.reports.generate') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to download the generated report
            window.location.href = '{{ url('/') }}/admin/reports/download/' + data.report.id;
        } else {
            alert(data.message || '{{ __('Failed to generate report') }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __('Failed to generate report') }}');
    });
}
</script>
@endsection