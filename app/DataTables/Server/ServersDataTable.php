<?php

namespace App\DataTables\Server;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Server;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class ServersDataTable extends DataTable
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
            ->rawColumns(['active','country_id','actions','layer_id'])
            ->editColumn('updated_at', function (Server $model) {
                return Verta::instance($model->updated_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('country_id',function (Server $server){
                $flag = 'media/'.$server->country->flag;
                return '<span><img src="'. asset($flag) .'" class="rounded-circle h-20px me-2" alt="image"/>'. $server->country->slug .'</span>';
            })
            ->editColumn('layer_id',function (Server $server){
                return '<a href="'.route('layers.show',$server->layer).'">'.$server->layer->name.'</a>';
            })
            ->editColumn('active', function (Server $model) {
                return $model->active ? '<span class="badge badge-light-success">فعال</span>' : '<span class="badge badge-light-danger">غیر فعال</span>';
            })
            ->addColumn('actions', function (Server $model) {
                return view('pages.server._action-menu', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Server $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Server $model)
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
            ->setTableId('servers-table')
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
            Column::make('name')->title(__('نام')),
            Column::make('ip_address')->title(__('آدرس آیپی')),
            Column::make('description')->title('توضیحات')->addClass('d-none'),
            Column::make('city')->title('شهر'),
            Column::make('country_id')->title('کشور'),
            Column::make('layer_id')->title('لایه'),
            Column::make('active')->title('وضعیت'),
            Column::make('updated_at')->title('آخرین بروزرسانی'),
            Column::make('actions')->title('عملیات')->orderable(false)->searchable(false),
            Column::make('private_key')->title('آدرس فایل کلید خصوصی')->addClass('none'),
            Column::make('public_key')->title('آدرس فایل کلید عمومی')->addClass('none'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Servers_' . date('YmdHis');
    }
}
