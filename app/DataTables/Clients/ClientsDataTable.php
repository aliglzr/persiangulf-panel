<?php

namespace App\DataTables\Clients;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
class ClientsDataTable extends DataTable
{

    private ?User $user;
    public function __construct(User $user = null) {
        $this->user = $user;
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->rawColumns(['username','action','introducer'])
            ->editColumn('username',function (User $model){
                return '<a href="'.route('clients.overview',$model).'" class="fw-bold">' .$model->username . '</a>';
            })
            ->addColumn('introducer',function (User $model){
                if ($model->introducer){
                    return '<a href="'.route('agents.overview',$model->introducer).'" class="fw-bold">' .$model->introducer?->username . '</a>';
                }else{
                    return 'تعیین نشده';
                }
            })
            ->addColumn('full_name',function (User $model){
                return $model->full_name;
            })
            ->editColumn('balance',function (User $model){
                return convertNumbers(number_format($model->balance));
            })
            ->filterColumn('full_name',function ($query,$keyword){
                    $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
                    return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('starts_at', function (User $model) {
                $hasAnySub = $model->subscriptions()->count();
                if ($hasAnySub == 0){
                    return 'بدون اشتراک';
                }else{
                    /** @var Subscription $lastSub */
                    $lastSub = $model->subscriptions()->where('id','!=',$model->getReservedSubscription()?->id)->latest()->first();
                    return Verta::instance($lastSub?->starts_at)->persianFormat('j F Y H:i:s');
                }
            })
            ->addColumn('ends_at', function (User $model) {
                $hasAnySub = $model->subscriptions()->count();
                if ($hasAnySub == 0){
                    return 'بدون اشتراک';
                }else{
                    /** @var Subscription $lastSub */
                    $lastSub = $model->subscriptions()->where('id','!=',$model->getReservedSubscription()?->id)->latest()->first();
                    return Verta::instance($lastSub->ends_at)->persianFormat('j F Y H:i:s');
                }
            })
            ->editColumn('created_at', function (User $model) {
                return Verta::instance($model->created_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('action', function (User $user) {
                return view('pages.agent.clients._action-menu',compact('user'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     */
    public function query(User $model)
    {
        if ($this->user){
            return $this->user->introduced()->role('client')->newQuery();
        }else{
            return User::role('client')->newQuery();
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('clients-table')
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
            Column::make('full_name')->title('نام مشتری'),
            Column::make('username')->title('نام کاربری'),
            Column::make('introducer')->title('معرف'),
            Column::make('balance')->title('اعتبار'),
            Column::make('starts_at')->title('شروع اعتبار'),
            Column::make('ends_at')->title('پایان اعتبار'),
            Column::make('created_at')->title(__('تاریخ ثبت مشتری')),
            Column::make('action')->title(__('عملیات'))->searchable(false)->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Clients_' . date('YmdHis');
    }
}
