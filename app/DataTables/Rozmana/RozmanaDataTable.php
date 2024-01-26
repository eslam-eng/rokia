<?php

namespace App\DataTables\Rozmana;

use App\Enums\ActivationStatus;
use App\Models\Slider;
use App\Services\RozmanaService;
use App\Services\SliderService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RozmanaDataTable extends DataTable
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
            ->addColumn('action', function (Slider $model) {
                return view(
                    'layouts.dashboard.slider.components.actions',
                    ['model' => $model, 'url' => route('sliders.destroy', $model->id)]
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RozmanaService $rozmanaService): QueryBuilder
    {
        return $rozmanaService->datatable($this->filters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rozmana-table')
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
            Column::make('id')
                ->title('#')
                ->searchable(false)
                ->orderable(false),

            Column::make('therapist.name','therapist_id')
                ->title(__('app.therapists.name'))
                ->orderable(false),

            Column::make('title')
                ->title(__('app.rozmana.title'))
                ->orderable(false),

            Column::make('description')
                ->title(__('app.rozmana.description'))
                ->orderable(false),

            Column::make('date')
                ->title(__('app.rozmana.date'))
                ->orderable(false),

            Column::make('status')
                ->title(__('app.sliders.status'))
                ->orderable(false),

            Column::computed('action')
                ->title(__('app.general.action'))
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
