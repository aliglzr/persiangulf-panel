<?php

namespace App\Http\Livewire\Support\Ticket\Actions;

use App\Models\Ticket;
use App\Models\User;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ChangeCategory extends Component
{
    public Ticket $ticket;
    public User $user;

    public function mount(Ticket $ticket){
        $this->ticket = $ticket;
        $this->user = auth()->user();
    }

    public function rules(): array
    {
        return [
            'ticket.category_id' => ['required','string','max:20',Rule::in(Category::all()->pluck('id')->toArray())],
        ];
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function changeCategory(){
        $this->validate($this->rules());
        if ($this->ticket->isClosed() || $this->ticket->isLocked()){
            $this->dispatchBrowserEvent('alert',['type' => 'warning' , 'message' => 'این تیکت بسته یا قفل شده است']);
            return ;
        }
        $this->ticket->save();
        $category_name = $this->ticket->category->name;
        $this->ticket->messages()->create([
            'user_id' => $this->user->id,
            'message' => "تیکت شما به واحد $category_name ارجاع داده شد"
        ]);
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => 'واحد ارجاع با موفقیت ویرایش شد']);
        $this->dispatchBrowserEvent('toggleCategoryModal');
        $this->emit('refreshTicket');
        $this->resetModal();
    }

    public function resetModal(){
        $this->resetValidation();
    }


    public function render()
    {
        return view('livewire.support.ticket.actions.change-category');
    }
}
