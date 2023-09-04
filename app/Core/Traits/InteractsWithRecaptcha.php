<?php


namespace App\Core\Traits;


use Illuminate\Support\Facades\Http;

trait InteractsWithRecaptcha
{
    public function validateRecaptchaRequest($captchaToken)
    {
        $captchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $captchaToken,
        ])->json();

        return $captchaResponse['success'];
    }

    public function resetRecaptchaComponent()
    {
        $this->dispatchBrowserEvent('reset-google-recaptcha');
    }
}
