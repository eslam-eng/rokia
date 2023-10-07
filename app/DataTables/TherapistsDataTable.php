<?php

namespace App\DataTables;

use App\Enums\ActivationStatus;
use App\Models\User;
use App\Services\TherapistService;
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
            ->editColumn('status', function (User $user) {
                $classes = $user->status == ActivationStatus::ACTIVE->value ? 'badge badge-success' : 'badge badge-danger';
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($user->status)->name]);
            })->editColumn('gender', fn(User $user) => __('app.' . $user->gender))
            ->editColumn('created_at',fn(User $user)=>$user->created_at->format('Y-m-d'))
            ->addColumn('action', function (User $user) {
                return view(
                    'layouts.dashboard.therapist.components._actions',
                    ['model' => $user, 'url' => route('users.destroy', $user->id)]
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
            Column::make('name')->title(__('app.name')),
            Column::make('phone')->title(__('app.phone'))->orderable(false),
            Column::make('address')->title(__('app.address'))->orderable(false),
            Column::make('email')->title(__('app.email'))->orderable(false),
            Column::make('gender')->title(__('app.gender'))->orderable(false),
            Column::make('status')->title(__('app.status'))->orderable(false),
            Column::make('therapist_commission')->title(__('app.therapist_commission'))->orderable(false),
            Column::make('created_at'),
            Column::computed('action')
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
