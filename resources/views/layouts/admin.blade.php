<!DOCTYPE html>
<html   lang="en" >

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input/build/css/intlTelInput.min.css">

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}"/>
    <title>KPI</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" bg-surface">
<main>
    <!--start the project-->
    <div id="main-wrapper" class=" flex p-5 xl:pr-0">
        @include('components.header')
        <div class=" w-full page-wrapper xl:px-6 px-0">

            <!-- Main Content -->
            <main class="h-full  max-w-full">
                <div class="container full-container p-0 flex flex-col gap-6">
                    <!--  Header Start -->
                    <header class=" bg-white shadow-md rounded-md w-full text-sm py-4 px-6">


                        <!-- ========== HEADER ========== -->

                        @include('components.navbar')
                        <!-- ========== END HEADER ========== -->
                    </header>
                    <!--  Header End -->
                    @yield('content')
                    @include('components.footer')
                </div>


            </main>
            <!-- Main Content End -->

        </div>
    </div>
    <!--end of project-->
</main>


<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/dropdown/index.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/overlay/index.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('script')
</body>

</html>
