<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="Grace Technologies CMS" />
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset(config('constants.LOGO_LOCATION')) }}" />
{{-- <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin /> --}}
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Icons -->
<link href="{{ asset('dashboard/vendor/fonts/fontawesome-free-6.4.2-web/css/fontawesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/vendor/fonts/fontawesome-free-6.4.2-web/css/brands.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/vendor/fonts/fontawesome-free-6.4.2-web/css/solid.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/vendor/fonts/fontawesome-free-6.4.2-web/css/regular.min.css') }}" rel="stylesheet">
<!-- Only using boxicon bcz the mobile navigation bx-menu button works properly with it -->
<link rel="stylesheet" href="{{ asset('dashboard/vendor/fonts/boxicons.css') }}" />
<!-- Auth Pages CSS -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<!-- Core CSS (It is basically Bootstap 5) - Make your general custom CSS changes in the core.css file -->
<link rel="stylesheet" href="{{ asset('dashboard/vendor/css/core.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/vendor/css/theme-default.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/css/demo.css') }}" />

<!-- Scrollbar CSS -->
{{-- <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" /> --}}
<!-- Charts CSS -->
{{-- <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/apex-charts/apex-charts.css') }}" /> --}}
<!-- Pages CSS -->
{{-- <link rel="stylesheet" href="{{ asset('dashboard/vendor/css/pages/page-auth.css') }}" /> --}}

<!-- Custom CSS -->
@php
    $admin_routes = [route('admin.employees')];
@endphp
@if (in_array(Route::current()->uri, $admin_routes))
    <link rel="stylesheet" href="{{ asset('dashboard/css/custom-styles.css') }}">
@endif

{{-- @if (Auth::user()->role_id === 'admin')
        <link rel="stylesheet" href="{{ asset('dashboard/css/custom-styles.css') }}">
    @endif --}}

<!-- Helpers -->
<script src="{{ asset('dashboard/vendor/js/helpers.js') }}" defer></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js')}} in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('dashboard/js/config.js') }}" defer></script>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
@stack('head')
@livewireStyles
