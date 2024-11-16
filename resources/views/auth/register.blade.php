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
                    <form method="post" action="{{ route('register.post') }}">
                        @csrf
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <div>
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name *</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input type="text" name="name" id="name" class=" flex-1 rounded-r-md ring-1 ring-inset py-1.5 px-2 text-gray-900 ring-indigo-600" autofocus value="{{ old('name') }}">
                                </div>
                                @if($errors->has('name'))
                                    <div class="text-red-700 text-sm mt-1">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email *</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input type="text" name="email" id="email" class="flex-1 rounded-r-md ring-1 ring-inset py-1.5 px-2 text-gray-900 ring-indigo-600" placeholder="" value="{{ old('email') }}">
                                </div>
                                @if($errors->has('email'))
                                    <div class="text-red-700 text-sm mt-1">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password *</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input type="password" name="password" id="password" class="flex-1 rounded-r-md ring-1 ring-inset py-1.5 px-2 text-gray-900 ring-indigo-600" placeholder="">
                                </div>
                                @if($errors->has('password'))
                                    <div class="text-red-700 text-sm mt-1">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-center sm:px-6">
                            <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Register</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
