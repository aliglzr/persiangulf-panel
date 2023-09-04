<?php

namespace App\DataTables\Scopes\Layer;

use App\Models\Layer;
use Yajra\DataTables\Contracts\DataTableScope;

class LayerServersScope implements DataTableScope
{

    public Layer $layer;

    public function __construct(Layer $layer)
    {
        $this->layer = $layer;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
         return $query->where('layer_id', $this->layer->id);
    }
}
