<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VIMS | @yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="/templates/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/templates/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/templates/assets/modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="/templates/assets/modules/weather-icon/css/weather-icons.min.css">
    <link rel="stylesheet" href="/templates/assets/modules/weather-icon/css/weather-icons-wind.min.css">
    <link rel="stylesheet" href="/templates/assets/modules/summernote/summernote-bs4.css">

    <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">


    <!-- Template CSS -->
    <link rel="stylesheet" href="/templates/assets/css/style.css">
    <link rel="stylesheet" href="/templates/assets/css/components.css">

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
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
             @include('partials.header')
            @include('partials.sidebar')

            <!-- Main Content -->
            @yield('content')
            <footer class="main-footer" style="background-color: #ffffff">
                <div class="footer-left" id="copyright" style="color: black">
                    Copyright &copy;<div class="bullet"></div><a
                        href="https://www.instagram.com/muhammaduppan/">Affan</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="/templates/assets/modules/jquery.min.js"></script>
    <script src="/templates/assets/modules/popper.js"></script>
    <script src="/templates/assets/modules/tooltip.js"></script>
    <script src="/templates/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="/templates/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="/templates/assets/modules/moment.min.js"></script>
    <script src="/templates/assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="/templates/assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
    <script src="/templates/assets/modules/chart.min.js"></script>
    <script src="/templates/assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="/templates/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="/templates/assets/modules/summernote/summernote-bs4.js"></script>
    <script src="/templates/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

    <script src="/templates/assets/modules/datatables/datatables.min.js"></script>
    <script src="/templates/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="/templates/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="/templates/assets/modules/jquery-ui/jquery-ui.min.js"></script>


    <!-- Page Specific JS File -->
    <script src="/templates/assets/js/page/index-0.js"></script>
    <script src="/templates/assets/js/page/modules-datatables.js"></script>
    @stack('scripts_vendor')
    <!-- Template JS File -->
    <script src="/templates/assets/js/scripts.js"></script>
    <script src="/templates/assets/js/custom.js"></script>
    <script>
        $(function() {
            $('#spinner-border').hide();
        });
    </script>
    @stack('scripts')

    <script>
        document.getElementById("copyright").innerHTML += new Date().getFullYear();
    </script>
</body>

</html>
