<?php

namespace App\Http\Livewire\Dashboard\Manager\Index;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    public int $monthlyClientIncrease = 0;
    public int $monthlySubscriptionIncrease = 0;
    public int $thisMonthSubscriptions = 0;
    public array $plansName = [];
    public array $plansSell = [];
    public array $annualNames = [];
    public array $annualSells = [];
    public Collection $bestThreeAgents;
    public Collection $bestThreeAgentsByActiveClients;

    public int $totalNotSettledIncome = 0;

    public array $currentMonthDays = [];
    public array $currentMonthSells = [];
    public int $thisMonthTotalSells = 0;
    public int $totalYearIncome = 0;

    public function mount()
    {
        $this->calculateMonthlyClientIncrease();
        $this->calculateMonthlySubscriptionIncrease();
        $this->countAndAddToArrayPlanSells();
        $this->countAndAddToArrayAnnualSells();
        $this->calculateCurrentMonthSells();
        $this->retrieveBestThreeAgents();
        $this->calculateTotalNotSettledIncome();
    }

    private function calculateMonthlyClientIncrease(): void
    {
        $lastMonthStartDate = \Carbon\Carbon::now()->subMonth(1)->startOfMonth();
        $lastMonthEndDate = \Carbon\Carbon::now()->subMonth(1)->endOfMonth();
        $thisMonthStartDate = \Carbon\Carbon::now()->startOfMonth();
        $thisMonthEndDate = \Carbon\Carbon::now()->endOfMonth();
        $lastMonthClients = User::role('client')->where('created_at', '>', $lastMonthStartDate)->where('created_at', '<', $lastMonthEndDate)->count();
        $thisMonthClients = User::role('client')->where('created_at', '>', $thisMonthStartDate)->where('created_at', '<', $thisMonthEndDate)->count();

        $this->monthlyClientIncrease = ($thisMonthClients / $lastMonthClients * 100) - 100;
    }

    private function calculateMonthlySubscriptionIncrease(): void
    {
        $lastMonthStartDate = \Carbon\Carbon::now()->subMonth(1)->startOfMonth();
        $lastMonthEndDate = \Carbon\Carbon::now()->subMonth(1)->endOfMonth();
        $thisMonthStartDate = \Carbon\Carbon::now()->startOfMonth();
        $thisMonthEndDate = \Carbon\Carbon::now()->endOfMonth();
        $lastMonthSubscriptions = Subscription::where('created_at', '>', $lastMonthStartDate)->where('created_at', '<', $lastMonthEndDate)->count();
        $thisMonthSubscriptions = Subscription::where('created_at', '>', $thisMonthStartDate)->where('created_at', '<', $thisMonthEndDate)->count();
        $this->thisMonthSubscriptions = $thisMonthSubscriptions;
        $this->monthlySubscriptionIncrease = ($thisMonthSubscriptions / $lastMonthSubscriptions * 100) - 100;
    }

    public function render()
    {
        return view('livewire.dashboard.manager.index.index');
    }

    private function countAndAddToArrayPlanSells(): void
    {
        /** @var Plan $plan */
        foreach (Plan::where('active', true)->select("traffic", "title", "duration")->distinct()->get() as $plan) {
            $this->plansName[] = $plan->title . "-" . convertNumbers(number_format($plan->duration)) . " روزه - " . formatBytes($plan->traffic, lang: "en");
            $this->plansSell[] = Subscription::join('plan_user', 'subscriptions.plan_user_id', '=', 'plan_user.id')
                ->where('plan_user.plan_traffic', $plan->traffic)
                ->where('plan_user.plan_duration', $plan->duration)
                ->distinct('subscriptions.id')
                ->count('subscriptions.id');
        }
    }

    private function calculateCurrentMonthSells(): void
    {
        // Get the current month and year using Carbon
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // Fetch the payments for the current month
        $payments = Payment::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'paid')
            ->where('reference_id', ">=",1)
            ->whereNotNull('reference_id')
            ->get();

        $payments->each(function ($payment) {
            $this->thisMonthTotalSells += $payment->amount;
        });

        // Group the payments by day and sum up the sell and buy amounts for each day
        $groupedPayments = $payments->groupBy(function ($payment) {
            return Carbon::parse($payment->created_at)->format('d');
        })->each(function ($group) {
            $amount = $group->sum('amount');
            $this->currentMonthDays[] = Carbon::parse($group->first()->created_at)->day . " " . Carbon::parse($group->first()->created_at)->locale("en")->shortMonthName;
            $this->currentMonthSells[] = $amount;
        });


    }

    private function retrieveBestThreeAgents()
    {
        $bestThreeAgents = User::role('agent')->where('active', true)
            ->whereNot('users.username', 'solidvpn_sales')
            ->get()->sortByDesc(function($user) {
                return $user->introduced()->count();
            })->take(10);
        $bestThreeAgentsByActiveClients = User::role('agent')->where('active', true)
            ->whereNot('users.username', 'solidvpn_sales')
            ->get()->sortByDesc(function($user) {
                return $user->introduced()->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                    ->where('subscriptions.using', true)
                    ->distinct('users.id')->count();
            })->take(10);
        $this->bestThreeAgents = collect();
        foreach ($bestThreeAgents as $bestThreeAgent) {
            $this->bestThreeAgents->push(User::find($bestThreeAgent->id));
        }
        $this->bestThreeAgentsByActiveClients = collect();
        foreach ($bestThreeAgentsByActiveClients as $bestThreeAgent) {
            $this->bestThreeAgentsByActiveClients->push(User::find($bestThreeAgent->id));
        }
    }

    private function calculateTotalNotSettledIncome(): void
    {// Fetch the payments for the current month
        $payments = Payment::where('status', 'paid')
            ->where('reference_id', ">=",1)
            ->whereNotNull('reference_id')
            ->where('checkout', 0)
            ->get();

        $payments->each(function ($payment) {
            $this->totalNotSettledIncome += $payment->amount;
        });
    }

    private function countAndAddToArrayAnnualSells(): void
    {
        /** @var Plan $plan */

        for ($i = 11; $i >= 0; $i--) {
            // Get the current month and year using Carbon
            $month = Carbon::now()->subMonth($i)->month;
            $year = Carbon::now()->subMonth($i)->year;
            $this->annualNames[] = Carbon::now()->subMonth($i)->locale("en")->monthName . " " . Carbon::now()->subMonth($i)->year;
            $solidSalesUserId = User::where('username','solidvpn_sales')->first()->id;
            // Fetch the payments for the current month
            $payments = Payment::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', 'paid')
                ->where('reference_id', ">=",1)
                ->whereNotNull('reference_id')
                ->whereNot('user_id', $solidSalesUserId)
                ->get();
            $thisMonthTotalSells = 0;
            foreach ($payments as $payment) {
                $thisMonthTotalSells += $payment->amount;
            }
            $this->annualSells[] = intval($thisMonthTotalSells);
            $this->totalYearIncome += intval($thisMonthTotalSells);
        }
    }
}
