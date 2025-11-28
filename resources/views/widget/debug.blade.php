<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repflux Widget Demo</title>
    <style>
    </style>
</head>
<body>

    <div style="border: 1px dashed gray; display: inline-block">
        <iframe
            id="repflux-widget"
            title="Repflux Widget"
            width="350"
            height="500"
            allowtransparency="true" frameborder="0"
            src="{{ $url }}">
        </iframe>
    </div>

    <p><strong>Source: </strong> {{ $url }}</p>


</body>
</html>
