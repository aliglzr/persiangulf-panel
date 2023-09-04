<?php


use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.Transaction.{transaction}', function (App\Models\User $user,\App\Models\Transaction $transaction) {
    if ($user->isManager() || $user->id === $transaction->user_id){
        return true;
    }else{
        return false;
    }
});

Broadcast::channel('App.Models.Ticket.{ticket}', function (App\Models\User $user,\App\Models\Ticket $ticket) {
    if ($user->isManager() || $user->hasRole('support') || $ticket->user_id == $user->id){
        return true;
    }else{
        return false;
    }
});



