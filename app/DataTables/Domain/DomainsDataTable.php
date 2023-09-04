<?php

namespace App\DataTables\Domain;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Domain;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class DomainsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->rawColumns(['active','actions','server_id'])
            ->editColumn('active', function (Domain $model) {
                return $model->active ? '<span class="badge badge-light-success">فعال</span>' : '<span class="badge badge-light-danger">غیر فعال</span>';
            })
            ->editColumn('server_id',function (Domain $model){
                return '<span class="fw-bold">' .$model->server->name . '</span>';
            })
            ->editColumn('cdn',function (Domain $model){
                return match ($model->cdn) { "cf" => "CloudFlare", "ac" => "اَبر آروان", default => "--"};
            })
            ->editColumn('updated_at', function (Domain $model) {
                return Verta::instance($model->updated_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('actions', function (Domain $model) {
                return view('pages.domain._action-menu', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Domain $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Domain $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('domains-table')
            ->columns($this->getColumns())
            ->languageUrl($this->setLanguageUrl())
            ->minifiedAjax()
            ->stateSave(true)
            ->orderBy(0)
            ->responsive()
            ->autoWidth(false)
            ->parameters(['scrollX' => true])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('شناسه'),
            Column::make('hostname')->title('دامنه'),
            Column::make('server_id')->title('سرور'),
            Column::make('cdn')->title('CDN'),
            Column::make('active')->title('وضعیت'),
            Column::make('updated_at')->title('آخرین بروزرسانی'),
            Column::make('actions')->title('عملیات')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Domains_' . date('YmdHis');
    }
}
