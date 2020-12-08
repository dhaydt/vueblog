<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vue-Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <link rel="stylesheet" type="text/css" href="/css/all.css">

    <script>
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>
</head>
<body>
    <div id="app">
    @if(Auth::check())
        <mainapp :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></mainapp>
    @else
        <mainapp :user="false"></mainapp>
    @endif
    </div>
</body>
    <script src="{{mix('/js/app.js')}}"></script>


</html>
