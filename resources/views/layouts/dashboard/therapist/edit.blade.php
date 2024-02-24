@extends('layouts.app')

@section('title',__('app.therapists.therapist'))

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => __('app.therapists.therapists'),'first_list_item' => __('app.therapists.therapists'),'last_list_item' => __('app.therapists.add_therapist')])
    {{--    end breadcrumb --}}

    @if ($errors->any())
        <div class="row alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
    @endif
    <!-- Row -->
    <div class="row">

        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <form action="{{route('therapists.update',$therapist->id)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row row-sm mb-4">
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.therapists.name') *</div>
                                <input class="form-control" name="name" value="{{old('name',$therapist->name)}}"
                                       placeholder="@lang('app.therapists.name')"
                                       type="text">
                                @error('name')
                                <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.therapists.email')</div>
                                <p class="form-control">{{$therapist->email}}</p>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.therapists.password')</div>
                                <input class="form-control" name="password"
                                       placeholder="@lang('app.therapists.password')" type="password">

                                @error('password')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.therapists.phone')</div>
                                <input class="form-control" value="{{old('phone',$therapist->phone)}}" name="phone"
                                       placeholder="@lang('app.therapists.phone')" type="text">

                                @error('phone')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.therapists.address')</div>
                                <input class="form-control" value="{{old('address',$therapist->address)}}"
                                       name="address"
                                       placeholder="@lang('app.therapists.address')" type="text">

                                @error('address')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.therapists.gender')</div>
                                <select class="form-control form-select" name="gender">
                                    @foreach(\App\Enums\GenderTypeEnum::cases() as $gender)
                                        <option
                                            value="{{$gender->value}}" {{$therapist->gender == $gender->value ? 'selected' : ''}}>{{$gender->getLabel()}}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div
                                    class="main-content-label mg-b-5">@lang('app.therapists.therapist_commission')</div>
                                <input class="form-control"
                                       value="{{old('therapist_commission',$therapist->therapist_commission)}}"
                                       name="therapist_commission"
                                       placeholder="@lang('app.therapist_commission')" type="number" step="0.5">
                                @error('therapist_commission')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                <div
                                    class="main-content-label mg-b-5">@lang('app.therapists.avg_therapy_duration')</div>
                                <input class="form-control"
                                       value="{{old('avg_therapy_duration',$therapist->avg_therapy_duration)}}"
                                       name="avg_therapy_duration"
                                       placeholder="@lang('app.therapists.avg_therapy_duration')" type="number" min="5">
                                @error('avg_therapy_duration')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>


{{--                        <div class="row row-sm mb-4">--}}
{{--                            <div class="col-lg">--}}
{{--                                <div class="main-content-label mg-b-5">@lang('app.therapists.documets')</div>--}}
{{--                                <input class="form-control" value="{{old('documents')}}" name="documents[]"--}}
{{--                                       type="file" multiple>--}}
{{--                                @error('documents.*')--}}
{{--                                <div class="text-danger"> {{$message}}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            @if(count($therapist->getMedia()))--}}
{{--                                @foreach($therapist->getMedia() as $media)--}}
{{--                                    <div class="col-md-3 col-lg-3 col-sm-12">--}}
{{--                                        <div class="container">--}}
{{--                                            <img src="{{$media->getUrl()}}" alt="Snow" style="width:100%">--}}
{{--                                            <a class="btn" href="javascript:void(0);"--}}
{{--                                               onclick="destroy('{{route('delete-media',['media_id'=>$media->id])}}','1')"><i--}}
{{--                                                    class="fa fa-trash"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        </div>--}}

                        <div class="row">
                            <div class="col-lg mt-1">
                                <label class="custom-control custom-checkbox custom-control-lg">
                                    <input type="checkbox" class="custom-control-input" name="status"
                                        {{$therapist->status == \App\Enums\ActivationStatus::ACTIVE->value ?'checked' :''}} />
                                    <span
                                        class="custom-control-label custom-control-label-md  tx-17">@lang('app.therapists.status')</span>
                                </label>
                            </div>
                        </div>

                        <div class="card-footer mt-4">
                            <div class="form-group mb-0 mt-3 justify-content-end">
                                <div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save pe-2"></i>@lang('app.general.save')</button>

                                    <a role="button" href="{{ URL::previous() }}" class="btn btn-danger"><i
                                            class="fa fa-backward pe-2"></i>@lang('app.general.back')</a>
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
