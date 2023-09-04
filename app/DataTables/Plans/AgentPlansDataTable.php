<?php

namespace App\DataTables\Plans;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class AgentPlansDataTable extends DataTable {
    public User $user;
    public bool $consumed;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
        return datatables()
            ->collection($query)
            ->addIndexColumn()
            ->rawColumns(['action', 'plan_price'])
            ->editColumn('id', function (PlanUser $planUser) {
                return $planUser->id;
            })
            ->editColumn('plan_price', function (PlanUser $planUser) {
                return convertNumbers(number_format($planUser->plan_price)).'<span>'.get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3').'</span>';
            })
            ->editColumn('plan_duration', function (PlanUser $planUser) {
                return convertNumbers(number_format($planUser->plan_duration)) . ' روزه ';
            })
            ->editColumn('plan_users_count', function (PlanUser $planUser) {
                return convertNumbers(number_format($planUser->plan_users_count)) . ' اشتراک ';
            })
            ->addColumn('bought_at', function (PlanUser $planUser) {
                return Verta::instance($planUser->created_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('consumed_at', function (PlanUser $planUser) {
                return Verta::instance($planUser->updated_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('action', function (PlanUser $planUser) {
                return view('pages.agent.plans._action-menu', compact('planUser'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Plan $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function query(PlanUser $model) {
        return PlanUser::where('user_id', $this->user->id)->where('remaining_user_count', '=', 0)->get();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() {
        return $this->builder()
            ->setTableId('agent-plans-table')
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
    protected function getColumns() {
        return [
            Column::make('DT_RowIndex')->title('ردیف'),
            Column::make('plan_title')->title('نام طرح'),
            Column::make('plan_price')->title('قیمت'),
            Column::make('plan_users_count')->title('تعداد کاربر'),
            Column::make('plan_duration')->title('مدت طرح'),
            Column::make('bought_at')->title('تاریخ خرید'),
            Column::make('consumed_at')->title('تاریخ اتمام طرح'),
            Column::make('action')->title('عملیات')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'AgentPlans_' . date('YmdHis');
    }
}
