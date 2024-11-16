@extends('layout')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-start-2 col-span-4">
                <div class="px-4 sm:px-0">
                    <h2 class="text-gray-900 text-4xl text-center">Register</h2>
                </div>
            </div>
            <div class="col-start-2 col-span-4">
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name *</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="name" 
                                        value="{{ old('name') }}" 
                                        class="flex-1 rounded-r-md ring-1 ring-inset py-1.5 px-2 text-gray-900 ring-indigo-600" 
                                        autofocus
                                        placeholder="Enter your full name"
                                        aria-required="true" 
                                        aria-invalid="@error('name') true @else false @enderror"
                                    >
                                </div>
                                @error('name')
                                    <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

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
                                        placeholder="Enter your email"
                                        aria-required="true" 
                                        aria-invalid="@error('email') true @else false @enderror"
                                    >
                                </div>
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
                                        placeholder="Enter your password"
                                        aria-required="true" 
                                        aria-invalid="@error('password') true @else false @enderror"
                                    >
                                </div>
                                @error('password')
                                    <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <p class="text-sm text-gray-500 mt-1">
                                    Password must be at least 8 characters long and include a mix of letters, numbers, and special characters.
                                </p>
                            </div>

                            <!-- Password Confirmation Field -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password *</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input 
                                        type="password" 
                                        name="password_confirmation" 
                                        id="password_confirmation" 
                                        class="flex-1 rounded-r-md ring-1 ring-inset py-1.5 px-2 text-gray-900 ring-indigo-600" 
                                        placeholder="Confirm your password"
                                        aria-required="true" 
                                        aria-invalid="@error('password_confirmation') true @else false @enderror"
                                    >
                                </div>
                                @error('password_confirmation')
                                    <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="bg-gray-50 px-4 py-3 text-center sm:px-6">
                            <button 
                                type="submit" 
                                class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
