@extends('layouts.app')

@section('title',__('app.users.title'))

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => __('app.users.title'),'first_list_item' => __('app.users.users_list'),'last_list_item' => ''])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <form action="{{isset($user) ?route('users.update',$user->id) : route('users.store')}}" method="post" enctype="multipart/form-data">
                        @isset($user)
                            @method('PATCH')
                        @endisset
                        @csrf
                        <div class="row row-sm mb-4">

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="main-content-label mg-b-5">@lang('app.users.name') <span class="text-danger"
                                                                                                     *></span></div>
                                <input class="form-control" value="{{old('name',isset($user) ? $user->name:'')}}" name="name"
                                       type="text" required>
                                @error('name')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="main-content-label mg-b-5">@lang('app.users.email') <span
                                        class="text-danger" *></span></div>
                                <input class="form-control" value="{{old('email',isset($user) ? $user->email:'')}}" name="email"
                                       type="email" required>
                                @error('email')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="main-content-label mg-b-5">@lang('app.users.phone') <span
                                        class="text-danger" *></span></div>
                                <input class="form-control" value="{{old('phone',isset($user) ? $user->phone:'')}}" name="phone"
                                       type="text" required>
                                @error('phone')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="main-content-label mg-b-5">@lang('app.users.password') <span
                                        class="text-danger" *></span></div>
                                <input class="form-control" name="password"
                                       type="password" @if(!isset($user)) required @endif>
                                @error('password')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="main-content-label mg-b-5">@lang('app.users.gender') <span
                                        class="text-danger" *></span></div>

                                <select class="form-control form-select" name="gender" required aria-label="Default select example">
                                    @foreach(\App\Enums\GenderTypeEnum::cases() as $gender)
                                        <option value="{{$gender->value}}" @selected(old('gender', isset($user)? $user->gender : '') == $gender->value)>{{$gender->getLabel()}}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="main-content-label">@lang('app.users.role')<span class="text-danger"*></span></div>
                                <select class="form-control form-select" name="role_id" required>
                                    <option>@lang('app.users.choose_role')</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @selected(old('role_id', isset($user) ? $user->roles->first()?->id : null) == $role->id)>{{$role->name}}</option>
                                    @endforeach
                                </select>

                                @error('role_id')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="main-content-label mg-b-5">@lang('app.users.address') <span
                                        class="text-danger" *></span></div>
                                <input type="text" name="address" class="form-control" value="{{old('address',isset($user) ? $user->address : '')}}" required>
                                @error('address')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg mt-2 mb-4">
                            <label class="custom-control custom-checkbox custom-control-lg">
                                <input type="checkbox" class="custom-control-input" name="status" {{ (isset($user) && $user->status) ? 'checked' :'' }}>
                                <span
                                    class="custom-control-label custom-control-label-md  tx-17">@lang('app.general.status')</span>
                            </label>
                        </div>

                        <div class="card-footer mt-4">
                            <div class="form-group mb-0 mt-3 justify-content-end">
                                <div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save pe-2"></i>@lang('app.save')</button>

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
