<?php

namespace App\DataTables\Invoice;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Invoice;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class InvoicesDataTable extends DataTable
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
            ->rawColumns(['status','user_id','action','plans','total_amount','total_discount','net_amount_payable'])
            ->editColumn('id', function (Invoice $model) {
                return convertNumbers($model->id);
            })
            ->editColumn('user_id',function (Invoice $model){
                return '<a href="'.$model->user->getProfileLink().'" class="fw-bold">' .$model->user->username . '</a>';
            })
            ->editColumn('total_amount',function (Invoice $invoice){
                return convertNumbers(number_format($invoice->total_amount)).get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-primary ms-1');
            })
            ->editColumn('total_discount',function (Invoice $invoice){
                return $invoice->total_discount ? convertNumbers(number_format($invoice->total_discount)).get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-primary ms-1') : '';
            })
            ->editColumn('discount_id',function (Invoice $invoice){
                if (!is_null($invoice->discount)){
                    return $invoice->discount->code;
                }else{
                    $discount = '';
                    if ($invoice->user->isAgent()){
                        foreach ($invoice->planUsers()->get() as $plan){
                            if (!is_null($plan->discount)){
                                $discount .= $plan->discount->code;
                            }
                        }
                    }
                    return $discount;
                }
            })
            ->editColumn('net_amount_payable',function (Invoice $invoice){
                return convertNumbers(number_format($invoice->net_amount_payable)).get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-primary ms-1');
            })
            ->editColumn('created_at', function (Invoice $model) {
                return Verta::instance($model->created_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('action', function (Invoice $model) {
                return view('pages.invoice._action-menu',compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Invoice/InvoicesDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
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
            ->setTableId('invoices-table')
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
            Column::make('user_id')->title('کاربر'),
            Column::make('total_amount')->title('مبلغ کل'),
            Column::make('total_discount')->title(__('تخفیف')),
            Column::make('discount_id')->title('کد تخفیف'),
            Column::make('net_amount_payable')->title(__('مبلغ پرداخت شده')),
            Column::make('created_at')->title('تاریخ ثبت'),
            Column::make('action')->title('عملیات')->searchable(false)->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Invoices_' . date('YmdHis');
    }
}
