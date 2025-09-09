<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        html, body {
            background-color: #111;
            color: #ccc;
            font-family: 'Nunito', sans-serif;
        }

        .container {
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 100px;
        }

        a {
            color: white;
            text-decoration: none;
            display: inline-block;
            padding: 10px;
            background: #111;
            width: 100px;
            text-align: center;
            border: 2px solid chocolate;
        }

        a:hover {
            background: #222;
            border: 2px solid orange;
        }
    </style>
</head>
<body>
    @yield('body')
</body>
</html>
