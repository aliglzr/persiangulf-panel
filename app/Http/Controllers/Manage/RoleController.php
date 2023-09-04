<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Roles\RolesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable){
        return $dataTable->render('pages.role.index');
    }
}
