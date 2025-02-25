<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{--    Bootstrap CND--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>--}}

    {{--    Bootrstap & eigen sass --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    {{--Favicon--}}
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
    <link rel="manifest" href="/assets/icons/site.webmanifest">
    <link rel="mask-icon" href="/assets/icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    {{--    <title>The Vinyl shop</title>--}}
    {{--    Hier komt een gat en da moet straks opgevuld worden--}}
    <title>@yield('title', 'The Vinyl Shop')</title>
</head>
<body>
{{--  Navigation  --}}
@include('shared.navigation')

<main class="container mt-3">
    {{--    <p>Page under construction...</p>--}}
    @yield('main', 'Page under construction ...')
</main>
{{--  Footer  --}}
@include('shared.footer')


<script src="{{ mix('js/app.js') }}"></script>
@yield('script_after')
{{--Global no validate on forms during debugging (testing/making)--}}
@if(env('APP_DEBUG'))
    <script>
        // On evry form add the novalidate attribute
        $('form').attr('novalidate', 'true');
    </script>
@endif
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>--}}
</body>
</html>
