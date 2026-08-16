<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Student Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your student profile information including your major, year of study, and interests.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Student-specific fields -->
        <div>
            <x-input-label for="student_id" :value="__('Student ID')" />
            <x-text-input id="student_id" name="student_id" type="text" class="mt-1 block w-full" :value="old('student_id', $user->student_id)" />
            <x-input-error class="mt-2" :messages="$errors->get('student_id')" />
        </div>

        <div>
            <x-input-label for="major" :value="__('Major')" />
            <x-text-input id="major" name="major" type="text" class="mt-1 block w-full" :value="old('major', $user->major)" />
            <x-input-error class="mt-2" :messages="$errors->get('major')" />
        </div>

        <div>
            <x-input-label for="year_of_study" :value="__('Year of Study')" />
            <select id="year_of_study" name="year_of_study" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">{{ __('Select Year') }}</option>
                <option value="1" {{ old('year_of_study', $user->year_of_study) == 1 ? 'selected' : '' }}>{{ __('First Year') }}</option>
                <option value="2" {{ old('year_of_study', $user->year_of_study) == 2 ? 'selected' : '' }}>{{ __('Second Year') }}</option>
                <option value="3" {{ old('year_of_study', $user->year_of_study) == 3 ? 'selected' : '' }}>{{ __('Third Year') }}</option>
                <option value="4" {{ old('year_of_study', $user->year_of_study) == 4 ? 'selected' : '' }}>{{ __('Fourth Year') }}</option>
                <option value="5" {{ old('year_of_study', $user->year_of_study) == 5 ? 'selected' : '' }}>{{ __('Fifth Year') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('year_of_study')" />
        </div>

        <div>
            <x-input-label for="interests" :value="__('Interests (comma separated)')" />
            <x-text-input id="interests" name="interests" type="text" class="mt-1 block w-full" :value="old('interests', $user->interests)" placeholder="{{ __('e.g. Music, Art, Sports') }}" />
            <x-input-error class="mt-2" :messages="$errors->get('interests')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>