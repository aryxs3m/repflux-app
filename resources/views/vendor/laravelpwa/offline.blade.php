@extends('layouts.minimal')

@section('body')
    <x-heroicon-s-globe-europe-africa class="h-30 w-30 mb-5 text-gray-100/30"/>
    <div class="px-5">
        <h1>You are currently not connected to any networks.</h1>
        <h2 class="mb-6 mt-3">Repflux needs Internet connection.</h2>
        <x-button href="/">Retry</x-button>
    </div>
@endsection
