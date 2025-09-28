@extends('layouts.minimal')

@section('body')
    <h1>You are currently not connected to any networks.</h1>
    <h2 class="mb-3">Repflux needs Internet connection.</h2>
    <x-button href="/">Retry</x-button>
@endsection
