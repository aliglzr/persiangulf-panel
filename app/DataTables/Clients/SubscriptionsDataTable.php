<?php

namespace App\DataTables\Clients;

use App\Core\Extensions\Verta\Verta;
use App\Models\Subscription;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use App\Core\Extensions\Datatable;

class SubscriptionsDataTable extends DataTable
{
    public User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

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
            ->rawColumns(['traffic'])
            ->addColumn('traffic', function (Subscription $model) {
                return is_null($model->total_traffic) ? '<span class="badge badge-light-info">نامحدود</span>' : convertNumbers(formatBytes($model->total_traffic));
            })
            ->addColumn('duration',function (Subscription $model){
                return convertNumbers($model->planUser->plan_duration.' روز');
            })
            ->addColumn('title',function (Subscription $model){
                return $model->planUser->plan_title;
            })
            ->editColumn('starts_at', function (Subscription $model) {
                return \App\Core\Extensions\Verta\Verta::instance($model->starts_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('ends_at', function (Subscription $model) {
                return \App\Core\Extensions\Verta\Verta::instance($model->ends_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('actions', function (Subscription $model) {
                return view('pages.subscription._action-menu', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Subscription $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function query(Subscription $model)
    {
        return $this->user->subscriptions()->where('using',false)->where('id','!=',$this->user->getReservedSubscription()?->id)->get();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('subscriptions-table')
            ->columns($this->getColumns())
            ->languageUrl($this->setLanguageUrl())
            ->minifiedAjax()
            ->stateSave(true)
            ->orderBy(0)
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
            Column::make('DT_RowIndex')->title('ردیف'),
            Column::make('title')->title('نام اشتراک'),
            Column::make('traffic')->title('محدودیت حجم'),
            Column::make('duration')->title('مدت اشتراک'),
            Column::make('starts_at')->title('زمان شروع'),
            Column::make('ends_at')->title('زمان اتمام'),
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
        return 'Clients_Subscriptions_' . date('YmdHis');
    }
}
