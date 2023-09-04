<?php

namespace App\DataTables\Scopes\Clients;

use App\Models\Payment;
use App\Models\User;
use Yajra\DataTables\Contracts\DataTableScope;

class ClientsPayments implements DataTableScope
{
    public User $user;
    public ?Payment $payment;

    public function __construct(User $user,Payment $payment = null)
    {
        $this->user = $user;
        $this->payment = $payment;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return !$this->payment ? $query->where('user_id', $this->user->id) : $query->where('user_id', $this->user->id)->where('id',$this->payment->id);
    }
}
