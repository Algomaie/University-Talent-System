@extends('layouts.app')

@section('title', __('Evaluate Submission'))

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Evaluate Submission') }}</h2>
                    <a href="{{ route('manager.evaluations.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Evaluations') }}
                    </a>
                </div>

                <form action="{{ route('manager.evaluations.store', $submission) }}" method="POST" id="evaluationForm">
                    @csrf

                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Student Information') }}</h3>
                                <div class="space-y-2" style="
    color: rebeccapurple;">
                                    <p><strong>{{ __('Name:') }}</strong> {{ $submission->user->name }}</p>
                                    <p><strong>{{ __('Student ID:') }}</strong> {{ $submission->user->student_id }}</p>
                                    <p><strong>{{ __('Department:') }}</strong> {{ $submission->user->department }}</p>
                                    <p><strong>{{ __('Academic Level:') }}</strong> {{ $submission->user->academic_level }}</p>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Submission Information') }}</h3>
                                <div class="space-y-2">
                                    <p><strong>{{ __('Title:') }}</strong> {{ $submission->title }}</p>
                                    <p><strong>{{ __('Competition:') }}</strong> {{ $submission->competition->title }}</p>
                                    <p><strong>{{ __('Talent:') }}</strong> {{ $submission->talent->name }}</p>
                                    <p><strong>{{ __('Submission ID:') }}</strong> {{ $submission->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Evaluation Criteria') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="creativity_score" class="block text-sm font-medium text-gray-700">{{ __('Creativity (1-10)') }}</label>
                                <input type="number" id="creativity_score" name="creativity_score" value="{{ old('creativity_score') }}" required min="1" max="10" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('creativity_score')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="technical_score" class="block text-sm font-medium text-gray-700">{{ __('Technical Skill (1-10)') }}</label>
                                <input type="number" id="technical_score" name="technical_score" value="{{ old('technical_score') }}" required min="1" max="10" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('technical_score')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="presentation_score" class="block text-sm font-medium text-gray-700">{{ __('Presentation (1-10)') }}</label>
                                <input type="number" id="presentation_score" name="presentation_score" value="{{ old('presentation_score') }}" required min="1" max="10" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('presentation_score')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="comments" class="block text-sm font-medium text-gray-700">{{ __('Comments') }}</label>
                            <textarea id="comments" name="comments" rows="5" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('comments') }}</textarea>
                            @error('comments')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_nominated" name="is_nominated" type="checkbox" value="1" {{ old('is_nominated') ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_nominated" class="font-medium text-gray-700">{{ __('Nominate this submission for the next stage') }}</label>
                                    <p class="text-gray-500">{{ __('Nominated submissions will be reviewed by the administration for final approval.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div id="nomination_reason_container" class="mb-6 {{ old('is_nominated') ? '' : 'hidden' }}">
                            <label for="nomination_reason" class="block text-sm font-medium text-gray-700">{{ __('Reason for Nomination') }}</label>
                            <textarea id="nomination_reason" name="nomination_reason" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('nomination_reason') }}</textarea>
                            @error('nomination_reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('manager.evaluations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Submit Evaluation') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Show/hide nomination reason field based on checkbox
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('is_nominated');
    const container = document.getElementById('nomination_reason_container');
    const reasonField = document.getElementById('nomination_reason');
    
    // Initialize state based on checkbox
    if (checkbox && checkbox.checked) {
        container.classList.remove('hidden');
        reasonField.required = true;
    }
    
    // Add event listener
    if (checkbox) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                container.classList.remove('hidden');
                reasonField.required = true;
            } else {
                container.classList.add('hidden');
                reasonField.required = false;
            }
        });
    }
    
    // Add form submission logging
    const form = document.getElementById('evaluationForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form is being submitted');
            console.log('Submission ID:', '{{ $submission->id }}');
            console.log('Form action:', this.action);
            
            // Log form data
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
        });
    }
});
</script>
@endsection