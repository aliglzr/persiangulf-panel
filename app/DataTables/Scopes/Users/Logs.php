<?php

namespace App\DataTables\Scopes\Users;

use App\Models\User;
use Yajra\DataTables\Contracts\DataTableScope;

class Logs implements DataTableScope
{
    public User $user;
    public function __construct(User $user) {
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
         return $query->where(function ($query){
             return $query->where('causer_id', $this->user->id)->where('causer_type',User::class);
         })->orWhere(function ($query){
             return $query->where('subject_id', $this->user->id)->where('subject_type',User::class);
         });
    }
}
