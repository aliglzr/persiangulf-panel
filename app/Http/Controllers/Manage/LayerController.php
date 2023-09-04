<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Clients\ClientsDataTable;
use App\DataTables\Layer\LayersDataTable;
use App\DataTables\Scopes\Layer\LayerClientsScope;
use App\DataTables\Scopes\Layer\LayerServersScope;
use App\DataTables\Server\ServersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Layer;
use Illuminate\Http\Request;

class LayerController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view-layer');
    }

    public function index(LayersDataTable $dataTable)
    {
        return $dataTable->render('pages.layer.index');
    }

    public function servers(Layer $layer)
    {
        if (!\request()->wantsJson()){
            abort(404);
        }
        if (!auth()->user()->can('view-server')) {
            abort(403);
        }
        $dataTable = new ServersDataTable();
        return $dataTable->addScope(new LayerServersScope($layer))->render('pages.server.index');
    }

    public function clients(Layer $layer)
    {
        if (!\request()->wantsJson()){
            abort(404);
        }
        if (!auth()->user()->can('view-server')) {
            abort(403);
        }
        $dataTable = new ClientsDataTable();
        return $dataTable->addScope(new LayerClientsScope($layer))->render('pages.client.index');
    }
}
