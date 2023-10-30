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
                <li class="side-item side-item-category">@lang('app.menu')</li>
                <li>
                    <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('home'))}}"
                       href="{{route('home')}}">@lang('app.Dashboard')</a>
                </li>
                <li class="side-item side-item-category">@lang('app.therapists.therapists')</li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="fa fa-users ide-menu__icon pe-2"></i>
                        <span class="side-menu__label">@lang('app.therapists.therapists')</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" data-is_active="{{request()->fullUrlIs(route('therapists.index'))}}"
                               href="{{route('therapists.index')}}">@lang('app.therapists.therapists')</a>
                        </li>

                        <li>
                            <a class="slide-item"
                               data-is_active="{{request()->fullUrlIs(route('therapist-lectures.index'))}}"
                               href="{{route('therapist-lectures.index')}}">@lang('app.lectures.lectures')</a>
                        </li>

                        <li>
                            <a class="slide-item"
                               data-is_active="{{request()->fullUrlIs(route('therapist-lectures.index'))}}"
                               href="{{route('therapist-lectures.index').'?upcoming=1'}}">@lang('app.lectures.upcoming_lectures')</a>
                        </li>

                    </ul>
                </li>

                <li class="side-item side-item-category">@lang('app.clients.clients')</li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="fa fa-users pe-3"></i>
                        <span class="side-menu__label">@lang('app.clients.clients')</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Utilities</a></li>
                        @can('create_users')
                            <li><a class="slide-item" data-is_active="{{request()->fullUrlIs(route('users.create'))}}"
                                   href="{{route('users.create')}}">@lang('app.new_user')</a></li>
                        @endcan
                        <li><a class="slide-item" data-is_active="{{request()->fullUrlIs(route('users.index'))}}"
                               href="{{route('users.index')}}">@lang('app.clients.clients')</a></li>
                    </ul>
                </li>

                <li class="side-item side-item-category">@lang('app.therapist_accounting')</li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="fa fa-building pe-3"></i>
                        <span class="side-menu__label">@lang('app.invoices.invoices')</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" data-is_active="{{request()->fullUrlIs("#")}}"
                               href="#">@lang('app.all_invoices')</a>
                        </li>
                    </ul>
                </li>


                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="fa fa-money-bill-alt pe-3"></i>
                        <span class="side-menu__label">@lang('app.price_table')</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    {{--                    <ul class="slide-menu">--}}
                    {{--                        <li><a class="slide-item" data-is_active="{{request()->fullUrlIs(route('prices.create'))}}"--}}
                    {{--                               href="{{route('prices.create')}}">@lang('app.new_price_table')</a></li>--}}
                    {{--                        <li><a class="slide-item" data-is_active="{{request()->fullUrlIs(route('prices.index'))}}"--}}
                    {{--                               href="{{route('prices.index')}}">@lang('app.price_tables')</a></li>--}}
                    {{--                    </ul> --}}

                    <ul class="slide-menu">
                        <li><a class="slide-item" data-is_active="{{request()->fullUrlIs('#')}}"
                               href="#">@lang('app.new_price_table')</a></li>
                        <li><a class="slide-item" data-is_active="{{request()->fullUrlIs("#")}}"
                               href="#">@lang('app.price_tables')</a></li>
                    </ul>
                </li>


                {{--                                dashboard settings--}}

                {{-- @can('view_settings')
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24"
                             height="24" viewBox="0 0 24 24">
                            <path
                                d="M22 7.999a1 1 0 0 0-.516-.874l-9.022-5a1.003 1.003 0 0 0-.968 0l-8.978 4.96a1 1 0 0 0-.003 1.748l9.022 5.04a.995.995 0 0 0 .973.001l8.978-5A1 1 0 0 0 22 7.999zm-9.977 3.855L5.06 7.965l6.917-3.822 6.964 3.859-6.918 3.852z"/>
                            <path
                                d="M20.515 11.126 12 15.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/>
                            <path
                                d="M20.515 15.126 12 19.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/>
                        </svg>
                        <span class="side-menu__label">@lang('app.settings')</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a
                                href="javascript:void(0);">@lang('app.settings')</a></li>
                        <li><a class="sub-side-menu__item"
                               href="{{route('switcherpage')}}">@lang('app.dashboard_settings')</a></li>
                    </ul>
                </li>
                @endcan --}}


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
