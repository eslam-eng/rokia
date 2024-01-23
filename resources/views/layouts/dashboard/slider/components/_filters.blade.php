<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <div>
                    <a aria-controls="collapseExample" class="btn ripple btn-light collapsed"
                       data-bs-toggle="collapse" href="#collapseExample" role="button"
                       aria-expanded="false"><i class="fa fa-filter pe-2"></i>@lang('app.general.filters')
                    </a>
                </div>
                <div>

                    <div class="collapse" id="collapseExample" style="">
                        <div class="mt-4">
                            <form class="datatables_parameters">
                                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->

                                    <div class="row row-sm mb-4">
                                        <div class="col-lg mb-4">
                                            <div class="main-content-label mg-b-5">@lang('app.therapists.status')</div>
                                            <select class="form-control" name="status">
                                                <option>@lang('app.general.select_status')</option>
                                                @foreach(\App\Enums\ActivationStatus::cases() as $status)
                                                    @if($status->value != \App\Enums\ActivationStatus::INACTIVE->value)
                                                        <option value="{{$status->value}}">@lang('app.general.'.$status->name)</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <div class="form-group mb-0 mt-3 justify-content-end">
                                        <div>
                                            <button type="submit" class="search_datatable btn btn-primary"><i class="fa fa-search pe-2"></i>@lang('app.general.search')</button>
                                            <button type="reset" class="reset_form_data btn btn-primary">@lang('app.general.reset')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

