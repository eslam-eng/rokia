<?php

namespace App\DataTables\Category;

use App\Enums\ActivationStatus;
use App\Models\Category;
use App\Models\Interest;
use App\Models\Slider;
use App\Services\Interest\InterestService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InterestsDatatable extends DataTable
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
            ->editColumn('status', function (Interest $model) {
                $classes = ($model->status == ActivationStatus::ACTIVE->value) ? 'badge-success' : 'badge-danger';
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($model->status)->getLabel()]);
            })
            ->addColumn('action', function (Interest $model) {
                return view(
                    'layouts.dashboard.interest.components.actions',
                    ['model' => $model, 'url' => route('intersts.destroy', $model->id)]
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(InterestService $categoryService): QueryBuilder
    {
        return $categoryService->datatable($this->filters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('interests-table')
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
            Column::make('name')
                ->title(__('app.interests.title'))
                ->orderable(false),

            Column::make('status')
                ->title(__('app.interests.status'))
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
