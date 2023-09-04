<?php

namespace App\DataTables\Logs;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;


class AuditLogsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
     *
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->rawColumns(['description', 'properties', 'event', 'causer_id','subject_id'])
            ->editColumn('subject_id', function (Activity $model) {
                $subject = $model->subject;
                if (is_null($subject)) {
                    return '';
                }
                else{
                    $link = null;
                    if ($subject instanceof User){
                        if($subject->isManager()) {
                            $link = route('managers.overview', $subject);
                        } else if($subject->isAgent()) {
                            $link = route('agents.overview', $subject);
                        } else if($subject->isClient()) {
                            $link = route('clients.overview', $subject);
                        }
                        else if($subject->hasRole('support')){
                            $link = route('support.index');
                        }
                    }
                    if($link != null) {
                        if (($subject instanceof User && $subject->isAgent()) || ($subject instanceof User && $subject->isManager()) || ($subject instanceof User && $subject->hasRole('support'))){
                            return '<a href="'.$link.'" class="badge badge-light-primary m-2">' .$subject->full_name . '</a>';
                        }else{
                            return '<a href="'.$link.'" class="badge badge-light-primary m-2">' .$subject->username . '</a>';
                        }
                    } else {
                        if ($subject instanceof Model){
                            return $subject->toJson( JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                        }else{
                            return '';
                        }
                    }
                }
            })
            ->editColumn('causer_id', function (Activity $model) {
                $causer = $model->causer;
                /* @var User $causer */
                $link = null;
                if($causer != null && $causer instanceof User) {
                    if($causer->isManager()) {
                        $link = route('managers.overview', $causer);
                    } else if($causer->isAgent()) {
                        $link = route('agents.overview', $causer);
                    } else if($causer->isClient()) {
                        $link = route('clients.overview', $causer);
                    }
                    else if($causer->hasRole('support')) {
                        $link = route('support.index');
                    }
                }
                if($link != null && $causer instanceof User) {
                    if ($causer->isAgent() || $causer->isManager() || $causer->hasRole('support')){
                        return '<a href="'.$link.'" class="badge badge-light-primary m-2">' .$causer?->full_name . '</a>';
                    }else{
                        return '<a href="'.$link.'" class="badge badge-light-primary m-2">' .$causer?->username . '</a>';
                    }
                } else {
                    return 'سیستم';
                }
            })
            ->editColumn('event', function (Activity $model) {
                return '<span class="badge badge-light-info m-2">' . __($model->event) . '</span>';
            })
            ->editColumn('properties', function (Activity $model) {
                $content = $model->properties;
                return view('pages.log.audit._details', compact('content'));
            })
            ->editColumn('created_at', function (Activity $model) {
                    return Verta::instance($model->created_at)->persianFormat('j F Y H:i:s');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  Activity  $model
     *
     * @return Activity|\Illuminate\Database\Eloquent\Builder
     */
    public function query(Activity $model): \Illuminate\Database\Eloquent\Builder|Activity {
       return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('activity-log-table')
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
            Column::make('id')->title('ردیف'),
            Column::make('log_name')->title('نام لاگ'),
            Column::make('event')->title('رویداد'),
            Column::make('description')->title('توضیحات')->addClass('none'),
            Column::make('subject_id')->addClass('none')->title('تاثیر پذیر'),
            Column::make('causer_id')->title('تاثیر گذار'),
            Column::make('created_at')->title('تاریخ ثبت'),
            Column::make('properties')->addClass('none')->title('سایر'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DataLogs_'.date('YmdHis');
    }
}
