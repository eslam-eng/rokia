<div>
    @if(!$model->isSuperAdminRole())
        <div class="row text-center">
            <a href="{{route('role.edit',$model->id)}}"
               data-toggle="tooltip" title="{{__('role.edit')}}"
               class="btn btn-sm btn-icon btn-warning btn-active-light-primary me-2">
                <i class="fa fa-edit"></i>
            </a>
            <button data-url="{{route('role.destroy',$model->id)}}" data-reload="0"
                    data-toggle="tooltip" title="{{__('role.delete')}}"
                    class="delete-row btn btn-sm btn-icon btn-danger btn-active-light-primary">
                <i class="fa fa-trash"></i>
            </button>
        </div>

    @endif

</div>
