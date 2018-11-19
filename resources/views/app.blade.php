<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <link rel="stylesheet" href="css/app.css"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="app">
        </div>
    </body>
    <script src=" {{ mix('js/app.js') }} "></script>
</html>