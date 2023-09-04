<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Clients\ClientsDataTable;
use App\DataTables\Managers\ManagersDatatable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:manager')->only('index');
        $this->middleware('can:view-client-table')->only('clients');
    }

    public function index(ManagersDatatable $dataTable){
        return $dataTable->render('pages.manager.index');
    }

    public function clients(){
        $dataTable = new ClientsDataTable();
        return $dataTable->render('pages.client.index');
    }
}
