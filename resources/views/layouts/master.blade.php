<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ $title ?? 'Kasir - Dashboard Admin'}} </title>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('backend/assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('backend/assets/img/favicon.png')}}">

    <!-- CSS Files -->
    <link href="{{asset('backend/assets/css/material-dashboard.css')}}" rel="stylesheet" />

    {{-- Css for one page --}}
    @yield('css')
</head>

<body class="">
    <div class="wrapper ">

        @include('dashboard.components.side')

        <div class="main-panel">
            @include('dashboard.components.top')

            @yield('content')

            @include('dashboard.components.footer')
        </div>

    </div>
    <div class="fixed-plugin">
        @include('dashboard.components.config')
    </div>
    <!--   Core JS Files   -->
    <script src="{{asset('backend/assets/js/core/jquery.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/core/bootstrap-material-design.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>

    <!-- Plugin for the momentJs  -->
    {{-- <script src="{{asset('backend/assets/js/plugins/moment.min.js')}}"></script> --}}
    <!-- Forms Validations Plugin -->
    <script src="{{asset('backend/assets/js/plugins/jquery.validate.min.js')}}"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{asset('backend/assets/js/plugins/jquery.bootstrap-wizard.js')}}"></script>
    <script src="{{asset('backend/assets/js/plugins/jasny-bootstrap.min.js')}}"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{asset('backend/assets/js/plugins/jquery-jvectormap.js')}}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{asset('backend/assets/js/plugins/nouislider.min.js')}}"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{asset('backend/assets/js/plugins/arrive.min.js')}}"></script>
    <!-- Chartist JS -->
    <script src="{{asset('backend/assets/js/plugins/chartist.min.js')}}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{asset('backend/assets/js/plugins/bootstrap-notify.js')}}"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('backend/assets/js/material-dashboard.js?v=2.1.2')}}" type="text/javascript"></script>

    {{-- js custom for one page --}}
    @yield('scripts')

    {{-- script for general --}}
    @include('dashboard.scripts.home')

</body>

</html>
