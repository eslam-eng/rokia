@extends('layouts.app')

@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet"/>
@endsection

@section('title',__('app.rozmana.rozmana_title'))
@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.rozmana.rozmana_title'),'first_list_item' => '','last_list_item' => ''])
    {{--    end breadcrumb --}}

    <!--start filters section -->
    @include('layouts.dashboard.rozmana.components._filters')
    <!--end filtered section -->
    <!-- Row -->
    <div class="row">

        @foreach($therapists as $therapist)
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="d-flex w-100">
                            <div class="me-4"><span class="avatar avatar-lg avatar-rounded">
                                    <img src="{{$therapist->profile_image_url}}" alt="img"> </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between w-100 flex-wrap">
                                <div class="me-3"><p class="text-muted mb-0">@lang('app.rozmana.rozmana_count')</p>
                                    <p class="fw-semibold fs-16 mb-0">{{$therapist->rozmans_count}}</p></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between w-100 flex-wrap">
                            <div class="me-3"><p class="text-muted mb-0">@lang('app.therapists.name')</p>
                                <p class="fw-semibold fs-16 mb-0">{{$therapist->name}}</p></div>
                            <div class="me-3">
                                <p class="text-dark mb-0">
                                    <a class="btn btn-sm btn-info" href="{{route('therapists-rozmana.show',$therapist->id)}}">@lang('app.rozmana.rozmana_details')</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row mt-2 justify-content-center">
        {{ $therapists->links('vendor.pagination.bootstrap-4') }}
    </div>
    <!-- End Row -->

@endsection

@section('scripts')
@endsection
