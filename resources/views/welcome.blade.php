@extends('layouts.minimal')

@section('body')
    <div class="container">
        <img src="/logos/repflux_logo_black_transparent.png" style="width: 200px;" alt="{{ config('app.name') }}">
        <h1 class="text-3xl font-bold mt-4">Coming soon!</h1>

        <div class="mt-4">
            <x-button href="/app">Preview login</x-button>
            <x-button href="https://github.com/aryxs3m/repflux-app">GitHub</x-button>
            <x-button href="mailto:info@pvga.hu">Contact</x-button>
        </div>

        <hr class="my-4">

        <p>{{ config('app.version') }} | {{ \App\Services\VersionService::getVersion() }}</p>
    </div>
@endsection
