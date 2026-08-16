@extends('layouts.app')

@section('title', __('Database Backups'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Database Backups') }}</h2>
                    <form action="{{ route('admin.backups.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create Backup') }}
                        </button>
                    </form>
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

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Filename') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Size') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Date') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($backupList as $backup)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $backup['name'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ number_format($backup['size'] / 1024, 2) }} KB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ date('Y-m-d H:i:s', $backup['modified']) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.backups.download', $backup['name']) }}" class="text-primary-600 hover:text-primary-900 mr-3">
                                            {{ __('Download') }}
                                        </a>
                                        <form action="{{ route('admin.backups.restore', $backup['name']) }}" method="POST" class="inline-block mr-3">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" 
                                                    onclick="return confirm('{{ __('Are you sure you want to restore this backup? This will overwrite your current database.') }}')">
                                                {{ __('Restore') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.backups.destroy', $backup['name']) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this backup?') }}')">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        {{ __('No backups found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-blue-800 mb-2">{{ __('Important Notes') }}</h3>
                    <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                        <li>{{ __('Backups are stored locally on the server.') }}</li>
                        <li>{{ __('Restoring a backup will overwrite your current database.') }}</li>
                        <li>{{ __('Always download important backups to external storage.') }}</li>
                        <li>{{ __('Regular backups are recommended for production environments.') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection