<?php

namespace App\DataTables\BookAppointment;

use App\Enums\ActivationStatus;
use App\Enums\BookAppointmentStatusEnum;
use App\Enums\WeekDaysEnum;
use App\Models\BookAppointment;
use App\Models\Slider;
use App\Models\User;
use App\Services\Appointment\BookAppointmentService;
use App\Services\SliderService;
use App\Services\TherapistService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BookAppointmentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')

            ->editColumn('day_id', fn (BookAppointment $model)=>WeekDaysEnum::from($model->day_id)->getLabel())
            ->editColumn('user_description', fn (BookAppointment $model)=>Str::limit($model->user_description))
            ->editColumn('status', function (BookAppointment $model) {
                $classes = BookAppointmentStatusEnum::from($model->status)->getClasses();
                $text = BookAppointmentStatusEnum::from($model->status)->getLabel();
                return view('components._datatable-badge', ['class' => $classes, 'text' => $text]);
            });
    }

    /**
     * @param BookAppointmentService $bookAppointmentService
     * @return QueryBuilder
     */
    public function query(BookAppointmentService $bookAppointmentService): QueryBuilder
    {
        return $bookAppointmentService->datatable($this->filters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bookappointments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('client.name','client_id')
                ->title(__('app.appointments.client_name'))
                ->searchable(false),

            Column::make('therapist.name','therapist_id')
                ->title(__('app.appointments.therapist_name'))
                ->searchable(false)
                ->orderable(false),


            Column::make('day_id')
                ->title(__('app.appointments.day'))
                ->orderable(false),

            Column::make('price')
                ->title(__('app.appointments.price'))
                ->orderable(false),

            Column::make('user_description')
                ->title(__('app.appointments.user_description'))
                ->orderable(false),

            Column::make('date')
                ->title(__('app.appointments.date'))
                ->orderable(false),

            Column::make('status')
                ->title(__('app.sliders.status'))
                ->orderable(false),

//            Column::computed('action')
//                ->title(__('app.general.action'))
//                ->exportable(false)
//                ->printable(false)
//                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Therapists_' . date('YmdHis');
    }
}
