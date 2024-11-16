@extends('layout')

@section('content')
    <div class="flex items-center justify-center h-screen bg-gray-100">
        <div class="w-full sm:max-w-md bg-white shadow-lg rounded-lg p-8">
            <!-- Display Session Error Message -->
            @if(session('error'))
                <div class="text-red-500 mb-4">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="space-y-6">
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
                        />
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
                        />
                        @error('password')
                            <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button 
                        type="submit" 
                        class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
