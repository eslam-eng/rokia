@extends('layouts.app')

@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}"/>
@endsection

@section('title',__('app.lecture_report.title'))
@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.lecture_report.title'),'first_list_item' => '','last_list_item' => ''])
    {{--    end breadcrumb --}}

    <livewire:lecture-report/>
@endsection

@section('scripts')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endsection
