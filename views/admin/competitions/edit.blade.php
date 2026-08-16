@extends('layouts.app')

@section('title', __('Edit Competition'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Edit Competition') }}</h2>
                    <a href="{{ route('admin.competitions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Competitions') }}
                    </a>
                </div>

                <form action="{{ route('admin.competitions.update', $competition) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Title (Arabic)') }}</label>
                            <input type="text" name="title_ar" id="title_ar" value="{{ old('title_ar', $competition->title_ar) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('title_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Title (English)') }}</label>
                            <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $competition->title_en) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('title_en')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Start Date') }}</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $competition->start_date->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">{{ __('End Date') }}</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $competition->end_date->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Registration Deadline') }}</label>
                            <input type="date" name="registration_deadline" id="registration_deadline" value="{{ old('registration_deadline', $competition->registration_deadline->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('registration_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Description (Arabic)') }}</label>
                        <textarea name="description_ar" id="description_ar" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('description_ar', $competition->description_ar) }}</textarea>
                        @error('description_ar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Description (English)') }}</label>
                        <textarea name="description_en" id="description_en" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('description_en', $competition->description_en) }}</textarea>
                        @error('description_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="allowed_talents" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Allowed Talents') }}</label>
                        <select multiple name="allowed_talents[]" id="allowed_talents" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @foreach($talents as $talent)
                                <option value="{{ $talent->id }}" {{ in_array($talent->id, old('allowed_talents', $selectedTalents)) ? 'selected' : '' }}>
                                    {{ $talent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('allowed_talents')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Status') }}</label>
                            <select name="status" id="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="draft" {{ old('status', $competition->status) == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                <option value="active" {{ old('status', $competition->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="closed" {{ old('status', $competition->status) == 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Max Submissions Per Student') }}</label>
                            <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $competition->max_participants) }}" min="1" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.competitions.index') }}" class="mr-3 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Update Competition') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection