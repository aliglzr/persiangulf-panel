<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Agents\AgentsDatatable;
use App\DataTables\Clients\ClientsDataTable;
use App\DataTables\Invoice\InvoicesDataTable;
use App\DataTables\Payment\PaymentsDataTable;
use App\DataTables\Plans\AgentPlansDataTable;
use App\DataTables\Scopes\Agents\AgentsPayments;
use App\DataTables\Scopes\Agents\AgentsTransactions;
use App\DataTables\Scopes\Users\Invoices;
use App\DataTables\Ticket\TicketsDataTable;
use App\DataTables\Transactions\TransactionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AgentController extends Controller
{
    public function index(AgentsDatatable $dataTable)
    {
        return $dataTable->render('pages.agent.index');
    }

    public function clients(User $user)
    {
        if(!\request()->expectsJson()) {
            abort(404);
        }
        if (!$user->isAgent()){
            abort(404);
        }
        if (!auth()->user()->isManager()){
            if (auth()->user()->id != $user->id && !auth()->user()->can('view-agent-clients')){
                abort(404);
            }
        }
        $dataTable = new ClientsDataTable($user);
        return $dataTable->render('pages.manager.index');
    }

    public function plans(User $user)
    {
        if(!\request()->expectsJson()) {
            abort(404);
        }
        if (auth()->user()->id != $user->id){
            if (!auth()->user()->can('view-agent-plans')){
                abort(404);
            }
        }
        $dataTable = new AgentPlansDataTable($user);
        return $dataTable->render('pages.manager.index');
    }

    public function tickets(?User $user)
    {
        if(!\request()->expectsJson()) {
            abort(404);
        }
        if (!auth()->user()->isManager()){
            if (auth()->user()->id != $user->id && !auth()->user()->can('view-agent-tickets')){
                abort(404);
            }
        }
        $dataTable = new TicketsDataTable($user);
        return $dataTable->render('pages.manager.index');
    }


    public function payments(User $user,Request $request){
        $payment = $request->payment ? Payment::find($request->payment) : null;
//        if(!\request()->expectsJson()) {
//            abort(404);
//        }
        if (!$user->isAgent()){
            abort(404);
        }
        if (!auth()->user()->isManager()){
            if (auth()->user()->id != $user->id && !auth()->user()->can('view-payment-table')){
                abort(404);
            }
        }
        $dataTable = new PaymentsDataTable();
        return $dataTable->addScope(new AgentsPayments($user,$payment))->render('pages.payment.index');
    }


    public function transactions(User $user){
//        if(!\request()->expectsJson()) {
//            abort(404);
//        }
        if (!$user->isAgent()){
            abort(404);
        }
        if (!auth()->user()->isManager()){
            if (auth()->user()->id != $user->id && !auth()->user()->can('view-transaction-table')){
                abort(404);
            }
        }
        $dataTable = new TransactionsDataTable();
        return $dataTable->addScope(new AgentsTransactions($user))->render('pages.transactions.index');
    }


    public function invoices(User $user){
//        if(!\request()->expectsJson()) {
//            abort(404);
//        }
        if (!$user->isAgent()){
            abort(404);
        }
        if (!auth()->user()->isManager()){
            if (auth()->user()->id != $user->id && !auth()->user()->can('view-invoice-table')){
                abort(404);
            }
        }
        $dataTable = new InvoicesDataTable();
        return $dataTable->addScope(new Invoices($user))->render('pages.invoice.index');
    }
}
