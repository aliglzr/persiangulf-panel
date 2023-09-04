<?php

namespace App\Http\Livewire\Client\Subscription;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public array $priceRange = [];
    public array $durationRange = [];
    public bool $lessThan5GB = false;
    public bool $between5to10GB = false;
    public bool $between10to20GB = false;
    public bool $between20to50GB = false;
    public bool $between50to100GB = false;
    public bool $greaterThan100GB = false;


    protected $queryString = ['search' , 'priceRange'];

    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->initFilter();
    }

    public function initFilter(){
        $this->search = '';
        $this->priceRange[0] = \App\Models\Plan::where('active',1)->orderBy('sell_price')->first()?->sell_price;
        $this->priceRange[1] = \App\Models\Plan::where('active',1)->orderByDesc('sell_price')->first()?->sell_price;
        $this->durationRange[0] = \App\Models\Plan::where('active',1)->orderBy('duration')->first()?->duration;
        $this->durationRange[1] = \App\Models\Plan::where('active',1)->orderByDesc('duration')->first()?->duration;
        $this->lessThan5GB = false;
        $this->between5to10GB = false;
        $this->between10to20GB = false;
        $this->between20to50GB = false;
        $this->between50to100GB = false;
        $this->greaterThan100GB = false;
    }
    public function increaseBalance($deficiencyAmount) {
        $this->emitTo('layout.modals.wallet-balance.wallet-balance-modal', 'increase-wallet-balance', $deficiencyAmount);
    }

    public function updatingPriceRange($val){
        $this->resetPage();
    }
    public function updatingDurationRange($val){
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilter(){
        $this->initFilter();
    }

    public function buy(int $id){
        $this->emit('buySubscription'.$id);
    }

    public function putValue($field,$value){
        $this->{$field} = $value;
    }

    public function render()
    {
        $user = User::where('username','solidvpn_sales')->first();
        if (is_null($user)){
            abort(404);
        }
        $plans = $user->plans()->where('plan_user.only_bot', false)->where('plan_user.active',1)->where('plan_user.remaining_user_count','>',0);
        $plans = $plans->newQuery()->where('title', 'like', '%'.$this->search.'%')->whereBetween('sell_price',$this->priceRange)->whereBetween('duration',$this->durationRange);

        $plans->where(function ($plans) {
            if ($this->lessThan5GB){
                $plans->orWhere('traffic','<',5 * 1024 * 1024 * 1024);
            }
            if ($this->between5to10GB){
                $plans->orWhereBetween('traffic',[5 * 1024 * 1024 * 1024,10 * 1024 * 1024 * 1024]);
            }
            if ($this->between10to20GB){
                $plans->orWhereBetween('traffic',[10 * 1024 * 1024 * 1024,20 * 1024 * 1024 * 1024]);
            }
            if ($this->between20to50GB){
                $plans->orWhereBetween('traffic',[20 * 1024 * 1024 * 1024,50 * 1024 * 1024 * 1024]);
            }
            if ($this->between50to100GB){
                $plans->orWhereBetween('traffic',[50 * 1024 * 1024 * 1024,100 * 1024 * 1024 * 1024]);
            }
            if ($this->greaterThan100GB){
                $plans->orWhere('traffic','>',100 * 1024 * 1024 * 1024)->orWhereNull('traffic');
            }
        });
        return view('livewire.client.subscription.index',['plans' => $plans->paginate(9)]);
    }
}
