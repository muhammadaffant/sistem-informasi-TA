<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VIMS | @yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('/templates/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/templates/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('/templates/assets/modules/summernote/summernote-bs4.css') }}">

    <!-- Tambahkan ini di bagian <head> untuk file CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('/templates/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/templates/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/templates/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('/templates/plugin/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/templates') }}/assets/modules/select2/dist/css/select2.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('/templates/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/templates/assets/css/components.css') }}">

    @stack('css')


    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->

    @stack('css_vendor')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('partials.header')
            @include('partials.sidebar')

            <!-- Main Content -->
            @yield('content')
        </div>
        @include('partials.footer')
    </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('/templates/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('/templates/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/templates') }}/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('/templates/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('/templates/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('/templates/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('/templates/assets/js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('/templates/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('/templates/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('/templates') }}/assets/modules/select2/dist/js/select2.full.min.js"></script>
    <!-- DataTables JS -->
    <script src="{{ asset('/templates/assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/templates/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('/templates/assets/js/page/modules-datatables.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('/templates/plugin/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/templates/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/templates/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <!-- Page Specific JS Files -->
    {{--  <script src="{{ asset('/templates/assets/js/page/index-0.js') }}"></script>  --}}

    @stack('scripts_vendor')

    <!-- Template JS File -->
    <script src="{{ asset('/templates/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('/templates/js/custome.js') }}"></script>

    <script>
        $(function() {
            $('#spinner-border').hide();
        });
    </script>

    @stack('scripts')
</body>

</html>
