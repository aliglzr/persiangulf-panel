<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Discount\DiscountsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-discount-table')->only('index');
    }

    public function index(DiscountsDataTable $dataTable)
    {
        return $dataTable->render('pages.discount.index');
    }
}
