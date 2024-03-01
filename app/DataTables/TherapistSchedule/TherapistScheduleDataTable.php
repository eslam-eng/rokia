<?php

namespace App\DataTables\TherapistSchedule;

use App\Enums\WeekDaysEnum;
use App\Models\TherapistSchedule;
use App\Services\Therapist\TherapistScheduleService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TherapistScheduleDataTable extends DataTable
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
            ->editColumn('day_id', fn(TherapistSchedule $therapistSchedule) => WeekDaysEnum::from($therapistSchedule->day_id)->getLabel())
            ->editColumn('time_from',fn(TherapistSchedule $therapistSchedule)=>$therapistSchedule->start_time)
            ->editColumn('time_to',fn(TherapistSchedule $therapistSchedule)=>$therapistSchedule->end_time);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TherapistScheduleService $model): QueryBuilder
    {
        return $model->datatable($this->filters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('therapists-table')
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
            Column::make('day_id')->title(__('app.therapists.schedules.day_name'))->searchable(false),
            Column::make('time_from')->title(__('app.therapists.schedules.time_from'))->searchable(false)->orderable(false),
            Column::make('time_to')->title(__('app.therapists.schedules.time_to'))->searchable(false)->orderable(false),
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
