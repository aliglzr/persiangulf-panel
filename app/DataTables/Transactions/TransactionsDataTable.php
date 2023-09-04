<?php

namespace App\DataTables\Transactions;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class TransactionsDataTable extends DataTable
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
            ->rawColumns(['status','user_id','data','description', 'amount', 'balance_before_transaction', 'balance_after_transaction'])
            ->editColumn('id', function (Transaction $model) {
                return convertNumbers($model->id);
            })
            ->editColumn('user_id',function (Transaction $model){
                return '<a href="'.route('agents.overview',$model->user).'" class="fw-bold">' .$model->user->username . '</a>';
            })
            ->editColumn('amount',function (Transaction $transaction){
                return '<span class="badge badge-light-'.($transaction->amount > 0 ? 'success' : "danger").'">'.convertNumbers(number_format(abs($transaction->amount))).'<span>'.get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3').'</span>'.'</span>';
            })
            ->editColumn('balance_before_transaction',function (Transaction $transaction){
                return convertNumbers(number_format($transaction->balance_before_transaction)).'<span>'.get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3').'</span>';
            })
            ->editColumn('balance_after_transaction',function (Transaction $transaction){
                return convertNumbers(number_format($transaction->balance_after_transaction)).'<span>'.get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3').'</span>';
            })
            ->addColumn('description',function (Transaction $transaction){
                $data = json_decode($transaction->data,true);
                if ($transaction->payment){
                    if(!empty($data) && isset($data['message'])){
                        return $data['message'];
                    }
                    else if ($transaction->user->isClient()){
                        return 'اقزایش اعتبار از طریق '.'<a href="'.route('clients.payments',['user' => $transaction->user,'payment' => $transaction->payment]).'" class="fw-bold">پرداخت</a>';
                    }else if($transaction->user->isAgent()){
                        return 'اقزایش اعتبار از طریق '.'<a href="'.route('agents.payments',['user' => $transaction->user,'payment' => $transaction->payment]).'" class="fw-bold">پرداخت</a>';
                    }
                }else if ($transaction->invoice){
                    return 'کاهش اعتبار به علت پرداخت '.'<a href="'.route('invoices.show',$transaction->invoice).'" class="fw-bold">صورتحساب</a>';
                }else{
                    return $data['message'];
                }
            })
            ->editColumn('data', function (Transaction $model) {
                $content = $model->data;
                return auth()->user()->isManager() ? view('pages.payment._details', compact('content')) : null;
            })
            ->editColumn('updated_at', function (Transaction $model) {
                return Verta::instance($model->updated_at)->persianFormat('j F Y در H:i');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Transaction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
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
            ->setTableId('transactions-table')
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
        return array_merge([
            Column::make('id')->title('شناسه'),
            Column::make('amount')->title('مبلغ'),
            Column::make('balance_before_transaction')->title('موجودی قبل از تراکنش'),
            Column::make('balance_after_transaction')->title('موجودی بعد از تراکنش'),
            Column::make('description')->title('توضیحات'),
            Column::make('updated_at')->title('تاریخ'),
        ], auth()->user()->isManager() ? [Column::make('data')->addClass('none')->title('سایر اطلاعات پرداخت'),Column::make('user_id')->title('کاربر'),] : []);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Transactions_' . date('YmdHis');
    }
}
