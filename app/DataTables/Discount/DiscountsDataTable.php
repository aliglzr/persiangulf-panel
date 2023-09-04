<?php

namespace App\DataTables\Discount;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Discount;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class DiscountsDataTable extends DataTable
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
            ->rawColumns(['action','user_id','plan_id','remaining_count','max'])
            ->editColumn('remaining_count',function (Discount $discount){
                if ($discount->remaining_count){
                    return '<span class="badge badge-light-success">'. convertNumbers($discount->remaining_count) .'</span>';
                }else {
                    return '<span class="badge badge-light-success">نامحدود</span>';
                }
            })
            ->editColumn('max',function (Discount $discount){
                if ($discount->max){
                    return '<span class="badge badge-light-success">'. convertNumbers($discount->max) .'</span>';
                }else {
                    return '<span class="badge badge-light-success">بدون سقف</span>';
                }
            })
            ->editColumn('percent',function (Discount $discount){
                return convertNumbers($discount->percent).'%';
            })
            ->editColumn('user_id',function (Discount $discount){
                if ($discount->user_id){
                    return '<a href="'.route('agents.overview',$discount->user()->first()).'" class="fw-bold">' .$discount->user()->first()?->username . '</a>';
                }else {
                    return '<span class="badge badge-light-success">همه کاربران</span>';
                }
            })
            ->editColumn('plan_id',function (Discount $discount){
                if ($discount->plan_id){
                    return '<span class="fw-bold">' .$discount->plan()->first()?->title . '</span>';
                }else {
                    return '<span class="badge badge-light-success">همه طرح ها</span>';
                }
            })
            ->editColumn('expires_at', function (Discount $model) {
                return is_null($model->expires_at) ? 'نامشخص' : Verta::instance($model->expires_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('created_at', function (Discount $model) {
                return Verta::instance($model->created_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('action',function (Discount $model){
                return view('pages.discount._action-menu', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Discount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Discount $model)
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
            ->setTableId('discounts-table')
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
            Column::make('code')->title('کد'),
            Column::make('remaining_count')->title('تعداد مانده'),
            Column::make('percent')->title('درصد تخفیف'),
            Column::make('max')->title('سقف تخفیف'),
            Column::make('user_id')->title('برای'),
            Column::make('plan_id')->title('روی'),
            Column::make('expires_at')->title('پایان اعتبار'),
            Column::make('created_at')->title('تاریخ ثبت کد'),
            Column::make('action')->title('عملیات')->searchable(false)->orderable(false),
            Column::make('description')->title('توضیحات')->addClass('d-none'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Discounts_' . date('YmdHis');
    }
}
