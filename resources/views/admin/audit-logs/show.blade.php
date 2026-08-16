@extends('layouts.app')

@section('title', __('Audit Log Details'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">{{ __('Audit Log Details') }}</h2>
                    <a href="{{ route('admin.audit-logs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        {{ __('Back to Logs') }}
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Basic Information') }}</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-900">{{ __('Date & Time') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $auditLog->formatted_created_at }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900">{{ __('User') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $auditLog->user->name ?? __('Unknown User') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900">{{ __('Action') }}</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($auditLog->action == 'create') bg-green-100 text-green-800
                                        @elseif($auditLog->action == 'update') bg-blue-100 text-blue-800
                                        @elseif($auditLog->action == 'delete') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $auditLog->action_description }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900">{{ __('Model') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ class_basename($auditLog->model_type) }} #{{ $auditLog->model_id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900">{{ __('IP Address') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $auditLog->ip_address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Changes -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Changes') }}</h3>
                        @if($auditLog->action == 'create')
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">{{ __('Created Values') }}</label>
                                <div class="bg-white p-3 rounded border">
                                    <pre class="text-xs overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @elseif($auditLog->action == 'update')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-2">{{ __('Old Values') }}</label>
                                    <div class="bg-white p-3 rounded border">
                                        <pre class="text-xs overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-2">{{ __('New Values') }}</label>
                                    <div class="bg-white p-3 rounded border">
                                        <pre class="text-xs overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        @elseif($auditLog->action == 'delete')
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">{{ __('Deleted Values') }}</label>
                                <div class="bg-white p-3 rounded border">
                                    <pre class="text-xs overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- User Agent -->
                @if($auditLog->user_agent)
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">{{ __('User Agent') }}</h3>
                        <p class="text-sm text-gray-900">{{ $auditLog->user_agent }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection