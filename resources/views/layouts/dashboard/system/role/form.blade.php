@extends('layouts.app')
@section('title', "Dashboard || Add New Admin")
@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => __('app.system.title'),'first_list_item' => __('app.system.roles_and_permissions'),'last_list_item' => ''])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <form
                        action="@isset($role) {{route('role.update',$role->id)}} @else {{route('role.store')}} @endisset "
                        method="post">

                        @isset($role)
                            @method('PATCH');
                        @endisset
                        @csrf
                        <div class="row row-sm mb-4">

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <div class="main-content-label mg-b-5">@lang('app.system.role_name') <span
                                        class="text-danger" *></span></div>
                                <input class="form-control" value="{{old('name')}}" name="name"
                                       type="text" required>
                                @error('name')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="row row-sm mb-4">
                            <div class="col-lg mt-2 mb-4">
                                <label class="custom-control custom-checkbox custom-control-lg">
                                    <input type="checkbox" class="custom-control-input" name="is_active" value="1"
                                           checked="">
                                    <span class="custom-control-label custom-control-label-md  tx-17">@lang('app.general.status')</span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($permissions as $groupName => $groupPermissions)

                                <div class="col-md-4 col-lg-4">
                                    <div class="card" style="height: 350px">
                                        <div class="card-header bg-azure text-black">
                                            <label class="custom-control custom-checkbox custom-control-lg">
                                                <input type="checkbox"
                                                       class="custom-control-input check_all_permissions"
                                                       id="{{$groupName}}">
                                                <span
                                                    class="custom-control-label custom-control-label-md  tx-17">{{__('app.system.permissions.'.$groupName.'.title') }}</span>
                                            </label>
                                        </div>
                                        <ul class="list-group list-group-flush permissions_list overflow-auto">
                                            @foreach($groupPermissions as $key => $permission)
                                                <li class="list-group-item">
                                                    <label class="custom-control custom-checkbox custom-control-lg">
                                                        <input type="checkbox"
                                                               class="custom-control-input permission_check_box"
                                                               name="permissions[]"
                                                               id="{{$permission->id}}"
                                                               value="{{$permission->id}}"
                                                        @isset($role)
                                                            @checked(in_array($permission->id, $role_permissions))
                                                            @else
                                                            @checked(old('permissions[]'))
                                                            @endisset
                                                        >
                                                        <span
                                                            class="custom-control-label custom-control-label-md  tx-17">{{ __('app.system.permissions.'.$groupName.'.'.$permission->name) }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
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

@section('scripts')
    <script src="{{asset('assets/pages/js/checkboxes.js')}}"></script>
@endsection
