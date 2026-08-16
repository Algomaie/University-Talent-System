@extends('layouts.app')

@section('title', __('Competition Details'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $competition->title }}</h2>
                    <div>
                        <a href="{{ route('manager.competitions.edit', $competition) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 mr-2">
                            <i class="fas fa-edit mr-1"></i>{{ __('Edit') }}
                        </a>
                        <a href="{{ route('manager.competitions.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-arrow-left mr-1"></i>{{ __('Back') }}
                        </a>
                    </div>
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

                <!-- Competition Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm text-blue-700">{{ __('Total Submissions') }}</div>
                        <div class="text-2xl font-bold text-blue-900">{{ $stats['total_submissions'] }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="text-sm text-yellow-700">{{ __('Pending Evaluations') }}</div>
                        <div class="text-2xl font-bold text-yellow-900">{{ $stats['pending_evaluations'] }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-sm text-green-700">{{ __('Evaluated') }}</div>
                        <div class="text-2xl font-bold text-green-900">{{ $stats['evaluated_submissions'] }}</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-sm text-purple-700">{{ __('Nominated') }}</div>
                        <div class="text-2xl font-bold text-purple-900">{{ $stats['nominated_submissions'] }}</div>
                    </div>
                </div>

                <!-- Competition Details -->
                <div class="border border-gray-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Competition Details') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-500">{{ __('Status') }}</label>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $competition->status_badge['class'] }}">
                                    {{ $competition->status_badge['text'] }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-500">{{ __('Start Date') }}</label>
                                <div class="text-sm text-gray-900">{{ $competition->start_date->format('Y-m-d') }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-500">{{ __('End Date') }}</label>
                                <div class="text-sm text-gray-900">{{ $competition->end_date->format('Y-m-d') }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-500">{{ __('Registration Deadline') }}</label>
                                <div class="text-sm text-gray-900">{{ $competition->registration_deadline->format('Y-m-d') }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-500">{{ __('Max Participants') }}</label>
                                <div class="text-sm text-gray-900">{{ $competition->max_participants ?? __('Unlimited') }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-500">{{ __('Allowed Talents') }}</label>
                                <div class="text-sm text-gray-900">
                                    @foreach($competition->allowedTalentsList() as $talent)
                                        <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-900 mr-2 mb-2">
                                            {{ $talent->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500">{{ __('Description') }}</label>
                        <div class="text-sm text-gray-900 mt-1">
                            <p>{{ $competition->description }}</p>
                        </div>
                    </div>
                    
                    @if($competition->evaluation_criteria)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500">{{ __('Evaluation Criteria') }}</label>
                        <div class="text-sm text-gray-900 mt-1 bg-gray-50 p-3 rounded">
                            <p>{{ $competition->evaluation_criteria }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <a href="{{ route('manager.competitions.submissions', $competition) }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-file-alt mr-1"></i>{{ __('View Submissions') }} ({{ $stats['total_submissions'] }})
                    </a>
                    
                    <a href="{{ route('manager.competitions.rankings', $competition) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-list-ol mr-1"></i>{{ __('View Rankings') }}
                    </a>
                    
                    @if($competition->status !== 'closed')
                        <button onclick="openNotificationModal()" 
                                class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-bell mr-1"></i>{{ __('Send Notifications') }}
                        </button>
                        
                        <form action="{{ route('manager.competitions.archive', $competition) }}" 
                              method="POST" 
                              class="inline-block"
                              onsubmit="return confirm('{{ __('Are you sure you want to archive this competition?') }}');">
                            @csrf
                            @method('POST')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-archive mr-1"></i>{{ __('Archive Competition') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div id="notificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Send Bulk Notification') }}</h3>
                <button onclick="closeNotificationModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('manager.competitions.notifications.send', $competition) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-900 mb-1">
                        {{ __('Subject') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="subject" 
                           id="subject" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>
                
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-900 mb-1">
                        {{ __('Message') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" 
                              id="message" 
                              rows="5"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeNotificationModal()"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        {{ __('Send Notification') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openNotificationModal() {
    document.getElementById('notificationModal').classList.remove('hidden');
}

function closeNotificationModal() {
    document.getElementById('notificationModal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('notificationModal');
    if (event.target === modal) {
        closeNotificationModal();
    }
});
</script>
@endsection