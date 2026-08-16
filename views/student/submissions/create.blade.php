@extends('layouts.app')

@section('title', __('Submit Talent'))

@section('content')
<div class="py-12" style=" color: black !important;">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Submit Your Talent') }}</h2>

                <form action="{{ route('student.submissions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if($competition)
                        <input type="hidden" name="competition_id" value="{{ $competition->id }}">
                        <div class="mb-4 p-4 bg-blue-50 rounded-md">
                            <p class="text-sm text-blue-800">{{ __('You are submitting to competition:') }} <strong>{{ $competition->title }}</strong></p>
                        </div>
                    @else
                        <div class="mb-4">
                            <label for="competition_id" class="block text-sm font-medium text-gray-700">{{ __('Competition') }}</label>
                            <select id="competition_id" name="competition_id" required onchange="loadAllowedTalents()" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">{{ __('Select Competition') }}</option>
                                @foreach($competitions as $comp)
                                    <option value="{{ $comp->id }}" {{ old('competition_id') == $comp->id ? 'selected' : '' }}>{{ $comp->title }}</option>
                                @endforeach
                            </select>
                            @error('competition_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="talent_id" class="block text-sm font-medium text-gray-700">{{ __('Talent Type') }}</label>
                        <select id="talent_id" name="talent_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">{{ __('Select Talent Type') }}</option>
                        </select>
                        @error('talent_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                        <input type="text" id="title" name="title" required value="{{ old('title') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                        <textarea id="description" name="description" rows="5" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="files" class="block text-sm font-medium text-gray-700">{{ __('Files (Images, Videos, PDFs)') }}</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4h4a4 4 0 004-4v-4m-12-4l-3.172-3.172a4 4 0 00-5.656 0L8 16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="files" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>{{ __('Upload files') }}</span>
                                        <input id="files" name="files[]" type="file" multiple class="sr-only" accept="image/*,video/*,.pdf">
                                    </label>
                                    <p class="pl-1">{{ __('or drag and drop') }}</p>
                                </div>
                                <p class="text-xs text-gray-500">{{ __('PNG, JPG, GIF, MP4, MOV, AVI, PDF up to 20MB') }}</p>
                            </div>
                        </div>
                        @error('files.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('student.submissions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function loadAllowedTalents() {
    const competitionId = document.getElementById('competition_id').value;
    if (!competitionId) return;
    
    fetch(`/api/competitions/${competitionId}/talents`)
        .then(response => response.json())
        .then(talents => {
            const talentSelect = document.getElementById('talent_id');
            // Clear existing options except the first one
            while (talentSelect.options.length > 1) {
                talentSelect.remove(1);
            }
            
            talents.forEach(talent => {
                const option = document.createElement('option');
                option.value = talent.id;
                option.textContent = talent.name_en;
                talentSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Load talents if competition is pre-selected
@if($competition)
window.addEventListener('DOMContentLoaded', function() {
    loadAllowedTalents();
});
@endif
</script>
@endsection