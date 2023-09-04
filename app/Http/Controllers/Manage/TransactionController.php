<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Transactions\TransactionsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(TransactionsDataTable $dataTable)
    {
        return $dataTable->render('pages.transactions.index');
    }
}
