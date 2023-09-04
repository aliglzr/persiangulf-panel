<?php

namespace App\DataTables\Scopes\Agents;

use App\Models\User;
use Yajra\DataTables\Contracts\DataTableScope;

class AgentsTransactions implements DataTableScope
{
    public User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
         return $query->where('user_id', $this->user->id);
    }
}
