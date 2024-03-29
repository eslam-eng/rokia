		<!-- FAVICON -->
		<link rel="icon" href="{{asset('assets/images/brand/logo.png')}}" type="image/x-icon"/>

		<!-- ICONS CSS -->
		<link href="{{asset('assets/plugins/icons/icons.css')}}" rel="stylesheet">

		<!-- BOOTSTRAP CSS -->
        @if(auth()->user()->locale=='en')
            <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
        @else
            <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.rtl.css')}}">
        @endif

		<!-- RIGHT-SIDEMENU CSS -->
		<link href="{{asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

		<!-- P-SCROLL BAR CSS -->
		<link href="{{asset('assets/plugins/perfect-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />

        @yield('styles')

		<!-- STYLES CSS -->
		<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/style-dark.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/style-transparent.css')}}" rel="stylesheet">

		<!-- SKIN-MODES CSS -->
		<link href="{{asset('assets/css/skin-modes.css')}}" rel="stylesheet" />

		<!-- ANIMATION CSS -->
		<link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
        <!--- Internal Sweet-Alert css-->
        <link href="{{asset('assets/plugins/sweet-alert/sweetalert2.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

		{{-- start custom css --}}
		<link href="{{asset('assets/css/dashboard.css')}}" rel="stylesheet">
		{{-- end cutom css --}}
