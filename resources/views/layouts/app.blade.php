<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    @hasSection('title')
        <title>@yield('title')</title>
    @else
        <title>{{ $title ?? config('app.name') }}</title>
    @endif

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->
    <link rel="shortcut icon" href="{{asset('/assets/img/logo-circle.png')}}">
    <link rel="stylesheet" href="{{ asset('/node_modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/node_modules/weathericons/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/node_modules/weathericons/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/node_modules/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('/node_modules/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/node_modules/prismjs/themes/prism.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/node_modules/select2/dist/css/select2.min.css') }}">
    <!-- Dropify -->
    <link rel="stylesheet" href="{{ asset('/node_modules/dropify/dist/css/dropify.min.css') }}">
    <!--SweetAlert2-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/components.css') }}">

    <!-- Script -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Toggle CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <!-- Header-navbar -->
            @include('layouts/header')
            <!-- Sidebar -->
            @include('layouts/sidebar')
            <!-- Main Content -->
            @yield('content')
            <!-- Footer -->
            @include('layouts/footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('/assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('/node_modules/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('/node_modules/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('/node_modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('/node_modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('/node_modules/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('/node_modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('/node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('/node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/node_modules/prismjs/prism.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    {{-- dropify --}}
    <script src="{{ asset('/node_modules/dropify/dist/js/dropify.min.js') }}"></script>
    <!--Sweet Alert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

    <!-- Template JS File -->
    <script src="{{ asset('/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('/assets/js/custom.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('/assets/js/page/modules-toastr.js') }}"></script>
    <script src="{{ asset('/assets/js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('/assets/js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('/assets/js/page/index-0.js') }}"></script>
    <script src="{{ asset('/assets/js/page/features-post-create.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('/assets/js/page/bootstrap-modal.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
    <!-- Bootstrap Toggle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

    <script>
        $(document).ready(function() {
            @if (session('success'))
                iziToast.success({
                    title: 'Berhasil!',
                    message: "{{ session('success') }}",
                    position: 'topRight'
                });
            @endif ()

            @if (session('error'))
                iziToast.error({
                    title: 'Gagal!',
                    message: "{{ session('error') }}",
                    position: 'topRight'
                });
            @endif ()

            $('.dropify').dropify();

            $(".select2").select2();

            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });

            $('#table-1').dataTable();

        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            statusCode: {
                401: function() {
                    // Redirect ke halaman login jika sesi habis
                    window.location.href = '/login';
                },
                419: function() {
                    // Sesi telah kedaluwarsa
                    alert('Sesi Anda telah habis. Silakan login kembali.');
                    window.location.href = '/login';
                }
            }
        });
    </script>
    

    @yield('script')

    @stack('js')
</body>

</html>
