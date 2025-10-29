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
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $web_title }}</title>
<link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">
<link rel="icon" href="{{ $favicon }}" type="image/x-icon">
<!-- Stylesheets -->
<link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/slide-show.css')}}">
<link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet">
@yield('css')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">



<!-- Responsive -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

</head>

<body>

<div class="page-wrapper">
    <div class="preloader"></div>
    @yield('mainContent')

</div>
<!-- End PageWrapper -->

<!-- Scroll To Top -->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-double-up"></span></div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/appear.js') }}"></script>
<script src="{{ asset('assets/js/owl.js') }}"></script>
<script src="{{ asset('assets/js/wow.js') }}"></script>
<script src="{{ asset('assets/js/odometer.js') }}"></script>
<script src="{{ asset('assets/js/nav-tool.js') }}"></script>
<script src="{{ asset('assets/js/mixitup.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/parallax.min.js') }}"></script>
<script src="{{ asset('assets/js/parallax-scroll.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/tilt.jquery.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

@yield('javaScricpt')
</body>
</html>
