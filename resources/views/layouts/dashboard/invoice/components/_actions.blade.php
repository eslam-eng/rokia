<td class="text-end">
    <div class="row">
        <div>
            @if($model->status == \App\Enums\InvoiceStatusEnum::PENDING->value)
                <button class="btn btn-sm change_status btn-success row-action"
                        data-action="{{route('invoices.status',$model->id)}}"
                        data-reload="0"
                        data-status="{{\App\Enums\InvoiceStatusEnum::COMPLETED->value}}"
                        data-method="POST"
                >
                    @lang('app.invoices.complete')
                </button>
            @endif
        </div>
        <div>
            <a href="#" class="btn btn-sm btn-info"><i class="fa fa-eye"></i>عرض التفاصيل</a>
        </div>
    </div>
</td>
