<?php

namespace App\DataTables\Mailable;

use App\Core\Extensions\Datatable;
use Qoraiche\MailEclipse\Facades\MailEclipse;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;


class TemplatesDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query) {
        return datatables()
            ->collection($query)->addIndexColumn()
            ->addColumn('action', function (\stdClass $template) {
                return view('pages.mailable-template.index._action-menu', ['template' => $template]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Mailable/TemplatesDataTable $model
     * @return \Illuminate\Support\Collection
     */
    public function query(): \Illuminate\Support\Collection {
        return MailEclipse::getTemplates();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html() {
        return $this->builder()
            ->setTableId('templates-table')
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
    protected function getColumns() {
        return [
            Column::make('DT_RowIndex')->title('شناسه'),
            Column::make('template_name')->title('نام قالب'),
            Column::make('template_slug')->title('عنوان قالب'),
            Column::make('template_type')->title('نوع قالب'),
            Column::make('template_view_name')->title('template_view_name'),
            Column::make('template_skeleton')->title('template_skeleton'),
            Column::make('template_description')->title('توضیحات قالب')->addClass('none'),
            Column::make('action')->title('عملیات'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'Templates_' . date('YmdHis');
    }
}
