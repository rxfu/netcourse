<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="广西师范大学助教申请网络课程">
        <meta name="author" content="Fu Rongxin">

        <title>网络课程助教申请系统</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    </head>

    <body>
        <div id="app"></div>

        <script src="{{ asset(mix('js/app.js')) }}"></script>
    </body>
</html>
