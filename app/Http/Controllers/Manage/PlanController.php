<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Plans\PlansDataTable;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * return a table that listing plans
     * @param PlansDataTable $dataTable
     * @return mixed
     */
    public function index(PlansDataTable $dataTable): mixed
    {
        return $dataTable->render('pages.plan.manager.index');
    }
}
