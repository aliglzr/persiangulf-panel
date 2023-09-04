<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Server\ServersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index(ServersDataTable $dataTable){
        return $dataTable->render('pages.server.index');
    }
}
