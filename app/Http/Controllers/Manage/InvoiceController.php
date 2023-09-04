<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Invoice\InvoicesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(InvoicesDataTable $dataTable) {
        return $dataTable->render('pages.invoice.index');
    }
}
