<?php

namespace App\DataTables;

use App\Models\Result;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ParticipantResultsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Result> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Result $result) {
                return '<a title="show" href="' . route('results.show', $result->id) . '" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>';
            })
            ->addColumn('assessment_code', fn(Result $result) => $result->assessment?->code)
            ->editColumn('assessment', fn(Result $result) => $result->assessment?->title)
            ->editColumn('status', function (Result $result) {
                return '<span class="badge bg-' . \App\Enums\ResultStatusEnum::from($result->status)->badge() . ' fs-6 fw-normal px-2">'
                    . \App\Enums\ResultStatusEnum::from($result->status)->label()
                    . '</span>';
            })
            ->editColumn('created_at', fn (Result $result) => $result->created_at->format('M d, Y'))
            ->rawColumns(['status', 'action'])
            ->setRowId('id')
            ->removeColumn('updated_at', 'score');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Result>
     */
    public function query(Result $model): QueryBuilder
    {
        return Auth::user()->results()->with('assessment')->getQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('result-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('assessment'),
            Column::make('assessment_code'),
            Column::make('status'),
            Column::make('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Result_' . date('YmdHis');
    }
}
