@extends('layouts.app')

@section('title', __('Create Competition'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Create New Competition') }}</h2>
                    <a href="{{ route('manager.competitions.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Competitions') }}
                    </a>
                </div>

                <form action="{{ route('manager.competitions.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Arabic Title -->
                        <div>
                            <label for="title_ar" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Title (Arabic)') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title_ar" 
                                   id="title_ar" 
                                   value="{{ old('title_ar') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('title_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- English Title -->
                        <div>
                            <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Title (English)') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title_en" 
                                   id="title_en" 
                                   value="{{ old('title_en') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('title_en')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arabic Description -->
                        <div>
                            <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Description (Arabic)') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description_ar" 
                                      id="description_ar" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                      required>{{ old('description_ar') }}</textarea>
                            @error('description_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- English Description -->
                        <div>
                            <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Description (English)') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description_en" 
                                      id="description_en" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                      required>{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Start Date') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="start_date" 
                                   id="start_date" 
                                   value="{{ old('start_date') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('End Date') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="end_date" 
                                   id="end_date" 
                                   value="{{ old('end_date') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Registration Deadline -->
                        <div>
                            <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Registration Deadline') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="registration_deadline" 
                                   id="registration_deadline" 
                                   value="{{ old('registration_deadline') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('registration_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Max Participants -->
                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Max Participants') }}
                            </label>
                            <input type="number" 
                                   name="max_participants" 
                                   id="max_participants" 
                                   value="{{ old('max_participants') }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Status') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="status" 
                                    id="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Allowed Talents -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Allowed Talents') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($talents as $talent)
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="allowed_talents[]" 
                                               id="talent_{{ $talent->id }}" 
                                               value="{{ $talent->id }}"
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                               {{ in_array($talent->id, old('allowed_talents', [])) ? 'checked' : '' }}>
                                        <label for="talent_{{ $talent->id }}" class="ml-2 block text-sm text-gray-700">
                                            {{ $talent->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('allowed_talents')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Evaluation Criteria -->
                        <div class="md:col-span-2">
                            <label for="evaluation_criteria" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Evaluation Criteria') }}
                            </label>
                            <textarea name="evaluation_criteria" 
                                      id="evaluation_criteria" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="{{ __('Enter evaluation criteria and guidelines for evaluators...') }}">{{ old('evaluation_criteria') }}</textarea>
                            @error('evaluation_criteria')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('manager.competitions.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 mr-2">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            {{ __('Create Competition') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate dates
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const registrationDeadline = document.getElementById('registration_deadline');
    
    function validateDates() {
        if (startDate.value && endDate.value && new Date(startDate.value) >= new Date(endDate.value)) {
            endDate.setCustomValidity('{{ __('End date must be after start date') }}');
        } else {
            endDate.setCustomValidity('');
        }
        
        if (registrationDeadline.value && endDate.value && new Date(registrationDeadline.value) >= new Date(endDate.value)) {
            registrationDeadline.setCustomValidity('{{ __('Registration deadline must be before end date') }}');
        } else {
            registrationDeadline.setCustomValidity('');
        }
    }
    
    startDate.addEventListener('change', validateDates);
    endDate.addEventListener('change', validateDates);
    registrationDeadline.addEventListener('change', validateDates);
});
</script>
@endsection