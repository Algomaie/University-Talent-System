@extends('layouts.app')

@section('content')
<div class="py-10 ">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        {{-- 🧾 عنوان الصفحة --}}
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">{{ __('Profile Management') }}</h2>
        </div>

        {{-- 🧾 نموذج تعديل البيانات العامة --}}
        <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Profile Information') }}
            </h3>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- الاسم الكامل --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Full Name') }}
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- البريد الإلكتروني --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Email Address') }}
                        </label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- رقم الهاتف --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Phone Number') }}
                        </label>
                        <input type="text" name="phone" id="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- الصورة الشخصية --}}
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Profile Picture') }}
                        </label>
                        <input type="file" name="avatar" id="avatar" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-300">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="mt-2 h-16 w-16 rounded-full object-cover" alt="Avatar">
                        @endif
                        @error('avatar') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- 🎓 معلومات الطلاب --}}
                @if ($user->isStudent())
                <hr class="my-6 border-gray-300 dark:border-gray-700">
                <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">
                    🎓 {{ __('Academic Information') }}
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Student ID') }}
                        </label>
                        <input type="text" name="student_id" id="student_id"
                            value="{{ old('student_id', $user->student_id) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Department') }}
                        </label>
                        <input type="text" name="department" id="department"
                            value="{{ old('department', $user->department) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="major" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Major') }}
                        </label>
                        <input type="text" name="major" id="major"
                            value="{{ old('major', $user->major) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="academic_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Academic Level') }}
                        </label>
                        <select id="academic_level" name="academic_level"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">{{ __('Select Level') }}</option>
                            @foreach (['Freshman', 'Sophomore', 'Junior', 'Senior', 'Graduate'] as $level)
                                <option value="{{ $level }}" {{ old('academic_level', $user->academic_level) == $level ? 'selected' : '' }}>
                                    {{ __($level) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="year_of_study" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Year of Study') }}
                        </label>
                        <input type="number" name="year_of_study" id="year_of_study"
                            value="{{ old('year_of_study', $user->year_of_study) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="interests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Interests') }}
                        </label>
                        <textarea id="interests" name="interests" rows="3"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('interests', $user->interests) }}</textarea>
                    </div>
                </div>
                @endif

                {{-- حفظ التغييرات --}}
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring">
                        {{ __('Save Changes') }}
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p class="text-green-500 text-sm">{{ __('Saved successfully!') }}</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- 🔒 كلمة المرور --}}
        <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            @include('profile.partials.update-password-form')
        </div>

        {{-- 🗑️ حذف الحساب --}}
        <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</div>
@endsection
