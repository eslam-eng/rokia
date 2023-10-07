@extends('layouts.app')

@section('title')
    therapist
@endsection

@section('after_styles')
    <style>
        .img-container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .image {
            display: block;
            width: 100%;
            height: auto;
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .3s ease;
            background-color: #ff5151;
        }

        .img-container:hover .overlay {
            opacity: 1;
        }

        .icon {
            color: white;
            font-size: 50px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .fa-user:hover {
            color: #eee;
        }
    </style>
@endsection

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.therapists'),'first_list_item' => trans('app.add_therapist'),'last_list_item' => 'new therapist'])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">

        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <form action="{{route('therapists.update',$therapist->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm mb-4">
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.name') *</div>
                                <input class="form-control" name="name" value="{{old('name',$therapist->name)}}" placeholder="@lang('app.name')"
                                       type="text">
                                @error('name')
                                <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.email')</div>
                                <p class="form-control">
                                    {{$therapist->email}}
                                </p>

                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.password')</div>
                                <p class="form-control">
                                   *********************************
                                </p>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.phone')</div>
                                <input class="form-control" value="{{old('phone',$therapist->phone)}}" name="phone"
                                       placeholder="@lang('app.phone')" type="text">

                                @error('phone')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.address')</div>
                                <input class="form-control" value="{{old('address',$therapist->address)}}" name="address"
                                       placeholder="@lang('app.address')" type="text">

                                @error('address')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.gender')</div>
                                <select class="form-control form-select">
                                    @foreach(\App\Enums\GenderTypeEnum::cases() as $gender)
                                        <option value="{{$gender->value}}" {{$therapist->gender == $gender->value ? 'selected' : ''}}>{{__('app.'.$gender->name)}}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.commission')</div>
                                <input class="form-control" value="{{old('therapist_commission',$therapist->therapist_commission)}}" name="therapist_commission"
                                       placeholder="@lang('app.therapist_commission')" type="number" step="0.5">
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

                            @if(count($therapist->getMedia()))
                                @foreach($therapist->getMedia() as $media)
                                    <div class="col-md-3 col-lg-3 col-sm-12">
                                        <div class="img-container">
                                            <div class="form-group my-3">
                                                <img src="{{$media->getUrl()}}" class="img-fluid image" alt="">
                                            </div>
                                            <div class="overlay">
                                                <a role="button" class="icon" title="{{trans('lang.delete_image')}}">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg mt-2 mb-4">
                                <label class="custom-control custom-checkbox custom-control-lg">
                                    <input type="checkbox" class="custom-control-input" name="status" value="1" {{$therapist->status == \App\Enums\ActivationStatus::ACTIVE->value ?'checked' :''}} />
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
