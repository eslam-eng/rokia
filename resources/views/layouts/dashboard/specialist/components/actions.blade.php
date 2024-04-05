<td class="text-end">
    <div class="row">
        <div class="pe-1">
            <button
                class="btn btn-sm change_status
            @if($model->status == \App\Enums\ActivationStatus::ACTIVE->value)
            btn-danger
            @else
            btn-success
            @endif row-action"
                data-action="{{route('specialists.status',$model->id)}}"
                data-reload="0"
                data-status=""
                title="{{in_array($model->status,[\App\Enums\ActivationStatus::PENDING->value,\App\Enums\ActivationStatus::INACTIVE->value]) ? __(key: 'app.active'):__('app.blocked')}}"
                data-method="POST"
            >
                @if($model->status == \App\Enums\ActivationStatus::ACTIVE->value)
                    <i class="fa fa-pause p-1"></i>
                @else
                    <i class="fa fa-check p-1"></i>
                @endif
                @lang('app.specialist.change_status')
            </button>
        </div>
        <div class="pe-1">
            <a href="{{route('specialists.edit',$model->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-edit p-1"></i>@lang('app.specialist.edit_specialist')</a>
        </div>
        <div class="pe-1">
            <button role="button" onclick="destroy('{{$url}}')" class="btn btn-sm btn-danger"><i class="fa fa-trash p-1"></i>@lang('app.specialist.delete_specialist')</button>
        </div>
    </div>
</td>
