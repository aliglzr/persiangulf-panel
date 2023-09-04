<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UsersNotifications\EmailChangedNotification;
use Illuminate\Http\Request;

class VerifyChangeEmailConfirmationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(401);
        }
        $user->email = $user->getData('temp_mail');
        $user->setData('temp_mail');
        $user->email_verified_at = null;
        $user->save();
        $user->sendEmailVerificationNotification();
        return redirect($user->getProfileLink());
    }
}
