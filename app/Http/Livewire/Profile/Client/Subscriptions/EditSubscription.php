<?php

namespace App\Http\Livewire\Profile\Client\Subscriptions;

use App\Jobs\V2ray\ActiveConnections;
use App\Jobs\V2ray\DeactiveConnections;
use App\Models\Subscription;
use Carbon\Carbon;
use Livewire\Component;

class EditSubscription extends Component
{
    public Subscription $subscription;
    public string $total_traffic = '';

    protected $listeners = ['editSubscription' => 'editMode'];

    public function mount(){
        $this->subscription = new Subscription();
    }

    public function attributes(){
        return [
            'total_traffic' => 'کل ترافیک',
        ];
    }

    public function editMode(int $id){
        $this->subscription = Subscription::find($id);
        $this->total_traffic = $this->subscription->total_traffic / (1024 * 1024);
        $this->dispatchBrowserEvent('toggleEditSubscriptionModal');
    }

    public function rules(): array
    {
        return [
            'total_traffic' => ['required','numeric','min:1'],
            'subscription.duration' => ['required','numeric'],
            'subscription.using' => ['required','boolean'],
        ];
    }


    public function updated($field){
        $this->validateOnly($field,$this->rules(),attributes: $this->attributes());
    }

    public function edit(){
        /** @var Subscription $subscription */
        $subscription = Subscription::find($this->subscription->id);
        $this->validate($this->rules(),attributes: $this->attributes());
        $this->subscription->total_traffic = $this->total_traffic * (1024 * 1024);
        $this->subscription->ends_at = Carbon::instance($this->subscription->starts_at)->addDays($this->subscription->duration);

        if (($this->subscription->remaining_traffic < 0 && $subscription->remaining_traffic > 0 && $subscription->using) || (!$this->subscription->using && $subscription->using) || now() > $this->subscription->ends_at){
            $subscription->client->deactivateConnections();
            $this->subscription->using = false;
        }elseif ( (($this->subscription->remaining_traffic > 0 && $this->subscription->using && !$subscription->using) || ($this->subscription->remaining_traffic > 0 && $subscription->remaining_traffic < 0 && $this->subscription->using)) && now() < $this->subscription->ends_at ){
            $subscription->client->activeConnections();
            $this->subscription->using = true;
        }
        activity('بروزرسانی اشتراک')->event('updated')->causedBy(auth()->user())->on($this->subscription)->withProperties(['before' => $subscription->toArray(),'after' => $this->subscription->toArray()])->log('بروزرسانی اشتراک توسط ادمین');
        $this->subscription->save();
        $this->emit('updateSubscription', $this->subscription->id);
        $this->emit('updateSubscriptions');
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => 'اشتراک با موفقیت ویرایش شد']);
        $this->dispatchBrowserEvent('updateTable');
        $this->dispatchBrowserEvent('toggleEditSubscriptionModal');
    }

    public function resetModal(){
        $this->resetValidation();
        $this->subscription = new Subscription();
        $this->total_traffic = '';
    }

    public function render()
    {
        return view('livewire.profile.client.subscriptions.edit-subscription');
    }
}
