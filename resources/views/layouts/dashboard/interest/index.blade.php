@extends('layouts.app')

@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet"/>
@endsection

@section('title',__('app.categories.title'))
@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.categories.title'),'first_list_item' => '','last_list_item' => ''])
    {{--    end breadcrumb --}}

    <!--start filters section -->
    @include('layouts.dashboard.category.components._filters')
    <!--end filtered section -->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <a href="{{route('categories.create')}}" role="button" class="btn btn-success text-dark"><i class="fa fa-plus"></i> @lang('app.categories.add_category')</a>
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
