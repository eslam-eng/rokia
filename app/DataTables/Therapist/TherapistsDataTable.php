<?php

namespace App\DataTables\Therapist;

use App\Enums\ActivationStatus;
use App\Models\Therapist;
use App\Services\Therapist\TherapistService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TherapistsDataTable extends DataTable
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
            ->editColumn('status', function (Therapist $therapist) {
                $classes =  ActivationStatus::from($therapist->status)->getClasses();
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($therapist->status)->getLabel()]);
            })->editColumn('gender', fn(Therapist $therapist) => __('app.general.' . $therapist->gender))
            ->editColumn('created_at',fn(Therapist $therapist)=>$therapist->created_at->format('Y-m-d'))
            ->addColumn('action', function (Therapist $therapist) {
                return view(
                    'layouts.dashboard.therapist.components._actions',
                    ['model' => $therapist, 'url' => route('users.destroy', $therapist->id)]
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TherapistService $model): QueryBuilder
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
            Column::make('id')->title("#"),
            Column::make('name')->title(__('app.therapists.name')),
            Column::make('phone')->title(__('app.therapists.phone'))->orderable(false),
            Column::make('address')->title(__('app.therapists.address'))->orderable(false)->searchable(false),
            Column::make('email')->title(__('app.therapists.email'))->orderable(false),
            Column::make('gender')->title(__('app.therapists.gender'))->orderable(false)->searchable(false),
            Column::make('status')->title(__('app.therapists.status'))->orderable(false)->searchable(false),
            Column::make('therapist_commission')->title(__('app.therapists.therapist_commission'))->orderable(false)->searchable(false),
            Column::make('avg_therapy_duration')->title(__('app.therapists.avg_therapy_duration'))->orderable(false)->searchable(false),
            Column::make('created_at')->title(__('app.general.created_at')),
            Column::computed('action')->title(__('app.general.action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
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
