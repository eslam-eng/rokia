<?php

namespace App\DataTables\Roles;

use App\Services\RoleService;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RolesDatatable extends DataTable
{
    public function getTableId(): string
    {
        return 'roles-table';
    }

    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     *
     * @throws \Yajra\DataTables\Exceptions\Exception
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('is_active', function (Role $model) {
                $classes = $model->is_active ? 'badge-light-success text-dark' : 'badge-light-danger text-dark';
                $content = $model->is_active ? __('app.general.ACTIVE') : __('app.general.INACTIVE');

                return view('components._datatable-badge', ['class' => $classes, 'text' => $content]);
            })
            ->addColumn('action', fn (Role $model) => view(
                'layouts.dashboard.system.role.components.actions',
                ['model' => $model, 'url' => route('role.destroy', $model->id)]
            ));
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RoleService $roleService)
    {
        return $roleService->datatable($this->filters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return parent::html()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')
                ->title(__('pages.name'))
                ->orderable(false),
            Column::make('users_count')
                ->title(__('app.system.users_count'))
                ->orderable(false)
                ->searchable(false),
            Column::make('permissions_count')
                ->title(__('app.system.permissions_count'))
                ->orderable(false)
                ->searchable(false),
            Column::make('is_active')
                ->title(__('app.general.status'))
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
     */
    protected function filename(): string
    {
        return 'roles-'.date('YmdHis');
    }
}
