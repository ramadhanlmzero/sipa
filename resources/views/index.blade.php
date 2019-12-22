<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPA UNESA</title>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body>
    <div id="app"></div>

    <style>
        .fade-enter-active, .fade-leave-active {
            transition-property: opacity;
            transition-duration: .50s;
        }
        
        .fade-enter-active {
            transition-delay: .50s;
        }
        
        .fade-enter, .fade-leave-active {
            opacity: 0
        }
    </style>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('assets/js/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/js/morris.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-show-password.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>

</html>