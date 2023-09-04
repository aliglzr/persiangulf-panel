<?php

namespace App\DataTables\Users;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;


class UsersDatatable extends DataTable
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
            ->rawColumns([ 'active','2fa_status','username'])
            ->editColumn('id', function (User $model) {
                return convertNumbers($model->id);
            })
            ->editColumn('username',function (User $model){
                return '<a href="'.route('managers.overview',$model).'" class="fw-bold">' .$model->username . '</a>';
            })
            ->editColumn('created_at', function (User $model) {
                    return Verta::instance($model->created_at)->persianFormat('j F Y H:i:s');
            })
            ->addColumn('last_login', function (User $model) {
                    return Verta::instance($model->getData('last_login'))->persianFormat('j F Y H:i:s');
            })
            ->addColumn('2fa_status', function (User $model) {
                return $model->has2faEnabled() ? '<span class="badge badge-light-success">فعال</span>' : '<span class="badge badge-light-danger">غیر فعال</span>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return Collection
     */
    public function query(User $model)
    {
        return User::role('manager')->get();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('managers-table')
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
            Column::make('first_name')->title(__('نام')),
            Column::make('last_name')->title(__('نام خانوادگی')),
            Column::make('username')->title('نام کاربری'),
            Column::make('email')->title('نشانی ایمیل'),
            Column::make('2fa_status')->title('احراز هویت دو عاملی'),
            Column::make('created_at')->title('تاریخ عضویت'),
            Column::make('last_login')->title('آخرین ورود'),
//            Column::make('properties')->addClass('none'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Managers_' . date('YmdHis');
    }
}
