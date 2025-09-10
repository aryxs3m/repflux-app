@extends('layouts.errors')

@section('title', 'Server Error')

@section('content')
    <p>We've encountered an error. We will investigate this soon or later, but if<br>the error persists, please contact us!</p>

    <div class="mt-4">
        <a href="mailto:info@pvga.hu" class="bg-orange-300 px-3 py-2 rounded-md inline-block hover:bg-orange-500 shadow-md transition-colors duration-200 ease-in-out">Contact</a>
    </div>
@endsection
