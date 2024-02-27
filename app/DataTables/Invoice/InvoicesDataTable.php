<?php

namespace App\DataTables\Invoice;

use App\Enums\ActivationStatus;
use App\Models\Invoice;
use App\Services\Invoice\InvoiceService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoicesDataTable extends DataTable
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
            ->setRowClass(fn(Invoice $invoice)=>$invoice->status != ActivationStatus::ACTIVE->value ? 'bg-danger-transparent' : '' )
            ->editColumn('status', function (Invoice $invoice) {
                $classes = $invoice->status == ActivationStatus::ACTIVE->value ? 'badge-success' : 'badge-danger';
                return view('components._datatable-badge', ['class' => $classes, 'text' => __('app.general.' . ActivationStatus::from($invoice->status)->name)]);
            })
            ->editColumn('created_at', fn(Invoice $invoice) => $invoice->created_at->format('Y-m-d'))
            ->addColumn('action', function (Invoice $invoice) {
                return view(
                    'layouts.dashboard.invoice.components._actions',
                    ['model' => $invoice]
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(InvoiceService $model): QueryBuilder
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
            ->setTableId('invoice-table')
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
            Column::make('therapist.name')->title(__('app.therapists.name')),
            Column::make('therapist.phone')->title(__('app.therapists.phone'))->orderable(false),
            Column::make('items_count')->title(__('app.invoices.items_count'))->searchable(false),
            Column::make('status')->title(__('app.invoices.status'))->searchable(false),
            Column::make('sub_total')->title(__('app.invoices.sub_total'))->orderable(false)->searchable(false),
            Column::make('therapist_due')->title(__('app.invoices.therapist_due'))->orderable(false)->searchable(false),
            Column::make('grand_total')->title(__('app.invoices.grand_total'))->orderable(false),
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
