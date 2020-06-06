<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Helixtap Assignment</title>
</head>
<body>
    <div id='app'>
    </div>
    <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
