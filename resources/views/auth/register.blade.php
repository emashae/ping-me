@extends('layout')

@section('content')
    <div class="flex items-center justify-center h-screen bg-gray-100">
        <div class="w-full sm:max-w-md bg-white shadow-lg rounded-lg p-8">
            <!-- Display Session Error Message -->
            @if(session('error'))
                <div class="text-red-500 mb-4">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900">Full Name *</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" 
                            placeholder="Enter your full name" 
                            aria-required="true" 
                            aria-invalid="@error('name') true @else false @enderror"
                        >
                        @error('name')
                            <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">Email *</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" 
                            placeholder="Enter your email" 
                            aria-required="true" 
                            aria-invalid="@error('email') true @else false @enderror"
                        >
                        @error('email')
                            <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900">Password *</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" 
                            placeholder="Enter your password" 
                            aria-required="true" 
                            aria-invalid="@error('password') true @else false @enderror"
                        >
                        @error('password')
                            <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">
                            Password must be at least 8 characters long and include a mix of letters, numbers, and special characters.
                        </p>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Confirm Password *</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" 
                            placeholder="Confirm your password" 
                            aria-required="true" 
                            aria-invalid="@error('password_confirmation') true @else false @enderror"
                        >
                        @error('password_confirmation')
                            <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button 
                        type="submit" 
                        class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
