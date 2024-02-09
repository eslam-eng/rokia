<div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link @if($activeTab == 'general_settings') active @endif"
                    style="padding: 12px !important;"
                    wire:click="$set('activeTab', 'general_settings')" type="button"
                    role="tab">@lang('app.settings.general.title')</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link @if($activeTab == 'sales_invoice_settings') active @endif"
                    style="padding: 12px !important;"
                    wire:click="$set('activeTab', 'sales_invoice_settings')" type="button"
                    role="tab">@lang('app.settings.sales_invoice.title')</button>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
        @if($activeTab == 'general_settings')
            @include('settings.general-settings.form')
        @elseif($activeTab == 'sales_invoice_settings')
            <h3>another settings</h3>
        @endif
    </div>
</div>
