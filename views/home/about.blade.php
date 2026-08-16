@extends('layouts.app')

@section('title', __('About Us'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('About University Student Talents and Competitions Management System') }}</h1>
                
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4">
                        {{ __('Welcome to our University Student Talents and Competitions Management System, a comprehensive platform designed to nurture and showcase student creativity and innovation. Our system provides a structured environment for students to participate in various talent competitions, receive professional evaluations, and gain recognition for their exceptional abilities.') }}
                    </p>
                    
                    <p class="text-gray-600 mb-6">
                        {{ __('Launched with the vision of fostering a culture of excellence and continuous improvement, our platform connects talented students with experienced competition managers and administrators. We believe that every student has unique talents waiting to be discovered and developed, and our system is designed to support this journey from submission to recognition.') }}
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">{{ __('Our Mission') }}</h2>
                    <p class="text-gray-600 mb-4">
                        {{ __('To empower students by providing a transparent, efficient, and supportive platform for talent development and competition participation. We aim to streamline the submission and evaluation process while maintaining the highest standards of fairness and professionalism.') }}
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">{{ __('Our Vision') }}</h2>
                    <p class="text-gray-600 mb-4">
                        {{ __('To become the premier platform for student talent development in higher education institutions, recognized for innovation, accessibility, and impact on student success.') }}
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">{{ __('Key Features') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-medium text-gray-800 mb-3">{{ __('For Students') }}</h3>
                            <ul class="text-gray-600 space-y-2">
                                <li>• {{ __('Submit talents across multiple categories') }}</li>
                                <li>• {{ __('Track submission status in real-time') }}</li>
                                <li>• {{ __('Receive detailed evaluation feedback') }}</li>
                                <li>• {{ __('Get nominated for special recognition') }}</li>
                                <li>• {{ __('Multilingual interface (Arabic/English)') }}</li>
                            </ul>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-medium text-gray-800 mb-3">{{ __('For Managers & Administrators') }}</h3>
                            <ul class="text-gray-600 space-y-2">
                                <li>• {{ __('Manage competitions and talent categories') }}</li>
                                <li>• {{ __('Evaluate submissions with standardized criteria') }}</li>
                                <li>• {{ __('Generate comprehensive reports and analytics') }}</li>
                                <li>• {{ __('Monitor system activity and user engagement') }}</li>
                                <li>• {{ __('Administer users and permissions') }}</li>
                            </ul>
                        </div>
                    </div>

                    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">{{ __('Contact Information') }}</h2>
                    <p class="text-gray-600">
                        {{ __('For inquiries about the system or technical support, please contact our administration team at') }} 
                        <a href="mailto:support@university.edu" class="text-blue-600 hover:text-blue-800">
                            support@university.edu
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection