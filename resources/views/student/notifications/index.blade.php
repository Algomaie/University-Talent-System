<x-app-layout>
@section('title', __('My Notifications'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('My Notifications') }}</h2>
                    @if($notifications->isNotEmpty())
                        <button onclick="markAllAsRead()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-check-double mr-1"></i>{{ __('Mark All as Read') }}
                        </button>
                    @endif
                </div>

                @if($notifications->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-bell-slash text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No notifications yet') }}</h3>
                        <p class="text-gray-500">{{ __('You don\'t have any notifications at the moment.') }}</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="border rounded-lg p-4 {{ $notification->is_read ? 'bg-gray-50' : 'bg-white border-blue-200' }}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="{{ $notification->type_icon }} text-xl"></i>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $notification->title }}</h4>
                                            <div class="flex items-center">
                                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                @if(!$notification->is_read)
                                                    <button onclick="markAsRead({{ $notification->id }})" 
                                                            class="ml-2 text-xs text-blue-600 hover:text-blue-800"
                                                            title="{{ __('Mark as read') }}">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                        @if($notification->data)
                                            <div class="mt-2 text-xs text-gray-500">
                                                @foreach($notification->data as $key => $value)
                                                    <span class="inline-block bg-gray-100 rounded px-2 py-1 mr-1 mb-1">
                                                        {{ $key }}: {{ $value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/student/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function markAllAsRead() {
    fetch('/student/notifications/read-all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
</x-app-layout>