<td class="text-end">
    <div class="row">
        <div>
            <button
                class="btn btn-sm change_status
            @if($model->status == \App\Enums\ActivationStatus::ACTIVE->value)
            btn-danger
            @else
            btn-success
            @endif row-action"
                data-action="{{route('therapist.status',$model->id)}}"
                data-reload="0"
                data-status="{{in_array($model->status,[\App\Enums\ActivationStatus::PENDING->value,\App\Enums\ActivationStatus::INACTIVE->value]) ?  \App\Enums\ActivationStatus::ACTIVE->value :  \App\Enums\ActivationStatus::INACTIVE->value}}"
                title="{{in_array($model->status,[\App\Enums\ActivationStatus::PENDING->value,\App\Enums\ActivationStatus::INACTIVE->value]) ? __(key: 'app.active'):__('app.blocked')}}"
                data-method="POST"
            >
                @if($model->status == \App\Enums\ActivationStatus::ACTIVE->value)
                    <i class="fa fa-pause"></i>
                @else
                    <i class="fa fa-check"></i>
                @endif
            </button>
        </div>
        <div>
            <a href="{{route('invoices.show',$model->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
        </div>

    </div>
</td>
