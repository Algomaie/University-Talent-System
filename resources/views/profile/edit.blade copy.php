<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
php artisan breeze:install blade -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Profile Management') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 🧾 تحديث المعلومات العامة --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Profile Information') }}
                </h3>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- 🟢 الحقول العامة للجميع --}}
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $user->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                :value="old('phone', $user->phone)" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        {{-- 🖼️ رفع الصورة الشخصية --}}
                        <div>
                            <x-input-label for="avatar" :value="__('Profile Picture')" />
                            <input type="file" id="avatar" name="avatar" accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-300" />
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="mt-2 h-16 w-16 rounded-full object-cover">
                            @endif
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                        </div>
                    </div>

                    {{-- 🎓 الحقول الخاصة بالطلاب فقط --}}
                    @if ($user->isStudent())
                        <hr class="my-6 border-gray-300 dark:border-gray-700">
                        <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">
                            🎓 {{ __('Academic Information') }}
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="student_id" :value="__('Student ID')" />
                                <x-text-input id="student_id" name="student_id" type="text" class="mt-1 block w-full"
                                    :value="old('student_id', $user->student_id)" />
                            </div>

                            <div>
                                <x-input-label for="department" :value="__('Department')" />
                                <x-text-input id="department" name="department" type="text" class="mt-1 block w-full"
                                    :value="old('department', $user->department)" />
                            </div>

                            <div>
                                <x-input-label for="major" :value="__('Major')" />
                                <x-text-input id="major" name="major" type="text" class="mt-1 block w-full"
                                    :value="old('major', $user->major)" />
                            </div>

                            <div>
                                <x-input-label for="academic_level" :value="__('Academic Level')" />
                                <select id="academic_level" name="academic_level"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                                           focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">
                                    <option value="">{{ __('Select Level') }}</option>
                                    @foreach (['Freshman', 'Sophomore', 'Junior', 'Senior', 'Graduate'] as $level)
                                        <option value="{{ $level }}" {{ old('academic_level', $user->academic_level) == $level ? 'selected' : '' }}>
                                            {{ __($level) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('academic_level')" />
                            </div>

                            <div>
                                <x-input-label for="year_of_study" :value="__('Year of Study')" />
                                <x-text-input id="year_of_study" name="year_of_study" type="number" class="mt-1 block w-full"
                                    :value="old('year_of_study', $user->year_of_study)" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="interests" :value="__('Interests')" />
                                <textarea id="interests" name="interests" rows="3"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                                           focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">{{ old('interests', $user->interests) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('interests')" />
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 2000)"
                               class="text-sm text-green-600 dark:text-green-400">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- 🔒 تحديث كلمة المرور --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('profile.partials.update-password-form')
            </div>

            {{-- 🗑️ حذف الحساب --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    // 🖼️ تغيير صورة الملف الشخصي
    document.getElementById('avatar').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };

        reader.readAsDataURL(file);
    })