@extends('layout')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-start-2 col-span-4">
                <div class="px-4 sm:px-0">
                    <h2 class="text-gray-900 text-4xl text-center">Login</h2>
                </div>
            </div>
            <div class="col-start-2 col-span-4">
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <!-- Display Session Error Message -->
                    @if(session('error'))
                        <div class="text-red-500 mt-2 mx-4">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email *</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        value="{{ old('email') }}"  
                                        class="flex-1 rounded-r-md ring-1 ring-inset py-1.5 px-2 text-gray-900 ring-indigo-600" 
                                        placeholder="Enter your email">
                                </div>
                                <!-- Email validation error -->
                                @error('email')
                                    <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password *</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input 
                                        type="password" 
                                        name="password" 
                                        id="password" 
                                        class="flex-1 rounded-r-md ring-1 ring-inset py-1.5 px-2 text-gray-900 ring-indigo-600" 
                                        placeholder="Enter your password">
                                </div>
                                <!-- Password validation error -->
                                @error('password')
                                    <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="bg-gray-50 px-4 py-3 text-center sm:px-6">
                            <button 
                                type="submit" 
                                class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
