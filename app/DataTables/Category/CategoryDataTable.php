<?php

namespace App\DataTables\Category;

use App\Enums\ActivationStatus;
use App\Models\Category;
use App\Models\Slider;
use App\Services\Category\CategoryService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
            ->editColumn('status', function (Category $model) {
                $classes = ($model->status == ActivationStatus::ACTIVE->value) ? 'badge-success' : 'badge-danger';
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($model->status)->getLabel()]);
            })
            ->addColumn('action', function (Category $model) {
                return view(
                    'layouts.dashboard.category.components.actions',
                    ['model' => $model, 'url' => route('categories.destroy', $model->id)]
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CategoryService $categoryService): QueryBuilder
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
            ->setTableId('categories-table')
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
                ->title(__('app.categories.title'))
                ->orderable(false),

            Column::make('status')
                ->title(__('app.categories.status'))
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
