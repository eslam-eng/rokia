@extends('layouts.app')

@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet"/>

@endsection

@section('title')@lang('app.appointments.title')@endsection
@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.appointments.title'),'first_list_item' =>trans('app.appointments.appointments_list'),'last_list_item' => ''])
    {{--    end breadcrumb --}}
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
