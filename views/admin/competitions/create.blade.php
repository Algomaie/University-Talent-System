@extends('layouts.app')

@section('title', __('Create Competition'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                {{-- Header and Back Button --}}
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">{{ __('Create Competition') }}</h2>
                    <a href="{{ route('admin.competitions.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        {{ __('Back to Competitions') }}
                    </a>
                </div>

                <form id="competitionForm" action="{{ route('admin.competitions.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Title (Arabic)') }}</label>
                            <input type="text" name="title_ar" id="title_ar" value="{{ old('title_ar') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-right" dir="rtl">
                            @error('title_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Title (English)') }}</label>
                            <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('title_en')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Start Date') }}</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">{{ __('End Date') }}</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Registration Deadline') }}</label>
                            <input type="date" name="registration_deadline" id="registration_deadline" value="{{ old('registration_deadline') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('registration_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Description (Arabic)') }}</label>
                        <textarea name="description_ar" id="description_ar" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-right" dir="rtl">{{ old('description_ar') }}</textarea>
                        @error('description_ar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Description (English)') }}</label>
                        <textarea name="description_en" id="description_en" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Status') }}</label>
                            <select name="status" id="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Max Submissions Per Student') }}</label>
                            <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="allowed_talents" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Allowed Talents') }}</label>
                            <select multiple name="allowed_talents[]" id="allowed_talents" size="10" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                @foreach($talents as $talent)
                                    <option value="{{ $talent->id }}" {{ is_array(old('allowed_talents')) && in_array($talent->id, old('allowed_talents')) ? 'selected' : '' }}>
                                        {{ $talent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('allowed_talents')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.competitions.index') }}" class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" id="submitBtn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Create Competition') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Prevent any JavaScript from interfering with form submission
document.addEventListener('DOMContentLoaded', function() {
    // Remove any event listeners that might prevent form submission
    const form = document.getElementById('competitionForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Add a simple loading indicator when submitting
    form.addEventListener('submit', function(e) {
        // Don't prevent default - let the form submit normally
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + '{{ __('Creating...') }}';
        
        // Log form submission for debugging
        console.log('Form is being submitted...');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        
        // Log all form data
        const formData = new FormData(form);
        console.log('Form data:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    });
    
    // Log any potential JavaScript errors
    window.addEventListener('error', function(e) {
        console.error('JavaScript error occurred:', e.error);
    });
});
</script>
@endsection