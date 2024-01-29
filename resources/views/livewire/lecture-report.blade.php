<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="getReport">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <livewire:users-search :user_type="\App\Enums\UsersType::THERAPIST->value"
                                               :title="__('app.therapists.therapist')"/>
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
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
