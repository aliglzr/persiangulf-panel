<?php

namespace App\DataTables\Payment;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Payment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class PaymentsDataTable extends DataTable
{
    public static $rowIndex = 1;
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
            ->rawColumns(['status', 'user_id', 'data', 'amount', 'checkbox'])
            ->editColumn('id', function (Payment $model) {
                return convertNumbers($model->id);
            })
            ->editColumn('index',function (){
                self::$rowIndex++;
            })
            ->addColumn('checkbox',function (Payment $payment){
                return '<input class="form-check-input" type="checkbox" value="'.$payment->id.'" data-id="'.self::$rowIndex.'" onclick="add(event.target.value)"/>';
            })
            ->editColumn('user_id', function (Payment $model) {
                return '<a href="' . $model->user->getProfileLink() . '" class="fw-bold">' . $model->user->username . '</a>';
            })
            ->editColumn('amount', function (Payment $payment) {
                return convertNumbers(number_format($payment->amount) . '<span>') . get_svg_icon('svg/coins/toman.svg', 'svg-icon svg-icon-3') . '</span>';
            })
            ->editColumn('reference_id', function (Payment $payment) {
                return convertNumbers($payment->reference_id ?? '_');
            })
            ->editColumn('status', function (Payment $model) {
                $status = $model->getPaymentStatus();
                return "<span class='badge badge-light-" . $status['type'] . "'>" . $status['text'] . "</span>";
            })
            ->editColumn('data', function (Payment $model) {
                $content = $model->data;
                return auth()->user()->isManager() ? view('pages.payment._details', compact('content')) : null;
            })
            ->editColumn('updated_at', function (Payment $model) {
                return Verta::instance($model->updated_at)->persianFormat('j F Y در H:i');
            })
            ->addColumn('action', function (Payment $payment) {
                return view('pages.payment._action-menu', compact('payment'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Payment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payment $model)
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
            ->setTableId('payments-table')
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
            Column::make('status')->title('وضعیت'),
            Column::make('reference_id')->title('شماره پیگیری'),
            Column::make('updated_at')->title('تاریخ'),
        ], auth()->user()->isManager() ? [Column::make('data')->addClass('none')->title('سایر اطلاعات پرداخت'), Column::make('user_id')->title('کاربر'), Column::computed('action')->title('عملیات')->orderable(false)->searchable(false)->printable(false),Column::computed('checkbox')->title('انتخاب')->orderable(false)->searchable(false)->printable(false)] : []);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Payments_' . date('YmdHis');
    }
}
