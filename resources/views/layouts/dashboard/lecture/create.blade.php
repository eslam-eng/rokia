@extends('layouts.app')

@section('title')
    therapist
@endsection

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.therapists.therapists'),'first_list_item' => trans('app.add_therapist'),'last_list_item' => 'new therapist'])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">

        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <form action="{{route('therapists.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm mb-4">
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.name') *</div>
                                <input class="form-control" name="name" value="{{old('name')}}" placeholder="@lang('app.name')"
                                       type="text">
                                @error('name')
                                    <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.email') *</div>
                                <input class="form-control" value="{{old('email')}}" name="email" placeholder="@lang('app.email')"
                                       type="email">
                                @error('email')
                                    <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.password') *</div>
                                <input class="form-control" value="{{old('password')}}" name="password"
                                       placeholder="@lang('app.password')" type="text">

                                @error('password')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.phone') *</div>
                                <input class="form-control" value="{{old('phone')}}" name="phone"
                                       placeholder="@lang('app.phone')" type="text">

                                @error('phone')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.address')</div>
                                <input class="form-control" value="{{old('address')}}" name="address"
                                       placeholder="@lang('app.address')" type="text">

                                @error('address')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.gender') *</div>
                                <select class="form-control form-select">
                                    @foreach(\App\Enums\GenderTypeEnum::cases() as $gender)
                                        <option value="{{$gender->value}}">{{__('app.'.$gender->name)}}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.commission')</div>
                                <input class="form-control" value="{{old('therapist_commission')}}" name="therapist_commission"
                                       placeholder="@lang('app.therapist_commission')" type="text">
                                @error('therapist_commission')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.documents')</div>
                                <input class="form-control" value="{{old('documents')}}" name="documents[]"
                                       placeholder="@lang('app.documents')" type="file" multiple>

                                @error('documents.*')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                                <div class="col-lg mt-2 mb-4">
                                    <label class="custom-control custom-checkbox custom-control-lg">
                                        <input type="checkbox" class="custom-control-input" name="status" value="1" checked="">
                                        <span class="custom-control-label custom-control-label-md  tx-17">Status</span>
                                    </label>
                                </div>
                        </div>

                        <div class="card-footer mt-4">
                            <div class="form-group mb-0 mt-3 justify-content-end">
                                <div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save pe-2"></i>@lang('app.save')</button>

                                    <a role="button" href="{{ URL::previous() }}" class="btn btn-primary"><i
                                            class="fa fa-backward pe-2"></i>@lang('app.back')</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- End Row -->

@endsection
