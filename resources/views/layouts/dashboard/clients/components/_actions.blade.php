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
                data-action="{{route('clients.status',$model->id)}}"
                data-reload="0"
                data-status=""
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
{{--        <div>--}}
{{--            <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <button role="button" onclick="destroy('{{$url}}')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>--}}
{{--            <button role="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>--}}
{{--        </div>--}}
    </div>
</td>
