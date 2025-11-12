<html lang="en" class="bg-black text-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite('resources/scss/app.css')
</head>
<body>
<div class="container mx-auto px-4 mt-10">
    @yield('body')
</div>
</body>
</html>
