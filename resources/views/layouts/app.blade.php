<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Nowa – Laravel Bootstrap 5 Admin & Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords"
          content="admin dashboard, admin dashboard laravel, admin panel template, blade template, blade template laravel, bootstrap template, dashboard laravel, laravel admin, laravel admin dashboard, laravel admin panel, laravel admin template, laravel bootstrap admin template, laravel bootstrap template, laravel template"/>
    <!-- Title -->
    <title>@yield('title')</title>

    @include('layouts.components.styles')
    @yield('after_styles')
</head>

<body class="ltr main-body app sidebar-mini">

<!-- Loader -->
<div id="global-loader">
    <img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->

<!-- Page -->
<div class="page">

    <div>

        @include('layouts.components.app-header')

        @include('layouts.components.app-sidebar')

    </div>

    <!-- main-content -->
    <div class="main-content app-content">

        <!-- container -->
        <div class="main-container container-fluid">

            @yield('content')

        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    @include('layouts.components.sidebar-right')

    @yield('modal')

    @include('layouts.components.footer')

</div>
<!-- End Page -->

@include('layouts.components.scripts')
@include('layouts.components.toastr')


<script>
    function destroy(url,reload=0) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    dataType: 'json',
                    data:{
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(result) {
                        if (result.status)
                            toastr.success(result.message);
                        else
                            toastr.error(result.message);
                        if(reload==0)
                            $('.dataTable').DataTable().ajax.reload(null, false);
                        else
                            window.location.reload();
                    } ,
                    error: function(jqXHR, textStatus, errorThrown) {

                        var errorMessage = jqXHR.responseJSON.message;
                        toastr.error(errorMessage);
                    }
                });
            }
        })
    }

    $(document).on('click','.change_status',function () {
        let status = $(this).data('status');
        let reload = $(this).data('reload');
        let url = $(this).data('action');
        Swal.fire({
            title: '{{trans('app.general.are_u_sure')}}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{trans('app.general.swal_confirm_btn')}}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'post',
                    url: url,
                    dataType: 'json',
                    data:{
                        '_token': '{{ csrf_token() }}',
                        'status':status,
                    },
                    success: function(result) {
                        if (result.status)
                            toastr.success(result.message);
                        else
                            toastr.error(result.message);
                        if(reload==0)
                            $('.dataTable').DataTable().ajax.reload(null, false);
                        else
                            window.location.reload();
                    } ,
                    error: function(jqXHR, textStatus, errorThrown) {
                        var errorMessage = jqXHR.responseJSON.message;
                        toastr.error(errorMessage);
                    }
                });
            }
        })
    });
</script>
@yield('script_footer')
</body>
</html>
