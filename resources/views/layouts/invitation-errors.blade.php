@extends('layouts.minimal')

@section('body')
    <div class="container">
        <h2>Invitation error</h2>
        <hr>
        @yield('content')

        <a href="/app" class="btn">Register your own</a>
    </div>
@endsection
