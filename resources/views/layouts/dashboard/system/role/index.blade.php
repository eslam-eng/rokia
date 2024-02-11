@extends('layouts.app')
@section('title', __('app.system.roles_and_permissions'))
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet"/>
@endsection
@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.system.title'),'first_list_item' => trans('app.system.roles_and_permissions'),'last_list_item' => ''])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-header">
                    <a class="btn btn-success" href="{{ route('role.create') }}" role="button"><i
                            class="fa fa-plus"></i>@lang('app.system.add_role')</a>
                </div>
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
