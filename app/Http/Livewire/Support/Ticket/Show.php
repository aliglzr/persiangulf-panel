<?php

namespace App\Http\Livewire\Support\Ticket;

use App\Events\NewTicketMessage;
use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketsNotifications\NewTicketMessageNotification;
use App\Notifications\TicketsNotifications\SubmitReviewForTicketNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public User $user;
    public Ticket $ticket;
    public string $message = '';
    public $attachment;
    public ?string $rating = '0';
    public ?string $review = '';
    public string $submit_review = '';
    public Collection $ticketMessages;
    protected $queryString = ['submit_review' => ['except' => '']];

    public function mount(Ticket $ticket)
    {
        if ($ticket->user_id != auth()->user()->id && !auth()->user()->hasRole(['support','manager'])){
            abort(404);
        }
        $this->user = $ticket->user;
        $this->ticket = $ticket;
        $this->ticketMessages = $ticket->messages()->get();
    }

    protected $listeners = [
        'refreshTicket'
    ];

    public function getListeners()
    {
        return [
            "echo-private:App.Models.Ticket.".$this->ticket->id.",NewTicketMessage" => 'newTicketMessage',
            'refresh' => '$refresh'
        ];
    }

    public function newTicketMessage($data){
        if (isset($data['user_id']) && $data['user_id'] != auth()->user()->id){
            $this->dispatchBrowserEvent('newTicketMessage');
            $this->refreshTicket();
        }
    }

    public function rules()
    {
        return [
            'attachment' => [File::types(['pdf', 'jpeg', 'jpg', 'png', 'zip', 'docx', 'csv', 'odt', 'doc', 'gif'])->max(2 * 1024), 'nullable'],
            'message' => ['required', 'string','max:1000'],
            'rating' => [Rule::in(['0','1','2','3','4','5'])],
            'review' => ['nullable','string','max:1000']
        ];
    }

    public function refreshTicket(){
        $this->ticket = Ticket::find($this->ticket->id);
        $this->ticketMessages = $this->ticket->messages()->get();
        $this->dispatchBrowserEvent('ScrollDown');
    }


    public function updated($field)
    {
        $this->validateOnly($field, $this->rules());
    }

    public function reply()
    {
        if ($this->ticket->isLocked()){
            $this->dispatchBrowserEvent('alert',['type'=> 'warning', 'message' => 'امکان ثبت پاسخ بدلیل قفل شدن تیکت وجود ندارد']);
            return;
        }
        if ($this->ticket->isClosed()){
            $this->dispatchBrowserEvent('alert',['type'=> 'warning', 'message' => 'امکان ثبت پاسخ بدلیل بسته شدن تیکت وجود ندارد']);
            return;
        }
        $this->validate($this->rules());
        $message = $this->ticket->messages()->create([
            'user_id' => auth()->user()->id,
            'message' => htmlspecialchars(str_replace("\n",'[br]',$this->message))
        ]);
        if (is_null($this->ticket->assigned_to_user_id)){
            if (auth()->user()->hasRole(['support','manager'])){
                $this->ticket->assigned_to_user_id = auth()->user()->id;
            }
        }
        /** @var \App\Models\Message $message */
        if ($this->attachment){
            $name = md5(auth()->user()->id . time()) . '-' . time();
            $fileName = $name . '.' . $this->attachment->extension();
            $message->addMedia($this->attachment->getRealPath())->setName($name)->setFileName($fileName)->toMediaLibrary(diskName: 'uploads');
        }
        if ($message->user_id != $this->ticket->user_id && $this->ticket->user->hasVerifiedEmail()){
            $this->ticket->user->notify(new NewTicketMessageNotification($message));
        }
        NewTicketMessage::dispatch($message);
        $this->ticket->reopen();
        $this->refreshTicket();
        $this->resetForm();
    }

    public function submitReview(){
        try {
            $this->validate([
                'rating' => ['required',Rule::in(['0','1','2','3','4','5'])],
                'review' => ['nullable','string','max:1000']
            ]);
        }catch (ValidationException $validationException){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => $validationException->getMessage()]);
        }
        $this->ticket->review = $this->review;
        $this->ticket->rating = $this->rating;
        if (!empty($this->ticket->review) || !empty($this->ticket->rating)){
            $this->ticket->is_reviewed = true;
        }
        $this->ticket->save();
        $this->emit('refresh');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'با تشکر از شما، دیدگاه شما ثبت شد','timeOut' => 5000]);
    }

    public function resetForm(){
        $this->resetValidation();
        $this->message = '';
        $this->attachment = '';
    }

    public function markTicketAsResolved(){
        if ($this->ticket->isClosed() || $this->ticket->isLocked() || $this->ticket->isResolved()){
            $this->dispatchBrowserEvent('alert',['type' => 'warning' , 'message' => 'این تیکت بسته یا قفل شده است']);
            return ;
        }
        $this->ticket->markAsResolved();
        $this->ticket->close();
        $this->ticket->save();
        if ($this->ticket->user->hasVerifiedEmail()){
            $this->ticket->user->notify(new SubmitReviewForTicketNotification($this->ticket));
        }
        $this->redirect(route('support.tickets'));
    }

    public function setTicketStatusToProcessing(){
        if ($this->ticket->isClosed() || $this->ticket->isLocked()){
            $this->dispatchBrowserEvent('alert',['type' => 'warning' , 'message' => 'این تیکت بسته یا قفل شده است']);
            return ;
        }
        $this->ticket->status = 'processing';
        $this->ticket->save();
    }

    public function closeTicket()
    {
        if ($this->ticket->isClosed() || $this->ticket->isLocked()){
            $this->dispatchBrowserEvent('alert',['type' => 'warning' , 'message' => 'این تیکت بسته یا قفل شده است']);
            return ;
        }
        $this->ticket->close();
        $this->ticket->rating = $this->rating;
        $this->ticket->review = $this->review;
        if (!empty($this->ticket->review) || !empty($this->ticket->rating)){
            $this->ticket->is_reviewed = true;
        }else{
            if ($this->ticket->user->hasVerifiedEmail()){
                $this->ticket->user->notify(new SubmitReviewForTicketNotification($this->ticket));
            }
        }
        $this->ticket->save();
        $this->redirect(route('support.tickets'));
    }


    public function render()
    {
        return view('livewire.support.ticket.show');
    }
}
