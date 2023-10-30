@extends('layouts.app')
@section('title','home')
@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sales</li>
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
                                            <h6 class="mb-2 tx-12">@lang('app.users_count')</h6>
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
                                            <h6 class="mb-2 tx-12">@lang('app.active_lectures')</h6>
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
                                            <h6 class="mb-2 tx-12">@lang('app.not_active_lectures')</h6>
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
                                            <h6 class="mb-2 tx-12">@lang('app.paid_lectures')</h6>
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
                                            <h6 class="mb-2 tx-12">@lang('app.free_lectures')</h6>
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
                    <div class="card-title"> recently lectures</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">title</th>
                                <th scope="col">is_paid</th>
                                <th scope="col">price</th>
                                <th scope="col">therapist</th>
                                <th scope="col">status</th>
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
                    <div class="card-title"> upcoming lectures</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">title</th>
                                <th scope="col">is_paid</th>
                                <th scope="col">price</th>
                                <th scope="col">therapist</th>
                                <th scope="col">status</th>
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

@endsection

@section('scripts')

@endsection
