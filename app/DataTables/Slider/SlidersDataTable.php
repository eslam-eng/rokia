<?php

namespace App\DataTables\Slider;

use App\Enums\ActivationStatus;
use App\Models\Slider;
use App\Models\User;
use App\Services\SliderService;
use App\Services\TherapistService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SlidersDataTable extends DataTable
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

            ->editColumn('image', function (Slider $model) {
                return view('layouts.dashboard.slider.components.image-preview',['model' => $model]);
            })
            ->editColumn('status', function (Slider $model) {
                $classes = ($model->status == ActivationStatus::ACTIVE->value) ? 'badge-success' : 'badge-danger';
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($model->status)->getLabel()]);
            })
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
    public function query(SliderService $sliderService): QueryBuilder
    {
        return $sliderService->datatable($this->filters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('sliders-table')
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
            Column::make('image')
                ->title(__('app.sliders.image'))
                ->searchable(false)
                ->orderable(false),

            Column::make('order')
                ->title(__('app.sliders.order'))
                ->searchable(false),

            Column::make('status')
                ->title(__('app.sliders.status'))
                ->orderable(false),

            Column::make('caption')
                ->title(__('app.sliders.caption'))
                ->orderable(false)
                ->searchable(false),

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
