@extends('layouts.app')
@section('title','home')
@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">@lang('app.dashboard.dashboard_title')</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">@lang('app.dashboard.dashboard_title')</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-0">
                <div class="card px-3 ps-4">
                    <div class="row index1">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xxl-2">
                            <div class="row border-end bd-xs-e-0 p-3">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div
                                        class="circle-icon bg-primary text-center align-self-center overflow-hidden shadow">
                                        <i class="fe fe-users tx-15 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9 py-0">
                                    <div class="pt-4 pb-3">
                                        <div class="d-flex">
                                            <h6 class="mb-2 tx-12">@lang('app.dashboard.users_count')</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-18 font-weight-semibold mb-0">{{$data['users_count']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xxl-2">
                            <div class="row border-end bd-md-e-0 bd-xs-e-0 bd-lg-e-0 bd-xl-e-0  p-3">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div
                                        class="circle-icon bg-warning text-center align-self-center overflow-hidden shadow">
                                        <i class="fe fe-file-text tx-15 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="pt-4 pb-3">
                                        <div class="d-flex">
                                            <h6 class="mb-2 tx-12">@lang('app.lectures.lectures_count')</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-18 font-weight-semibold mb-0">{{$data['lectures_count']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xxl-2">
                            <div class="row border-end bd-xs-e-0  p-3">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div
                                        class="circle-icon bg-secondary text-center align-self-center overflow-hidden shadow">
                                        <i class="fe fe-file-text tx-15 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="pt-4 pb-3">
                                        <div class="d-flex">
                                            <h6 class="mb-2 tx-12">@lang('app.dashboard.active_lectures')</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-18 font-weight-semibold mb-0">{{$data['active_lectures_count']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xxl-2">
                            <div class="row border-end bd-xs-e-0  p-3">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div
                                        class="circle-icon bg-secondary text-center align-self-center overflow-hidden shadow">
                                        <i class="fe fe-file-text tx-15 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="pt-4 pb-3">
                                        <div class="d-flex">
                                            <h6 class="mb-2 tx-12">@lang('app.dashboard.not_active_lectures')</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-18 font-weight-semibold mb-0">{{$data['not_active_lectures_count']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xxl-2">
                            <div class="row border-end bd-xs-e-0  p-3">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div
                                        class="circle-icon bg-secondary text-center align-self-center overflow-hidden shadow">
                                        <i class="fe fe-file-text tx-15 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="pt-4 pb-3">
                                        <div class="d-flex">
                                            <h6 class="mb-2 tx-12">@lang('app.dashboard.paid_lectures')</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-18 font-weight-semibold mb-0">{{$data['paid_lectures_count']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xxl-2">
                            <div class="row  p-3">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div
                                        class="circle-icon bg-info text-center align-self-center overflow-hidden shadow">
                                        <i class="fe fe-file-text tx-15 text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="pt-4 pb-3">
                                        <div class="d-flex	">
                                            <h6 class="mb-2 tx-12">@lang('app.dashboard.free_lectures')</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-18 font-weight-semibold mb-0">{{$data['free_lectures_count']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- row  -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title"> @lang('app.dashboard.recently_lectures')</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">@lang('app.lectures.lecture_title')</th>
                                <th scope="col">@lang('app.lectures.is_paid')</th>
                                <th scope="col">@lang('app.lectures.price')</th>
                                <th scope="col">@lang('app.lectures.therapist')</th>
                                <th scope="col">@lang('app.lectures.status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['recently_lectures'] as $lecture)
                                <tr>
                                    <td>{{$lecture->title}}</td>
                                    <td>
                                        <span class="py-2 badge {{$lecture->is_paid == \App\Enums\PaymentStatusEnum::PAID->value ? 'badge-success' : 'badge-danger'}}">{{\App\Enums\PaymentStatusEnum::from($lecture->is_paid)->name}}</span>
                                    </td>
                                    <td>{{$lecture->is_paid ? $lecture->price : 0}}</td>
                                    <td>{{$lecture->therapist->name}}</td>
                                    <td>
                                        <span class="py-2 badge {{$lecture->status == \App\Enums\ActivationStatus::ACTIVE->value ? 'badge-success' : 'badge-danger'}}">{{\App\Enums\ActivationStatus::from($lecture->status)->name}}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title"> @lang('app.dashboard.upcoming_lectures')</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">@lang('app.lectures.lecture_title')</th>
                                <th scope="col">@lang('app.lectures.is_paid')</th>
                                <th scope="col">@lang('app.lectures.price')</th>
                                <th scope="col">@lang('app.lectures.therapist')</th>
                                <th scope="col">@lang('app.lectures.status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data['upcoming'] as $lecture)
                                <tr>
                                    <td>{{$lecture->title}}</td>
                                    <td>
                                        <span class="py-2 badge {{$lecture->is_paid == \App\Enums\PaymentStatusEnum::PAID->value ? 'badge-success' : 'badge-danger'}}">{{\App\Enums\PaymentStatusEnum::from($lecture->is_paid)->name}}</span>
                                    </td>
                                    <td>{{$lecture->is_paid ? $lecture->price : 0}}</td>
                                    <td>{{$lecture->therapist->name}}</td>
                                    <td>
                                        <span class="py-2 badge {{$lecture->status == \App\Enums\ActivationStatus::ACTIVE->value ? 'badge-success' : 'badge-danger'}}">{{\App\Enums\ActivationStatus::from($lecture->status)->name}}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">no data available</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->

    <!-- row  -->
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h3>@lang('app.dashboard.users_count_statistics')</h3>
            <div class="container">
                {!! $usersChart->container() !!}
                {!! $usersChart->script() !!}
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <h3>@lang('app.dashboard.sales_statistics')</h3>
            <div class="container">
                {!! $salesChart->container() !!}
                {!! $salesChart->script() !!}
            </div>
        </div>
    </div>
    <!-- /row -->

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endsection
