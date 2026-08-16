@extends('layouts.app')

@section('title', __('Edit Submission'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Edit Submission') }}</h2>
                    <a href="{{ route('student.submissions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Submissions') }}
                    </a>
                </div>

                <form action="{{ route('student.submissions.update', $submission) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="competition_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Competition') }}</label>
                            <select name="competition_id" id="competition_id" disabled class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 bg-gray-100">
                                <option value="{{ $submission->competition_id }}">{{ $submission->competition->title }}</option>
                            </select>
                            <input type="hidden" name="competition_id" value="{{ $submission->competition_id }}">
                        </div>

                        <div>
                            <label for="talent_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Talent Category') }}</label>
                            <select name="talent_id" id="talent_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                @foreach($talents as $talent)
                                    <option value="{{ $talent->id }}" {{ old('talent_id', $submission->talent_id) == $talent->id ? 'selected' : '' }}>
                                        {{ $talent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('talent_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Title') }}</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $submission->title) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Description') }}</label>
                        <textarea name="description" id="description" rows="5" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('description', $submission->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Existing Files -->
                    @if($submission->files && count($submission->files) > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Current Files') }}</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($submission->files as $file)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-file mr-2 text-gray-500"></i>
                                            <span class="text-sm text-gray-700">{{ basename($file) }}</span>
                                        </div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="remove_files[]" value="{{ $file }}" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-red-600">{{ __('Remove') }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- File Upload -->
                    <div class="mb-6">
                        <label for="files" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Add More Files') }}</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="files" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>{{ __('Upload files') }}</span>
                                        <input id="files" name="files[]" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">{{ __('or drag and drop') }}</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    {{ __('PDF, PNG, JPG, MP4 up to 20MB') }}
                                </p>
                            </div>
                        </div>
                        @error('files.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('student.submissions.index') }}" class="mr-3 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Update Submission') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection