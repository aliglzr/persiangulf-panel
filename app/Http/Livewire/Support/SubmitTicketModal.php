<?php

namespace App\Http\Livewire\Support;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketsNotifications\NewTicketNotification;
use Coderflex\LaravelTicket\Models\Category;
use Coderflex\LaravelTicket\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\File;

class SubmitTicketModal extends Component
{
    public User $user;
    public Ticket $ticket;
    public $attachment = null;
    public int $category_id = 0;
    public string $message = '';
    use WithFileUploads;
    public bool $is_ticket_submitted = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->ticket = new Ticket();
        $this->ticket->priority = 'low';
        $this->category_id = 1;
    }

    public function rules()
    {
        return [
            'ticket.title' => ['required', 'string', 'max:100'],
            'ticket.priority' => ['required','string',Rule::in(['low','medium','high'])],
            'category_id' => ['required', 'numeric', Rule::in(Category::all()->pluck('id')->toArray())],
            'message' => ['required','string','max:1000'],
            'attachment' => [File::types(['pdf','jpeg','jpg','png','zip','docx','csv','odt','doc','gif'])->max(2 * 1024),'nullable'],
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules());
    }

    public function submitTicket()
    {
        if($this->is_ticket_submitted){
            return;
        }
        $this->validate($this->rules());
        $this->ticket->user_id = $this->user->id;
        $this->ticket->status = 'open';
        $this->ticket->ticket_id = Ticket::generateTicketId();
        $this->ticket->category_id = $this->category_id;
        $this->ticket->save();
        $message = $this->ticket->messages()->create([
            'user_id' => $this->user->id,
            'message' => htmlspecialchars(str_replace("\n",'[br]',$this->message))
        ]);
        /** @var \App\Models\Message $message */
        if ($this->attachment){
            $name = md5(auth()->user()->id . time()) . '-' . time();
            $fileName = $name . '.' . $this->attachment->extension();
            $message->addMedia($this->attachment->getRealPath())->setName($name)->setFileName($fileName)->toMediaLibrary(diskName: 'uploads');
        }
        if ($this->ticket->user->hasVerifiedEmail()){
            $this->ticket->user->notify(new NewTicketNotification($this->ticket));
        }
        $this->dispatchBrowserEvent('toggleSubmitTicketModal');
        $this->emit('refreshRecentTicketTable');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'تیکت شما با موفقیت ثبت شد','redirect' => route('support.show',$this->ticket)]);
        $this->is_ticket_submitted = true;
    }

    public function resetModal()
    {
        $this->resetValidation();
        $this->attachment = null;
        $this->message = '';
        $this->ticket = new Ticket();
    }

    public function render()
    {
        return view('livewire.support.submit-ticket-modal');
    }
}
