<?php

namespace App\DataTables;

use App\Models\Content;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContentsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query): \Yajra\DataTables\DataTableAbstract
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = route('contents.show', $row->id);
                $deleteUrl = route('contents.destroy', $row->id);
                $csrf = csrf_token();

                return <<<HTML
                <a href="{$editUrl}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{$deleteUrl}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                    <input type="hidden" name="_token" value="{$csrf}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            HTML;
            })
            ->rawColumns(['action']) // important to render HTML
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Content $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Content $model): \Illuminate\Database\Eloquent\Builder
    {
        $query = $model->newQuery();

        // Get request params
        $university = request('university');
        $status = request('status');

        if ($university) {
            $query->where('university', $university);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('content-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->orderBy(0)
            ->buttons(['excel', 'csv', 'print', 'reset', 'reload']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('university'),
            Column::make('status'),
            Column::make('created_at')->title('Created At'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
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
        return 'Contents_' . date('YmdHis');
    }
}
