<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('/templates') }}/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/templates') }}/assets/modules/fontawesome/css/all.min.css">
    @stack('css_vendor')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('/templates') }}/assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('/templates') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('/templates') }}/assets/css/components.css">

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

    @stack('css')
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                @yield('content')
            </div>
        </section>
    </div>
    <!-- JS Libraries -->

    @stack('scripts_vendor')

    <!-- General JS Scripts -->
    <script src="{{ asset('/templates') }}/assets/modules/jquery.min.js"></script>
    <script src="{{ asset('/templates') }}/assets/modules/popper.js"></script>
    <script src="{{ asset('/templates') }}/assets/modules/tooltip.js"></script>
    <script src="{{ asset('/templates') }}/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('/templates') }}/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('/templates') }}/assets/modules/moment.min.js"></script>
    <script src="{{ asset('/templates') }}/assets/js/stisla.js"></script>

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('/templates') }}/assets/js/scripts.js"></script>
    {{--  <script src="{{ asset('/templates') }}/assets/js/custom.js"></script>  --}}
    <script src="{{ asset('/templates/js/custome.js') }}"></script>

    @stack('scripts')

    <script>
        // Show password
        $('#customCheck1').on('click', function() {
            if ($(this).is(':checked')) {
                $('.password').attr('type', 'text');
            } else {
                $('.password').attr('type', 'password');
            }
        })
    </script>
</body>

</html>
