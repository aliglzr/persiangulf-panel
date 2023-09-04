<?php

namespace App\DataTables\Ticket;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class TicketsDataTable extends DataTable
{

    public ?User $user;

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
            ->eloquent($query)
            ->addIndexColumn()
            ->rawColumns(['action','status','rating','priority','title','assigned_to_user_id','user_id','category_id'])
            ->editColumn('title', function (Ticket $ticket) {
                return '<a href="'.route('support.show',$ticket).'" class="">'.Str::limit($ticket->title, 40).'<a/>';
            })
            ->editColumn('user_id', function (Ticket $ticket) {
                return '<a href="'.$ticket->user->getProfileLink().'">'.$ticket->user->username.'<a/>';
            })
            ->editColumn('assigned_to_user_id', function (Ticket $ticket) {
                $name = '';
                if ($ticket->assignedUser){
                   $name = (auth()->user()->isManager() || auth()->user()->isSupport()) ? $ticket->assignedUser->username : " پشتیبانی شماره ".convertNumbers($ticket->assignedUser->id);
                }
                return $ticket->assignedUser ? '<span>'.$name.'<span/>' : '<span class="badge badge-light-primary">نامشخص<span/>';
            })
            ->editColumn('updated_at', function (Ticket $ticket) {
                return Verta::instance($ticket->messages()->latest()->first()->updated_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('created_at', function (Ticket $ticket) {
                return Verta::instance($ticket->created_at)->persianFormat('j F Y H:i:s');
            })
            ->editColumn('status',function (Ticket $ticket){
                return '<span class="badge badge-'.$ticket->getTicketStatus()['color'].'">'. $ticket->getTicketStatus()['status'] .'</span>';
            })
            ->editColumn('category_id',function (Ticket $ticket){
                return '<span class="badge badge-light-primary">'. $ticket->category->name .'</span>';
            })
            ->editColumn('priority',function (Ticket $ticket){
                return '<span class="badge badge-'.$ticket->getTicketPriority()['color'].'">'. $ticket->getTicketPriority()['status'] .'</span>';
            })
            ->addColumn('action', function (Ticket $ticket) {
                $user = $this->user;
                return view('pages.ticket._action-menu', compact('ticket','user'));
            })
            ->addColumn('rating', function (Ticket $ticket) {
                if ($ticket->rating){
                return '<span class="badge badge-light-primary">'. convertNumbers($ticket->rating) .'</span>';
                }else{
                    return '<span class="badge badge-light-secondary">بدون امتیاز</span>';
                }
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Ticket $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ticket $model)
    {
        if (!is_null($this->user) && (!$this->user->isManager() && !$this->user->hasRole('support'))){
            return $model->where('user_id',$this->user->id)->newQuery();
        }else {
            return $model->newQuery();
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('tickets-table')
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
//            Column::make('id')->title('آیدی'),
            Column::make('ticket_id')->title('شماره تیکت'),
            Column::make('title')->title('عنوان تیکت'),
            Column::make('status')->title('وضعیت'),
            Column::make('priority')->title('اولویت'),
            Column::make('category_id')->title('واحد'),
            Column::make('user_id')->title('کاربر'),
            Column::make('assigned_to_user_id')->title('کاربر پاسخگو'),
            Column::make('updated_at')->title('آخرین بروزرسانی'),
            Column::make('created_at')->title('تاریخ ثبت'),
            Column::make('rating')->title('امتیاز'),
            Column::make('action')->title(' ')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Ticket_' . date('YmdHis');
    }
}
