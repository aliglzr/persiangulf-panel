<?php

namespace App\Http\Livewire\Authentication;

use App\Models\AuthToken;
use App\Models\Option;
use App\Models\User;
use App\Models\UserData;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;

class LoginWithTelegram extends Component
{
    public string $code = '';
    private string $altCode = '';
    public string $link = '';
    public string $bot = '';
    public string $step = 'waiting';
    public string $qrcode = '';


    public function getListeners(): array
    {
        return [
            "echo:LoginWithTelegram.".$this->code.",TelegramLoginCode" => 'telegramLoginCode',
            'refresh' => '$refresh'
        ];
    }

    private function refresh(): void
    {
        $this->emit('refresh');
    }

    public function telegramLoginCode($data): void
    {
        if(isset($data['code']) && isset($data['token'])) {
            /** @var AuthToken $authToken */
            $authToken = AuthToken::where('code', $data['code'])->where('token', $data['token'])->get()->first();
            if(empty($authToken)) {
                return;
            }
            if(now()->subMinutes(5) > $authToken->created_at) {
                $authToken->delete();
                $this->refresh();
                return;
            }
            $user = $authToken->user;

            auth()->loginUsingId($user->id);

            $authToken->delete();

            $user->setData('last_login', now());
            activity('ورود به حساب')->event('login')->causedBy($user)->withProperties(['ip_address', request()->ip()])->log('ورود به سایت');
            request()->session()->regenerate();
            session()->forget('intendedPath');

            $user->setData('telegram-ad-show', "not-showed");

            $this->step = 'logged-in';
            $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => 'خوش آمدید!','redirect' => route('dashboard'), 'timeOut' => 5000]);
        }
    }

    public function generateNewCode(): void
    {
        $this->code = AuthToken::newToken();

        $authToken = new AuthToken();
        $authToken->code = $this->code;
        $authToken->save();

        $this->altCode = $this->code;

        $this->link = "https://t.me/" . $this->bot . "?start=login_".$this->code;
        $qr = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($this->link)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->size(400)
            ->margin(3)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->validateResult(false);
        $this->qrcode = $qr->backgroundColor(new Color(0, 0, 0, 127))
            ->foregroundColor(new Color(0, 0, 0))->build()->getDataUri();
    }

    public function mount()
    {
        $this->bot = (Option::get('sales_bot_username') ?? "OfficialSolidVPNBot");
        $this->generateNewCode();

    }

    public function render()
    {
        return view('livewire.authentication.login-with-telegram')->layout('auth.layout');
    }



}