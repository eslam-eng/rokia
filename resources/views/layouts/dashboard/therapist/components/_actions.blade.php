<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
        <i class="fa fa-cogs"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

        <li>
            <a class="dropdown-item" href="{{route('therapist.schedules')."?therapist=$model->id"}}">
                @lang('app.therapists.schedules.title')
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="{{route('therapists.edit',$model->id)}}">
               @lang('app.therapists.edit')
            </a>
        </li>

        <li>
            <a class="dropdown-item"
               data-action="{{route('therapist.status',$model->id)}}"
               data-reload="0"
               data-method="POST"
               role="button"
               href="#">
                @if($model->status == \App\Enums\ActivationStatus::ACTIVE->value)
                    @lang('app.therapists.deactive')
                @else
                    @lang('app.therapists.activate')
                @endif
            </a>
        </li>

        <li>
            <a class="dropdown-item" role="button" onclick="destroy('{{$url}}')" href="#">
                @lang('app.therapists.delete')
            </a>
        </li>
    </ul>
</div>

