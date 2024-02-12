<?php

namespace App\DataTables\Users;

use App\Enums\ActivationStatus;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->editColumn('status', function (User $admin) {
                $classes = $admin->status == ActivationStatus::ACTIVE->value ? 'badge-success' : 'badge-danger';
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($admin->status)->getLabel()]);
            })
            ->editColumn('gender', fn(User $admin) => __('app.general.' . $admin->gender))
            ->addColumn('role', fn(User $admin) => $admin->roles->first()?->name)
            ->addColumn('permissions_count', fn(User $admin) => $admin->roles->first()?->permissions_count ?? '-')
            ->editColumn('created_at', fn(User $admin) => $admin->created_at->format('Y-m-d'))
            ->addColumn('action', function (User $admin) {
                return view(
                    'layouts.dashboard.system.admin.components.actions',
                    ['model' => $admin, 'url' => route('users.destroy', $admin->id)]
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserService $model): QueryBuilder
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
            ->setTableId('admins-table')
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
                ->title("#"),
            Column::make('name')
                ->title(__('app.clients.name'))
                ->orderable(false)
                ->searchable(false),
            Column::make('role')
                ->title(__('app.admins.role'))
                ->orderable(false)
                ->searchable(false),

            Column::make('permissions_count')
                ->title(__('app.admins.permissions_count'))
                ->orderable(false)
                ->searchable(false),

            Column::make('phone')
                ->title(__('app.clients.phone'))
                ->orderable(false),
            Column::make('address')
                ->title(__('app.clients.address'))
                ->orderable(false),
            Column::make('email')
                ->title(__('app.clients.email'))
                ->orderable(false),
            Column::make('gender')
                ->title(__('app.clients.gender'))
                ->orderable(false)
                ->searchable(false),

            Column::make('status')
                ->title(__('app.clients.status'))
                ->orderable(false)
                ->searchable(false),
            Column::make('created_at')
                ->title(__('app.general.created_at'))
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
        return 'users' . date('YmdHis');
    }
}
