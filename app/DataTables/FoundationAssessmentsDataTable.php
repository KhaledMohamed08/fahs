<?php

namespace App\DataTables;

use App\Models\Assessment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Enums\DifficultyLevelEnum;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class FoundationAssessmentsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Assessment> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Assessment $assessment) {
                return '<a title="show" href="' . route('assessments.show', $assessment->id) . '" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>';
                // return view('partials.datatables.foundation-assessments', compact('assessment'))->render();
            })
            ->editColumn('difficulty_level', function (Assessment $assessment) {
                return '<span class="badge bg-' . \App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->badge() . ' fs-6 fw-normal px-2">'
                    . \App\Enums\DifficultyLevelEnum::from($assessment->difficulty_level)->label()
                    . '</span>';
            })
            ->editColumn('passing_percent', function(Assessment $assessment) {
                return '<span class="text-center">' . $assessment->passing_percent . '%' . '</span>';
                return $assessment->passing_percent . '%';
            })
            ->editColumn('auto_grade', function (Assessment $assessment) {
                return $assessment->auto_grade
                    ? '<span class="text-success">Enabled</span>'
                    : '<span class="text-danger">Disabled</span>';
            })
            ->editColumn('duration_minutes', function(Assessment $assessment) {
                return $assessment->duration_minutes > 0 ? $assessment->duration_minutes . ' mins' : ' --';
            })
            ->editColumn('is_active', function (Assessment $assessment) {
                return $assessment->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->editColumn('access', function (Assessment $assessment) {
                return $assessment->access == 'public'
                    ? '<span class="text-primary">Public</span>'
                    : '<span class="text-danger">Private</span>';
            })
            
            ->editColumn('created_at', fn (Assessment $assessment) => $assessment->created_at->format('M d, Y'))
            ->addColumn('category', fn(Assessment $assessment) => $assessment->category?->title)
            ->removeColumn('updated_at', 'description', 'passing_percent')
            ->rawColumns(['action', 'difficulty_level', 'is_active', 'access', 'auto_grade', 'passing_percent'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Assessment>
     */
    public function query(Assessment $model): QueryBuilder
    {
        return Auth::user()->assessments()->with('category')->getQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('assessments-table')
                    ->columns($this->getColumns())
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['export', 'print', 'reset', 'reload'],
                    ])
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
            Column::make('code'),
            Column::make('title'),
            Column::make('difficulty_level')
                    ->title('Difficulty'),
            Column::make('auto_grade'),
            Column::make('access'),
            Column::make('duration_minutes')
                    ->title('Duration'),
            Column::make('is_active')
                    ->title('Status'),
            Column::make('category'),
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
        return 'Assessments_' . date('YmdHis');
    }
}
