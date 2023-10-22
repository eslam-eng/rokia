<?php

namespace App\DataTables\Lecture;

use App\Enums\ActivationStatus;
use App\Enums\PaymentTypesEnum;
use App\Models\Lecture;
use App\Models\User;
use App\Services\LectureService;
use App\Services\TherapistService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LecturesDatatable extends DataTable
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
            ->editColumn('status', function (Lecture $lecture) {
                $classes = $lecture->status == ActivationStatus::ACTIVE->value ? 'badge-success' : 'badge-danger';
                return view('components._datatable-badge', ['class' => $classes, 'text' => ActivationStatus::from($lecture->status)->name]);
            })
            ->editColumn('is_paid', function (Lecture $lecture) {
                $classes = $lecture->is_paid == 1 ? 'badge-danger' : 'badge-success';
                $text = $lecture->is_paid == 1 ? __('app.paid') : __('app.free');
                return view('components._datatable-badge', ['class' => $classes, 'text' => $text]);
            })

            ->editColumn('therapist_id',fn(Lecture $lecture)=>$lecture->therapist->name)

            ->editColumn('created_at',fn(Lecture $lecture)=>$lecture->created_at->format('Y-m-d'))

            ->addColumn('action', function (Lecture $lecture) {
                return view(
                    'layouts.dashboard.lecture.components._actions',
                    ['model' => $lecture, 'url' => route('therapist-lectures.destroy', $lecture->id)]
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LectureService $model): QueryBuilder
    {
        return $model->datatable(filters: $this->filters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('lectures-table')
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
            Column::make('title')->title(__('app.title'))->orderable(false),
            Column::make('description')->title(__('app.description'))->orderable(false),
            Column::make('price')->title(__('app.price'))->searchable(false),
            Column::make('is_paid')->title(__('app.is_paid'))->orderable(false)->searchable(false),
            Column::make('therapist_id')->title(__('app.therapist'))->orderable(false)->searchable(false),
            Column::make('status')->title(__('app.status'))->orderable(false)->searchable(false),
            Column::make('created_at')->searchable(false),
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
        return 'lectures_' . date('YmdHis');
    }
}
