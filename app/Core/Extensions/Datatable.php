<?php


namespace App\Core\Extensions;


class Datatable extends \Yajra\DataTables\Services\DataTable {
    /**
     * Set language url option value.
     */
    public function setLanguageUrl(): string
    {
        return asset('js/Persian.json');
    }
}
