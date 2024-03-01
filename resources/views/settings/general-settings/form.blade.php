<div class="mt-1">
    <form class="form" wire:submit="submit">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="mb-1">
                    <label class="form-label"
                           for="delivery_fees">{{ __('app.settings.about_us') }}</label>

                    <div class="form-outline">
                        <textarea class="form-control" wire:model="generalSettingsForm.about_us" id="textAreaExample1" rows="4"></textarea>
                    </div>
                    @error('generalSettingsForm.about_us')
                    <div class="text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="mb-1">
                    <label class="form-label"
                           for="privacy_condition">{{ __('app.settings.privacy') }}</label>

                    <div class="form-outline">
                        <textarea class="form-control" wire:model="generalSettingsForm.privacy_condition" id="textAreaExample1" rows="4"></textarea>
                    </div>
                    @error('generalSettingsForm.privacy_condition')
                    <div class="text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="mb-1">
                    <label class="form-label"
                           for="return_allowed_duration">{{ __('app.settings.support_phone') }}</label>
                    <input type="text" wire:model="generalSettingsForm.support_phone" id="support_phone" class="form-control"
                           name="return_allowed_duration" required>
                    @error('generalSettingsForm.support_phone')
                    <div class="text text-danger">{{$message}}</div>
                    @enderror
                </div>

{{--                <div class="mb-1">--}}
{{--                    <label class="form-label"--}}
{{--                           for="invoice_printing_count">{{ __('app.settings.sales_invoice.invoice_printing_count') }}</label>--}}
{{--                    <input type="file" accept="image/*" wire:model="generalSettingsForm.app_logo" id="app_logo" class="form-control"--}}
{{--                           name="app_logo" required>--}}
{{--                    @error('generalSettingsForm.app_logo')--}}
{{--                    <div class="text text-danger">{{$message}}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}

            </div>
            <div class="col-12 mt-2">
                <button type="submit"
                        class="btn btn-primary me-1 waves-effect waves-float waves-light">{{ __('pages.submit') }}</button>
            </div>
        </div>
    </form>

</div>
