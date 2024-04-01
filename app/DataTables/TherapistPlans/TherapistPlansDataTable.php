<?php

namespace App\DataTables\TherapistPlans;

use App\Enums\ActivationStatus;
use App\Models\TherapistPlan;
use App\Services\Plans\TherapistPlansService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TherapistPlansDataTable extends DataTable
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
            ->editColumn('status', fn (TherapistPlan $therapistPlan)=>$therapistPlan->therapist->name)
            ->editColumn('status', function (TherapistPlan $therapistPlan) {
                $classes = ActivationStatus::from($therapistPlan->status)->getClasses();
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($therapistPlan->status)->getLabel()]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TherapistPlansService $model): QueryBuilder
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
            ->setTableId('therapist-plans-table')
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
                ->title(__('app.therapist_plan.name')),

            Column::make('therapist_id')
                ->title(__('app.therapists.therapist')),

            Column::make('price')
                ->title(__('app.therapist_plan.price'))
                ->searchable(false)
                ->orderable(false),

            Column::make('roznama_number')
                ->title(__('app.rozmana.rozmana_count'))
                ->searchable(false)
                ->orderable(false),

            Column::make('status')
                ->title(__('app.therapist_plan.status'))
                ->searchable(false)
                ->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Therapists_Plans_' . date('YmdHis');
    }
}
