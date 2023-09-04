<?php

namespace App\DataTables\Plans;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class PlansDataTable extends DataTable
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
            ->collection($query)
            ->addIndexColumn()
            ->rawColumns(['description', 'active','traffic','sell_price','price'])
            ->editColumn('price', function (Plan $model) {
                return convertNumbers(number_format($model->price)).'<span>'.get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3').'</span>';
            })
            ->editColumn('sell_price', function (Plan $model) {
                return convertNumbers(number_format($model->sell_price)).'<span>'.get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3').'</span>';
            })
            ->editColumn('users_count', function (Plan $model) {
                return convertNumbers(number_format($model->users_count));
            })
            ->editColumn('inventory', function (Plan $model) {
                return convertNumbers(number_format($model->inventory));
            })
            ->editColumn('duration', function (Plan $model) {
                return convertNumbers(number_format($model->duration));
            })
            ->editColumn('traffic', function (Plan $model) {
                return is_null($model->traffic) ? '<span class="badge badge-light-info">نامحدود</span>' : convertNumbers(formatBytes($model->traffic));
            })
            ->editColumn('created_at', function (Plan $model) {
                return \App\Core\Extensions\Verta\Verta::instance($model->created_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('updated_at', function (Plan $model) {
                return \App\Core\Extensions\Verta\Verta::instance($model->updated_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('active', function (Plan $model) {
                return $model->active ? '<span class="badge badge-light-success">فعال</span>' : '<span class="badge badge-light-danger">غیر فعال</span>';
            })
            ->addColumn('action', function (Plan $model) {
                return view('pages.plan.manager._action-menu', compact('model'));
            });
    }


    public function query(Plan $model)
    {
        return Plan::all();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('plans-table')
            ->columns($this->getColumns())
            ->languageUrl($this->setLanguageUrl())
            ->minifiedAjax()
            ->stateSave(true)
            ->orderBy(0)
            ->responsive()
            ->autoWidth(true)
            ->parameters(['scrollX' => false, 'createdRow' => 'function(event) { console.log("Table Draw Callback"); console.log(event.target); }',])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('ردیف'),
            Column::make('title')->title('نام طرح'),
            Column::make('description')->title('توضیحات')->addClass('none'),
            Column::make('price')->title('قیمت'),
            Column::make('sell_price')->title('قیمت منصفانه فروش'),
            Column::make('users_count')->title('تعداد کاربر'),
            Column::make('traffic')->title('محدودیت حجم'),
            Column::make('duration')->title('مدت طرح'),
            Column::make('inventory')->title('موجودی'),
            Column::make('active')->title('وضعیت'),
            Column::make('created_at')->title('تاریخ ثبت'),
            Column::make('updated_at')->title('آخرین بروزرسانی'),
            Column::make('action')->title('عملیات')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Plans_' . date('YmdHis');
    }
}
