@extends('layouts.app')

@section('title', __('Participants Report'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Participants Report') }}</h2>
                    <a href="{{ route('admin.reports.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Reports') }}
                    </a>
                </div>

                <!-- Filters -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="competition_id" class="block text-sm font-medium text-gray-700">{{ __('Competition') }}</label>
                            <select name="competition_id" id="competition_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                                <option value="">{{ __('All Competitions') }}</option>
                                @foreach(\App\Models\Competition::all() as $competition)
                                    <option value="{{ $competition->id }}" {{ request('competition_id') == $competition->id ? 'selected' : '' }}>
                                        {{ $competition->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="talent_id" class="block text-sm font-medium text-gray-700">{{ __('Talent Category') }}</label>
                            <select name="talent_id" id="talent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                                <option value="">{{ __('All Talents') }}</option>
                                @foreach(\App\Models\Talent::all() as $talent)
                                    <option value="{{ $talent->id }}" {{ request('talent_id') == $talent->id ? 'selected' : '' }}>
                                        {{ $talent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-3 flex justify-end space-x-2">
                            <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Filter') }}
                            </button>
                            <a href="{{ route('admin.reports.participants') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Email') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Phone') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('University') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Major') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Total Submissions') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Registered At') }}
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
    const competitionId = document.getElementById('competition_id').value;
    const talentId = document.getElementById('talent_id').value;
    
    if (competitionId) filters.competition_id = competitionId;
    if (talentId) filters.talent_id = talentId;
    
    // Show loading
    document.getElementById('report-data').innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center">{{ __('Loading...') }}</td></tr>';
    
    // Fetch data
    fetch('{{ route('admin.reports.participants') }}?' + new URLSearchParams(filters))
        .then(response => response.json())
        .then(data => {
            renderTableData(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('report-data').innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center text-red-500">{{ __('Error loading data') }}</td></tr>';
        });
}

function renderTableData(data) {
    const tbody = document.getElementById('report-data');
    tbody.innerHTML = '';
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center">{{ __('No data found') }}</td></tr>';
        return;
    }
    
    data.forEach(participant => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${participant.id}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${participant.name}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${participant.email}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${participant.phone || ''}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${participant.university || ''}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${participant.major || ''}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${participant.submissions_count || 0}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${participant.created_at ? new Date(participant.created_at).toLocaleDateString() : ''}</td>
        `;
        tbody.appendChild(row);
    });
}

function generateReport(format) {
    // Get current filters
    const filters = {};
    const competitionId = document.getElementById('competition_id').value;
    const talentId = document.getElementById('talent_id').value;
    
    if (competitionId) filters.competition_id = competitionId;
    if (talentId) filters.talent_id = talentId;
    
    // Create form data for report generation
    const formData = {
        type: 'participants',
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