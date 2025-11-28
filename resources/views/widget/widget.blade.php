<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repflux Widget</title>
    @vite('resources/scss/widget.css')
</head>
<body class="bg-black/80 text-white/95">
    <div class="bg-black w-100h p-5 shadow-2xl">
        <img src="/logos/widget_repflux_logo.png" alt="Repflux">
    </div>
    <div class="container mx-auto p-3">
        <div>
            <div class="font-bold">Last Workout</div>
            <div>{{ $data['last_workout'] }}</div>
        </div>

        <hr class="my-3 border-gray-400">

        <div class="font-bold">Top PRs</div>

        <div class="flex flex-col gap-2 mt-3">
            @foreach($data['last_prs'] as $pr)
                <div class="flex justify-between">
                    <div>{{ $pr['exercise'] }}</div>
                    <div class="font-bold">{{ $pr['weight'] }} {{ $pr['unit'] }}</div>
                </div>
            @endforeach
        </div>

        <x-button href="https://repflux.cloud">Join Repflux</x-button>
    </div>
</body>
</html>
