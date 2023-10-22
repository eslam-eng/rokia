@extends('layouts.app')

@section('title')
    therapist
@endsection

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.lectures'),'first_list_item' => trans('app.edit_lecture'),'last_list_item' => ''])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        @endif
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-header">
                    <div class="row alert alert-info fw-bold text-dark">
                        {{$lecture->therapist->name}}
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('therapist-lectures.update',$lecture->id)}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row row-sm mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.title') *</div>
                                <input class="form-control" name="title" value="{{old('title',$lecture->title)}}"
                                       placeholder="@lang('app.lecture_title')"
                                       type="text">
                                @error('title')
                                <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="main-content-label mg-b-5">@lang('app.description')</div>
                                <input class="form-control" name="description" value="{{old('description',$lecture->description)}}" >
                                @error('description')
                                <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>

                        </div>


                        <div class="row row-sm">

                            <div class="col-lg-4 col-md-4 col-sm-12" id="price">
                                <div class="main-content-label mg-b-5">@lang('app.price')</div>
                                <input type="number" step="0.01" class="form-control"   name="price" value="{{old('price',$lecture->price)}}"  placeholder="@lang('app.lecture_price')">
                                @error('price')
                                <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 mt-4">
                                <label class="custom-control custom-checkbox custom-control-lg">
                                    <input type="checkbox" id="is_paid" class="custom-control-input" name="is_paid"
                                        {{$lecture->is_paid == \App\Enums\PaymentStatusEnum::PAID->value ?'checked' :''}} />
                                    <span class="custom-control-label custom-control-label-md  tx-17">@lang('app.is_paid')</span>
                                </label>
                            </div>

                            <div class="col-lg-4 col-md-4 mt-2 mt-4">
                                <label class="custom-control custom-checkbox custom-control-lg">
                                    <input type="checkbox" class="custom-control-input" name="status"
                                           value="1" {{$lecture->status == \App\Enums\ActivationStatus::ACTIVE->value ?'checked' :''}} />
                                    <span class="custom-control-label custom-control-label-md  tx-17">@lang('app.status')</span>
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

@section('script_footer')
    <script>
        $(document).ready(function () {
           if($('#is_paid').prop('checked')){
               $("#price").removeClass('d-none');
           }else
           {
               $("#price").addClass('d-none');
           }

            $('#is_paid').change(function() {
                if (this.checked) {
                    // Checkbox is checked, perform your action here
                    $("#price").removeClass('d-none');
                } else {
                    // Checkbox is unchecked, perform your action here
                    $("#price").addClass('d-none');
                }
            });

        });
    </script>
@endsection
