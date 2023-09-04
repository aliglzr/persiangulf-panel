<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Domain\DomainsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(DomainsDataTable $dataTable) {
        return $dataTable->render('pages.domain.index');
    }
}
