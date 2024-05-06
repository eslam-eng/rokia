<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="getReport">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <livewire:therapists-search :title="__('app.therapists.therapist')"/>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div>
                            <label for="start_date" class="form-label">@lang('app.lecture_report.start_date')</label>
                            <input type="date" wire:model="start_date" class="form-control" id="start_date" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div>
                            <label for="end_date" class="form-label">@lang('app.lecture_report.end_date')</label>
                            <input type="date" wire:model="end_date" class="form-control" id="end_date" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('app.general.search') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if(!empty($lectures) && $lectures->count())
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>@lang('app.lectures.title')</th>
                        <th>@lang('app.lectures.is_paid')</th>
                        <th>@lang('app.lectures.created_at')</th>
                        <th>@lang('app.lectures.publish_date')</th>
                        <th>@lang('app.lectures.duration')</th>
                        <th>@lang('app.lectures.price')</th>
                        <th>@lang('app.lectures.users_subscription')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lectures as $lecture)
                        <tr>
                            <td>{{$lecture->title}}</td>
                            <td>{{\App\Enums\PaymentStatusEnum::from($lecture->is_paid)->getLabel()}}</td>
                            <td>{{$lecture->created_at}}</td>
                            <td>{{$lecture->publish_date ?? $lecture->created_at}}</td>
                            <td>{{$lecture->duration}}</td>
                            <td>{{$lecture->price}}</td>
                            <td>{{$lecture->users_count}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="card-footer">
                {{ $lectures->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header alert alert-info text-center fw-bold"><h4>{{ __('app.general.no_data_available') }}</h4></div>
        </div>
    @endif


</div>
