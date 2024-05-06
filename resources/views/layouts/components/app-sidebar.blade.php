<!-- main-sidebar -->
<div class="sticky">
    <aside class="app-sidebar">
        <div class="main-sidebar-header active">
            <a class="header-logo active" href="{{url('/')}}">
                <img style="max-height: 40px !important" src=""
                     class="main-logo" alt="Rokia">
            </a>
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/>
                </svg>
            </div>
            <ul class="side-menu">
                <li class="side-item side-item-category">@lang('app.dashboard.dashboard_title')</li>
                <li>
                    <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('home'))}}"
                       href="{{route('home')}}">@lang('app.dashboard.dashboard_title')</a>
                </li>
                <li class="side-item side-item-category">@lang('app.lectures.lectures')</li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="fa fa-file ide-menu__icon pe-2"></i>
                        <span class="side-menu__label">@lang('app.lectures.lectures')</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">

                        <li>
                            <a class="slide-item"
                               data-is_active="{{request()->fullUrlIs(route('therapist-lectures.index'))}}"
                               href="{{route('therapist-lectures.index')}}">@lang('app.lectures.lectures')</a>
                        </li>

                        <li>
                            <a class="slide-item"
                               data-is_active="{{request()->fullUrlIs(route('therapist-lectures.index').'?upcoming=1')}}"
                               href="{{route('therapist-lectures.index').'?upcoming=1'}}">@lang('app.lectures.upcoming_lectures')</a>
                        </li>
                    </ul>
                </li>

                <li class="side-item side-item-category">@lang('app.dashboard.therapists_and_plans')</li>

                <li>
                    <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('therapists.index'))}}"
                       href="{{route('therapists.index')}}"><i
                            class="fa fa-users pe-2"></i>@lang('app.therapists.therapists')</a>
                </li>

                <li>
                    <a class="slide-item"
                       data-is_active="{{request()->fullUrlIs(route('therapist-plans'))}}"
                       href="{{route('therapist-plans')}}"><i
                            class="fa fa-file pe-2"></i>@lang('app.therapist_plan.title')</a>
                </li>

                <li class="side-item side-item-category">@lang('app.dashboard.interests_and_specialists')</li>

                @if(authUserHasPermission('list_interest') || authUserHasPermission('create_interest'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="fa fa-cubes ide-menu__icon pe-2"></i>
                            <span class="side-menu__label">@lang('app.interests.title')</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @if(authUserHasPermission('list_interest'))
                                <li>
                                    <a class="slide-item"
                                       data-is_active="{{request()->fullUrlIs(route('interests.index'))}}"
                                       href="{{route('interests.index')}}">@lang('app.interests.title')</a>
                                </li>
                            @endif
                            @if(authUserHasPermission('create_interest'))
                                <li>
                                    <a class="slide-item"
                                       data-is_active="{{request()->fullUrlIs(route('interests.index'))}}"
                                       href="{{route('interests.create')}}">@lang('app.interests.add_interest')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(authUserHasPermission('list_specialist') || authUserHasPermission('create_specialist'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="fa fa-cubes ide-menu__icon pe-2"></i>
                            <span class="side-menu__label">@lang('app.specialist.title')</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @if(authUserHasPermission('list_specialist'))
                                <li>
                                    <a class="slide-item"
                                       data-is_active="{{request()->fullUrlIs(route('specialists.index'))}}"
                                       href="{{route('specialists.index')}}">@lang('app.specialist.title')</a>
                                </li>
                            @endif
                            @if(authUserHasPermission('create_specialist'))
                                <li>
                                    <a class="slide-item"
                                       data-is_active="{{request()->fullUrlIs(route('specialists.index'))}}"
                                       href="{{route('specialists.create')}}">@lang('app.specialist.add_specialist')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li class="side-item side-item-category">@lang('app.sliders.title')
                    | @lang('app.rozmana.rozmana_title')</li>


                @if(authUserHasPermission('list_slider') || authUserHasPermission('create_slider'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="fa fa-users ide-menu__icon pe-2"></i>
                            <span class="side-menu__label">@lang('app.sliders.title')</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @if(authUserHasPermission('list_slider'))
                                <li>
                                    <a class="slide-item"
                                       data-is_active="{{request()->fullUrlIs(route('therapists.index'))}}"
                                       href="{{route('sliders.index')}}">@lang('app.sliders.title')</a>
                                </li>
                            @endif
                            @if(authUserHasPermission('create_slider'))
                                <li>
                                    <a class="slide-item"
                                       data-is_active="{{request()->fullUrlIs(route('therapist-lectures.index'))}}"
                                       href="{{route('sliders.create')}}">@lang('app.sliders.add_slider')</a>
                                </li>
                            @endif

                        </ul>
                    </li>

                @endif

                @if(authUserHasPermission('list_rozmana'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="fa fa-file ide-menu__icon pe-2"></i>
                            <span class="side-menu__label">@lang('app.rozmana.rozmana_title')</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            <li>
                                <a class="slide-item"
                                   data-is_active="{{request()->fullUrlIs(route('therapists-rozmana'))}}"
                                   href="{{route('therapists-rozmana')}}">@lang('app.rozmana.rozmana_title')</a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if(authUserHasPermission('list_clients'))
                    <li class="side-item side-item-category">@lang('app.clients.clients')</li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="fa fa-users pe-2"></i>
                            <span class="side-menu__label">@lang('app.clients.clients')</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">@lang('app.clients.clients')</a>
                            </li>
                            <li><a class="slide-item" data-is_active="{{request()->fullUrlIs(route('clients.index'))}}"
                                   href="{{route('clients.index')}}">@lang('app.clients.clients')</a></li>
                        </ul>
                    </li>

                @endif


                <li class="side-item side-item-category">@lang('app.system.title')</li>

                @if(authUserHasPermission('list_users'))
                    <li>

                        <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('users.index'))}}"
                           href="{{route('users.index')}}">
                            <i class="fa fa-users pe-2"></i>
                            @lang('app.system.users_list')
                        </a>
                    </li>
                @endif

                @if(authUserHasPermission('list_role'))
                    <li>
                        <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('role.index'))}}"
                           href="{{route('role.index')}}">
                            <i class="fa fa-user-shield pe-2"></i>
                            @lang('app.system.roles')
                        </a>
                    </li>
                @endif


                <li class="side-item side-item-category">@lang('app.therapists.therapist_accounting')</li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="fa fa-building pe-3"></i>
                        <span class="side-menu__label">@lang('app.invoices.invoices')</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" data-is_active="{{request()->fullUrlIs("#")}}"
                               href="{{route('invoices.index')}}">@lang('app.invoices.all_invoices')</a>
                        </li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="fa fa-calendar-day pe-3"></i>
                        <span class="side-menu__label">@lang('app.appointments.title')</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" data-is_active="{{request()->fullUrlIs("#")}}"
                               href="{{route('appointments.index')}}">@lang('app.appointments.appointments_list')</a>
                        </li>
                    </ul>
                </li>

                <li class="side-item side-item-category">@lang('app.lecture_report.title')</li>
                <li>
                    <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('lecture-report'))}}"
                       href="{{route('lecture-report')}}"><i
                            class="fa fa-archive pe-3"></i>@lang('app.lecture_report.title')</a>
                </li>

                <li class="side-item side-item-category">@lang('app.settings.title')</li>
                <li>
                    <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('settings.index'))}}"
                       href="{{route('settings.index')}}"><i class="fa fa-archive pe-3"></i>@lang('app.settings.title')
                    </a>
                </li>
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/>
                </svg>
            </div>
        </div>
    </aside>
</div>
<!-- main-sidebar -->
