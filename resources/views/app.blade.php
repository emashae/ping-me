@extends('layout')

@section('content')
    <div id="App">
        <div class="container mx-2 my-5">
            <App :auth="{{ json_encode(auth()->user()) }}"/>
        </div>
    </div>
@endsection