@extends('layouts.errors')

@section('title', 'Maintenance')

@section('content')
    <p>We are under maintenance. Please come back later!</p>
    <p class="text-gray-400 animate-pulse mt-5" id="msg">Retrying...</p>

    <script>
        let maintenanceInterval = null;

        window.onload = function () {
            maintenanceInterval = setInterval(testServer, 5000);
        };

        function testServer() {
            fetch('/app').then((result) => {
                if (result.status === 200) {
                    document.getElementById('msg').textContent = 'We are back!';
                    clearInterval(maintenanceInterval);
                    window.location.reload();
                }
            })
        }
    </script>
@endsection
