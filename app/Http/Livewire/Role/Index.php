<?php

namespace App\Http\Livewire\Role;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public Collection $roles;

    protected $listeners = [
        'refreshRoles'
    ];

    public function mount(){
        $this->roles = Role::all();
    }

    public function refreshRoles(){
        $this->roles = Role::all();
    }

    public function delete(Role $role){
        if ($role->name != 'manager' && $role->name != 'agent' && $role->name != 'client'){
            $role->delete();
            $this->roles = Role::all();
//            $this->emitSelf('refreshRoles');
        }
    }

    public function render()
    {
        return view('livewire.role.index');
    }
}
