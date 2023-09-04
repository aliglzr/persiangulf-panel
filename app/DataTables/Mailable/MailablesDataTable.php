<?php

namespace App\DataTables\Mailable;

use App\Core\Extensions\Datatable;
use App\Core\Extensions\Verta\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Qoraiche\MailEclipse\Facades\MailEclipse;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class MailablesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addIndexColumn()
            ->editColumn('modified', function (array $model) {
                return Verta::instance(date('Y-m-d H:i:s',$model['modified']))->persianFormat('j F Y H:i:s');
            })
            ->editColumn('name', function (array $model) {
                return $model['name'];
            })
            ->editColumn('subject', function (array $model) {
                return $model['subject'];
            })
            ->addColumn('action',function (array $model){
                return view('pages.mailable.index._action-menu',['mail' => $model]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return array|Collection
     */
    public function query(): array|Collection {
        return MailEclipse::getMailables();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('mailables-table')
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
            Column::make('DT_RowIndex')->title('شناسه'),
            Column::make('name')->title('نام ایمیل'),
            Column::make('subject')->title('موضوع ایمیل'),
            Column::make('modified')->title('آخرین بروزرسانی'),
            Column::make('action')->title('عملیات'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Mailables_' . date('YmdHis');
    }
}
