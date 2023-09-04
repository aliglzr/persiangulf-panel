<?php

namespace App\Http\Livewire\Plan\Agent;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public array $priceRange = [];
    public array $userCountRange = [];
    public array $durationRange = [];
    public bool $lessThan5GB = false;
    public bool $between5to10GB = false;
    public bool $between10to20GB = false;
    public bool $between20to50GB = false;
    public bool $between50to100GB = false;
    public bool $greaterThan100GB = false;


    protected $queryString = ['search' , 'priceRange' , 'userCountRange'];

    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->initFilter();
    }

    public function initFilter(){
        $this->search = '';
        $this->priceRange[0] = \App\Models\Plan::where('active',1)->where('inventory','>',0)->orderBy('price')->first()?->price;
        $this->priceRange[1] = \App\Models\Plan::where('active',1)->where('inventory','>',0)->orderByDesc('price')->first()?->price;
        $this->userCountRange[0] = \App\Models\Plan::where('active',1)->where('inventory','>',0)->orderBy('users_count')->first()?->users_count;
        $this->userCountRange[1] = \App\Models\Plan::where('active',1)->where('inventory','>',0)->orderByDesc('users_count')->first()?->users_count;
        $this->durationRange[0] = \App\Models\Plan::where('active',1)->where('inventory','>',0)->orderBy('duration')->first()?->duration;
        $this->durationRange[1] = \App\Models\Plan::where('active',1)->where('inventory','>',0)->orderByDesc('duration')->first()?->duration;
        $this->lessThan5GB = false;
        $this->between5to10GB = false;
        $this->between10to20GB = false;
        $this->between20to50GB = false;
        $this->between50to100GB = false;
        $this->greaterThan100GB = false;
    }

    public function updatingPriceRange($val){
        $this->resetPage();
    }
    public function updatingDurationRange($val){
        $this->resetPage();
    }

    public function updatingUserCountRange($val){
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilter(){
        $this->initFilter();
    }

    public function putValue($field,$value){
        $this->{$field} = $value;
    }

    public function render()
    {
        $plans = \App\Models\Plan::where('active',1)->where('inventory','>',0)->where('title', 'like', '%'.$this->search.'%')->whereBetween('price',$this->priceRange)->whereBetween('users_count',$this->userCountRange)->whereBetween('duration',$this->durationRange);
        if(auth()->user()->username != 'solidvpn_sales') {
            $plans->where('only_bot', false);
        }
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
        return view('livewire.plan.agent.index',['plans' => $plans->paginate(9)]);
    }
}
