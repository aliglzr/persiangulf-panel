<?php

namespace App\DataTables\Layer;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Layer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class LayersDataTable extends DataTable
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
            ->rawColumns(['active','actions','name'])
            ->editColumn('name',function (Layer $model){
                return '<a href="'.route('layers.show',$model).'" class="fw-bold">' .$model->name . '</a>';
            })
            ->editColumn('max_client', function (Layer $model) {
                return convertNumbers(number_format($model->max_client));
            })
            ->editColumn('load', function (Layer $model) {
                return convertNumbers($model->load);
            })
            ->addColumn('servers_count',function (Layer $model){
                return convertNumbers($model->servers()->count());
            })
            ->addColumn('clients_count',function (Layer $model){
                return convertNumbers($model->users()->count());
            })
            ->editColumn('updated_at', function (Layer $model) {
                return Verta::instance($model->updated_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('active', function (Layer $model) {
                return $model->active ? '<span class="badge badge-light-success">فعال</span>' : '<span class="badge badge-light-danger">غیر فعال</span>';
            })
            ->addColumn('actions', function (Layer $model) {
                return view('pages.layer._action-menu', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Layer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Layer $model)
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
            ->setTableId('layers-table')
            ->columns($this->getColumns())
            ->languageUrl($this->setLanguageUrl())
            ->minifiedAjax()
            ->stateSave(true)
            ->orderBy(1)
            ->responsive()
            ->autoWidth(true)
            ->parameters(['scrollX' => false])
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
            Column::make('name')->title('نام لایه'),
            Column::make('load')->title('ضریب'),
            Column::make('max_client')->title('سقف مشترک'),
            Column::make('servers_count')->title('تعداد سرور ها'),
            Column::make('clients_count')->title('تعداد مشترک'),
            Column::make('active')->title('وضعیت'),
            Column::make('updated_at')->title('آخرین بروزرسانی'),
            Column::make('actions')->title(__('عملیات'))->searchable(false)->orderable(false),
            Column::make('db_hostname')->title('آدرس دیتابیس')->addClass('none'),
            Column::make('db_port')->title('پورت دیتابیس')->addClass('none'),
            Column::make('db_name')->title('نام دیتابیس')->addClass('none'),
            Column::make('db_username')->title('نام کاربری')->addClass('none'),
            Column::make('db_password')->title('گذرواژه')->addClass('none'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Layers_' . date('YmdHis');
    }
}
