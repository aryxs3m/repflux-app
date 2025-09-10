@extends('layouts.minimal')

@section('body')
    <div class="container text-center m-auto">
        <img src="/logos/logo-black.svg" alt="gymBro" class="m-auto mb-10">
        <h1 class="text-3xl font-bold">@yield('title')</h1>

        @yield('content')

        <div class="mt-10 text-center">
            <p class="text-sm text-gray-400">{{ config('app.name') }} {{ date('Y') }}</p>
        </div>
    </div>
@endsection
