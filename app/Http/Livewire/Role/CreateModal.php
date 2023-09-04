<?php

namespace App\Http\Livewire\Role;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateModal extends Component
{
    public Role $role;
    public array $permissions = [];
    public bool $editMode = false;
    protected $listeners = ['editRole' => 'editMode'];

    public function mount(){
        $this->role ??= new Role();
        $this->permissions = $this->role->permissions()->get()->pluck('name')->toArray();
    }

    public function rules(): array
    {
        if ($this->editMode){
            return [
                'role.name' => ['required','string',Rule::unique('roles','name')->ignore($this->role->id)],
                'role.slug' => ['required','string',Rule::unique('roles','slug')->ignore($this->role->id)],
                'permissions' => ['required','array',Rule::in(Permission::all()->pluck('name')->toArray())]
            ];
        } else{
            return [
                'role.name' => ['required','string','unique:roles,name'],
                'role.slug' => ['required','string','unique:roles,slug'],
                'permissions' => ['required','array',Rule::in(Permission::all()->pluck('name')->toArray())]
            ];
        }
    }


    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function create(){
        if (empty($this->permissions)){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'نقش باید حداقل یک دسترسی داشته باشد']);
        }
        $this->validate($this->rules());
        $this->role->save();
        $this->role->givePermissionTo($this->permissions);
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => $this->editMode ? 'نقش با موفقیت ویرایش شد' : 'نقش با موفقیت ثبت شد']);
        $this->dispatchBrowserEvent('toggleRoleModal');
        $this->emit('refreshRoles');
        $this->resetModal();
    }

    public function resetModal(){
        $this->resetValidation();
        $this->role = new Role();
        $this->permissions = [];
        $this->editMode = false;
    }

    public function editMode(int $id){
        $this->role = Role::find($id);
        $this->permissions = $this->role->permissions()->get()->pluck('name')->toArray();
        $this->dispatchBrowserEvent('toggleRoleModal');
        $this->editMode = true;
    }

    public function render()
    {
        return view('livewire.role.create-modal');
    }
}
