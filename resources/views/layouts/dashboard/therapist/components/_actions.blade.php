<td class="text-end">
    <div class="row">
        <div>
            <button
                class="btn btn-sm change_therapist_status
            @if($model->status == \App\Enums\ActivationStatus::ACTIVE->value)
            btn-danger
            @else
            btn-success
            @endif row-action"
                data-action="{{route('therapist.status',$model->id)}}"
                data-toggle="tooltip"
                data-reload="0"
                data-status="{{in_array($model->status,[\App\Enums\ActivationStatus::PENDING->value,\App\Enums\ActivationStatus::INACTIVE->value]) ?  \App\Enums\ActivationStatus::ACTIVE->value :  \App\Enums\ActivationStatus::INACTIVE->value}}"
                title="{{in_array($model->status,[\App\Enums\ActivationStatus::PENDING->value,\App\Enums\ActivationStatus::INACTIVE->value]) ? __(key: 'app.active'):__('app.blocked')}}"
                data-method="POST"
            >
                @if($model->status == \App\Enums\ActivationStatus::ACTIVE->value)
                    block
                @else
                    active
                @endif
            </button>
        </div>
        <div>
            <a href="{{route('therapists.edit',$model->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        </div>
        <div>
            <button role="button" onclick="destroy('{{$url}}')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
        </div>
    </div>
</td>
