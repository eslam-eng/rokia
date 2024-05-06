<div>
    @if(!$model->isSuperAdminRole())
        <div class="row text-center">
            <a href="{{route('role.edit',$model->id)}}"
               data-toggle="tooltip" title="{{__('app.edit')}}"
               class="btn btn-sm btn-icon btn-warning btn-active-light-primary me-2">
                <i class="fa fa-edit"></i>
            </a>
            <button role="button" onclick="destroy('{{$url}}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
        </div>

    @endif

</div>
