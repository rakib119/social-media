@php
    $data = DB::table('genarel_infos')->select('field_name','value')->get();
    $dataArray = array();
    foreach ($data as $v)
    {
        $dataArray[$v->field_name] = $v->value;
    }
    extract($dataArray);
    $logo          = asset('assets/images/info/'.$logo);
    $favicon       = asset('assets/images/info/'.$favicon);
    $logo_white    = asset('assets/images/info/'.$logo_white);
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $web_title }}</title>
    <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">
    <link rel="icon" href="{{ $favicon }}" type="image/x-icon">
    <link href="{{ asset('dashboard/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dashboard/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dashboard/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dashboard/assets/css/cropper-1.5.6.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/custom.css') }}" rel="stylesheet" >
    {{-- CSS Yield --}}
    @yield('css')
</head>
@php
/* if (Auth::check()){
    if (auth()->user()->is_admin) {
        $home_link =  route('dashboard');
    }else{
        $home_link =  route('info.create');
    }
} */
$home_link =  route('dashboard');
@endphp
<body>
    <div id="layout-wrapper">
        <header id="page-topbar" style="background-color: #7D85EC;">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{$home_link}}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ $logo  }}" alt="" height="65">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ $logo  }}" alt="" height="60">
                            </span>
                        </a>
                        <a href="{{$home_link}}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ $logo_white }}" alt="" height="65">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ $logo_white }}" alt="" height="60">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 text-white font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn  header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="mdi text-white mdi-fullscreen"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('dashboard/assets/images/default-profile-picture.jpg') }}" alt="Header Avatar">
                            <span class="d-none text-white d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none text-white d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" target="_blank" href="{{route('home')}}"><i
                                    class="mdi mdi-web font-size-16 align-middle me-1"></i> Website</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i>{{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    @include('dashboard.layout.menu')
                </div>
            </div>
        </div>
        @yield('content')
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ config('app.name', '') }}
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Developed <i class="mdi mdi-heart text-danger"></i> by Rakib Hasan</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    </div>
    <script src="{{ asset('dashboard/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/libs/node-waves/waves.min.js') }}"></script>
    {{-- <script src="{{ asset('dashboard/assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('dashboard/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('dashboard/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"> </script>--}}
    {{-- <script src="{{ asset('dashboard/assets/js/pages/dashboard.init.js') }}"></script> --}}
    <script src="{{ asset('dashboard/assets/js/app.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/cropper-1.5.6.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/sweetalert2@11.js') }}"></script>

    <script src="{{ asset('dashboard/assets/js/function.js') }}"></script> {{-- Always on Bottom --}}
    {{-- delete confirmation --}}
    <script>
        function deleteData(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteData'+id).submit()
            }
            })
        }
    </script>

    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            })
        </script>
    @endif

    @if (session('page_error'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('page_error') }}",
            });
        </script>
    @endif

    {{-- Script Yield --}}
    @yield('javacript')
</body>


</html>
