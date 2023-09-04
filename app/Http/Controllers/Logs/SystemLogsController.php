<?php

namespace App\Http\Controllers\Logs;

use App\DataTables\Logs\AuditLogsDataTable;
use App\DataTables\Logs\SystemLogsDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Jackiedo\LogReader\LogReader;

class SystemLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SystemLogsDataTable $dataTable)
    {
        return $dataTable->render('pages.log.system.index');
    }

    public function logs(AuditLogsDataTable $dataTable){
        return $dataTable->render('pages.log.audit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, LogReader $logReader)
    {
        return $logReader->find($id)->delete();
    }
}
