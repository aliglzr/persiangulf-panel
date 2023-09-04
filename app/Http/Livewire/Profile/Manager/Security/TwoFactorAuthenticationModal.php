<?php

namespace App\Http\Livewire\Profile\Manager\Security;

use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Recovery\Recovery;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TwoFactorAuthenticationModal extends Component
{
    public User $user;
    public string $secret;
    public string $code = '';
    public array $recoveryCodes = [];
    public bool $showRecoveryPhrase = false;

    public function rules(): array {
        return [
            'code' => ['numeric', 'digits:6', 'required']
        ];
    }
    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function mount(User $user) {
        $this->user ??= $user;
        $google2FA = new Google2FA();
        $this->secret = $google2FA->generateSecretKey();
    }

    /**
     * @throws ValidationException
     */
    public function updated($field) {
        $this->validateOnly($field, $this->rules());
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function disable2fa() {
        $google2FA = new Google2FA();
        $this->validate($this->rules());
        if($this->user->getData('2fa_enabled')) {
            if($google2FA->verify($this->code, $this->user->getData('2fa_secret'))) {
                // Delete 2fa_enabled
                $this->user->setData('2fa_enabled', 0);
                $this->user->setData('2fa_secret');
                $this->user->setData('recovery_codes');
                $this->secret = $google2FA->generateSecretKey();
                $this->code = '';
                activity('disable2fa')->causedBy(auth()->user())->event('disable2fa')->withProperties(['ip_address',request()->ip()])->log('غیر فعال سازی احراز هویت دو عاملی');
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('messages.Your two factor authentication disabled')]);
                $this->dispatchBrowserEvent('toggle-kt_modal_add_ask_google2fa_code');
                $this->emit('2faChanged', false);
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('messages.One-time code is invalid')]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('messages.Your two factor authentication is already disabled')]);
            $this->dispatchBrowserEvent('toggle-kt_modal_add_ask_google2fa_code');
        }
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function enable2fa() {
        $google2FA = new Google2FA();
        $recovery = new Recovery();
        $this->validate($this->rules());
        if(! $this->user->getData('2fa_enabled')) {
            if($google2FA->verify($this->code, $this->secret)) {
                // Delete 2fa_enabled
                $this->user->setData('2fa_enabled', 1);
                $this->user->setData('2fa_secret', $this->secret);
                $this->recoveryCodes = $recovery->setCount(4)->setBlocks(2)->setChars(20)->toArray();
                $this->user->setData('recovery_codes',$recovery->toJson());
                $this->showRecoveryPhrase = true;
                $this->secret = $google2FA->generateSecretKey();
                $this->code = '';
                activity('enable2fa')->causedBy(auth()->user())->event('enable2fa')->withProperties(['ip_address',request()->ip()])->log('فعال سازی احراز هویت دو عاملی');
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('messages.Your two factor authentication enabled')]);
                $this->emit('2faChanged', true);
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('messages.One-time code is invalid')]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => __('messages.Your two factor authentication is already enabled')]);
            $this->dispatchBrowserEvent('toggle-kt_modal_add_ask_google2fa_code');
        }
    }

    public function downloadRecoveryPhrase(): StreamedResponse
    {
        // prepare content
        $content = "";
        foreach ($this->recoveryCodes as $code) {
            $content .= $code;
            $content .= "\n";
        }

        // file name that will be used in the download
        $fileName = "SolidVPN_recovery_codes.txt";

        // use headers in order to generate the download
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
        ];

        // make a response, with the content, a 200 response code and the headers
        return \response()->streamDownload(function () use ($content){
            echo $content;
        },$fileName,$headers,'attachment');
    }

    public function resetModal(){
        $this->resetValidation();
        $this->showRecoveryPhrase = false;
    }


    public function render()
    {
        return view('livewire.profile.manager.security.two-factor-authentication-modal');
    }
}
