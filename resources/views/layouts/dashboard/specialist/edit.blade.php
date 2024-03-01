@extends('layouts.app')

@section('title',__('app.specialist.title'))

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => __('app.specialist.title'),'first_list_item' => __('app.specialist.title'),'last_list_item' => __('app.app.specialist.edit_specialist')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">

        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <form action="{{route('specialists.update',$specialist)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row row-sm mb-4">

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <div class="main-content-label mg-b-5">@lang('app.categories.name') <span class="text-danger"*></span></div>
                                <input class="form-control" value="{{old('name',$specialist->name)}}" name="name"
                                       type="text" required>
                                @error('name')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg mt-2 mb-4">
                                <label class="custom-control custom-checkbox custom-control-lg">
                                    <input type="checkbox" class="custom-control-input" name="status" @checked(old('status', $specialist->status))>
                                    <span class="custom-control-label custom-control-label-md  tx-17">@lang('app.interests.status')</span>
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
