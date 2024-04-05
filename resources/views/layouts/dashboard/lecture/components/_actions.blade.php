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
                data-action="{{route('therapist-lectures.status',$model->id)}}"
                data-reload="0"
                data-status="{{in_array($model->status,[\App\Enums\ActivationStatus::PENDING->value,\App\Enums\ActivationStatus::INACTIVE->value]) ?  \App\Enums\ActivationStatus::ACTIVE->value :  \App\Enums\ActivationStatus::PENDING->value}}"
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
        <div class="pe-1">
            <a href="{{route('therapist-lectures.edit',$model->id)}}" class="btn btn-sm btn-warning"><i
                    class="fa fa-edit"></i></a>
        </div>
        <div class="pe-1">
            <button role="button" onclick="destroy('{{$url}}')" class="btn btn-sm btn-danger"><i
                    class="fa fa-trash"></i></button>
        </div>
    </div>
</td>
