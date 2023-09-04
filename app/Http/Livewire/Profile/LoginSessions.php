<?php

namespace App\Http\Livewire\Profile;

use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Jenssegers\Agent\Agent;

class LoginSessions extends Component
{
    public Collection $sessions;
    public User $user;

    public function mount(User $user)
    {
        $this->user ??= $user;
        $this->initSessions();
    }

    public function destroyAllSessions()
    {
        $this->sessions->each(function ($session) {
            if ($session->id != \Illuminate\Support\Facades\Session::getId())
                $session->delete();
            activity('destroy_session')->causedBy(auth()->user())->event('destroy.session')->withProperties(['ip_address', request()->ip(), 'session' => $session])->log('پایان نشست');
        });
        $this->initSessions();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('messages.All sessions terminated')]);
    }

    public function destroySession(Session $session)
    {
        activity('destroy_session')->causedBy(auth()->user())->event('destroy.session')->withProperties(['ip_address', request()->ip(), 'session' => $session])->log('پایان نشست');
        $session->delete();
        $this->initSessions();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('messages.Session terminated')]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.profile.login-sessions');
    }

    private function initSessions()
    {
        $this->sessions = Session::where('user_id', $this->user->id)->get();
        $this->sessions->each(function ($session) {
            $session->agent = new Agent();
            $session->agent->setUserAgent($session->user_agent);
            $session->last_activity = Verta::instance(Carbon::createFromTimestamp($session->last_activity))->format("Y-m-d H:i:s");
        });
    }
}
