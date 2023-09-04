<?php

namespace App\Http\Controllers\Manage;

use App\DataTables\Clients\SubscriptionsDataTable;
use App\DataTables\Invoice\InvoicesDataTable;
use App\DataTables\Payment\PaymentsDataTable;
use App\DataTables\Scopes\Clients\ClientsPayments;
use App\DataTables\Scopes\Clients\ClientsTransactions;
use App\DataTables\Scopes\Users\Invoices;
use App\DataTables\Transactions\TransactionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function subscriptions(User $user){
        $dataTable = new SubscriptionsDataTable($user);
        return $dataTable->render('pages.manager.index');
    }

    public function payments(User $user,Request $request){
        $payment = $request->payment ? Payment::find($request->payment) : null;
        if (!$user->isClient()){
            abort(404);
        }

        if (!auth()->user()->isManager() && auth()->user()->id != $user->id && !auth()->user()->can('view-client-financial') && !auth()->user()->introduced()->role('client')->where('id', $user->id)->first()) {
            abort(404);
        }

        $dataTable = new PaymentsDataTable();
        return $dataTable->addScope(new ClientsPayments($user,$payment))->render('pages.payment.index');
    }

    public function transactions(User $user){
        if (!$user->isClient()){
            abort(404);
        }
        if (!auth()->user()->isManager() && auth()->user()->id != $user->id && !auth()->user()->can('view-client-financial') && !auth()->user()->introduced()->role('client')->where('id', $user->id)->first()) {
            abort(404);
        }
        $dataTable = new TransactionsDataTable();
        return $dataTable->addScope(new ClientsTransactions($user))->render('pages.transactions.index');
    }


    public function invoices(User $user){
        if (!$user->isClient()){
            abort(404);
        }
        if (!auth()->user()->isManager() && auth()->user()->id != $user->id && !auth()->user()->can('view-client-financial') && !auth()->user()->introduced()->role('client')->where('id', $user->id)->first()) {
            abort(404);
        }
        $dataTable = new InvoicesDataTable();
        return $dataTable->addScope(new Invoices($user))->render('pages.invoice.index');
    }

}
