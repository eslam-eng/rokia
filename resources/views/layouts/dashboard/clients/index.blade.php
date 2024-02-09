@extends('layouts.app')

@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet"/>
@endsection
@section('title',__('app.clients.clients'))
@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.clients.users_page_title'),'first_list_item' => trans('app.clients.clients'),'last_list_item' => trans('app.clients.all_clients')])
    {{--    end breadcrumb --}}

    <!--start filters section -->
    @include('layouts.dashboard.clients.components._filters')
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
@endsection
