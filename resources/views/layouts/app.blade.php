<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles()
    <title>Rocketseat - Experts Club</title>
</head>
<body>
    {{ $slot }}

    <script src="{{ mix('js/app.js') }}"></script>
    @livewireScripts()
</body>
</html>
