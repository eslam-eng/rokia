@extends('layouts.app')

@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet"/>
@endsection

@section('title') @lang('app.lectures') @endsection
@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.lectures_page_title'),'first_list_item' => trans('app.lectures'),'last_list_item' => trans('app.all_lectures')])
    {{--    end breadcrumb --}}

    <!--start filters section -->
    @include('layouts.dashboard.users.components._filters')
    <!--end filtered section -->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table-data table table-bordered text-nowrap border-bottom']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('scripts')
    @include('layouts.components.datatable-scripts')
    <script>
        $(document).on('click','.change_therapist_lecture_status',function () {
            let status = $(this).data('status');
            let reload = $(this).data('reload');
            let url = $(this).data('action');
            Swal.fire({
                title: 'Are you sure?',
                text: "You will change status to ("+ $(this).text() + ')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change!'
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
@endsection
