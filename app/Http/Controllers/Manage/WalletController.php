<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Wallets\WalletsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * return a table that listing plans
     * @param WalletsDataTable $dataTable
     * @return mixed
     */
    public function index(WalletsDataTable $dataTable): mixed
    {
        return $dataTable->render('pages.wallet.index');
    }
}
