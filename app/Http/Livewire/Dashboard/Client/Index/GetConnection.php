<?php

namespace App\Http\Livewire\Dashboard\Client\Index;

use App\Models\Inbound;
use App\Models\User;
use App\Models\Option;
use App\Models\Server;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Livewire\Component;

class GetConnection extends Component
{
    public string $country_id = '';
    public ?string $server_id = '';

    public User $user;

    public string $operator = 'ALL';
    private int $server_row = 1;

    public string $subscriptionLink = "";


    public function mount(User $user): void
    {
        $this->user = $user;

        app('url')->forceRootUrl("https://".(Option::get('APP_URL'))."/");
        $this->subscriptionLink = URL::signedRoute('v2ray.subscription', ["uuid" => encrypt($user->uuid)]) ;
        app('url')->forceRootUrl("https://".request()->httpHost()."/");
    }

    public function rules() {
        return [
            'country_id' => ['required','numeric','exists:countries,id'],
            'server_id' => ['required','numeric','exists:servers,id'],
            'operator' => ['required','string',Rule::in(['ALL','MCI','TCI'])],
        ];
    }

    public function updated($field){
        $this->validateOnly($field,$this->rules());
    }

    public function getServers($country_id){
        $this->country_id = $country_id;
        $this->server_row = 1;
        $servers = $this->user->layer->servers()->where('active', true)->where('available', true)->where('country_id', $country_id)->get(['id','name','active','available','city','max_connections', 'tcp_count', 'udp_count'])->filter(function (Server $server){
            return $server->domains()->where('active',true)->count();
        })->map(function (Server $server) {
//            $status = $server->statuses()->latest()->limit(1)->first();
            $server->connections_load =  intval(min((($server->tcp_count + $server->udp_count) / $server->max_connections) * 100,100));
            $server->name = $server->city.'#'.convertNumbers($this->server_row++);
            return $server;
        });
        $this->dispatchBrowserEvent('appendServers',['servers' => $servers->toArray()]);
    }

    public function getOperators($server_id): void
    {
        $this->server_id = $server_id;
        /** @var Server $server */
        $server = Server::where('id',$server_id)->first();
        $operators = [];
        $operators[] = [
            'type' => 'ALL',
            'text' => 'همه اپراتور ها'
        ];
//        if ($server->domains()->where('cdn','ac')->where('active',true)->first()){
//            $operators[] = [
//                'type' => 'ALL',
//                'text' => 'همه اپراتور ها'
//            ];
//            $operators[] = [
//                'type' => 'TCI',
//                'text' => 'ایرانسل، مخابرات، پیشگامان'
//            ];
//        }
//        if ($server->domains()->where('cdn','cf')->where('active',true)->first()){
//            $operators[] = ['type' => 'MCI','text' => 'همراه اول، پارس آنلاین، مبین نت'];
//            $operators[] = ['type' => 'MCI','text' => 'آسیاتک، شاتل'];
//        }
        $this->dispatchBrowserEvent('appendOperators',['operators' => $operators]);
    }


    public function getConnection(): void
    {
        if (!auth()->user()->isManager() && !$this->user->hasVerifiedEmail() && (!empty(Option::get('clients_must_verify_email')))){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'لطفا ابتدا ایمیل خود را تایید نمایید' ,'timeOut' => '5000']);
            return;
        }
        if (!$this->user->hasActiveSubscription()){
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'لطفا ابتدا نسبت به خرید یا تمدید اشتراک خود اقدام نمایید','timeOut' => '5000']);
            return;
        }
        $this->validate($this->rules());
        $rateLimiterKey = "get-connection-".auth()->user()->id;
        if (RateLimiter::tooManyAttempts($rateLimiterKey,  1000)) {
            $seconds = RateLimiter::availableIn($rateLimiterKey);
            $this->dispatchBrowserEvent('alert',['type' => 'error', 'message' => "تعداد درخواست شما بیش از حد مجاز است. لطفا پس از $seconds ثانیه تلاش کنید"]);
            return;
        }
        $server = Server::find($this->server_id);
        $inbound = new Inbound();
        $inbound->layer($server->layer_id);
        try {
            $connectionInfo = $inbound->getConnectionConfig($this->user, $server, $this->operator);
        } catch (\Exception $e) {
            Log::error($e);
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'خطا در دریافت کانکشن، لطفا بعدا تلاش کنید']);
            return;
        }
        if ($connectionInfo == ""){
            Log::error("Connection creator returned null!");
            $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'خطا در دریافت کانکشن، لطفا بعدا تلاش کنید']);
            return;
        }
        activity('دریافت کانکشن')->event('getConnection')->causedBy(auth()->user())->performedOn($this->user)->withProperties(['server' => $server->toArray(),'operator' => $this->operator])->log('دریافت کانکشن');
        $connectionQrCode = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($connectionInfo)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->size(400)
            ->margin(3)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->validateResult(false);
        $connectionQrCodeDark = $connectionQrCode->backgroundColor(new Color(30, 30, 45))
            ->foregroundColor(new Color(255, 255, 255))->build()->getDataUri();
        $connectionQrCodeLight = $connectionQrCode->backgroundColor(new Color(255, 255, 255))
            ->foregroundColor(new Color(0, 0, 0))->build()->getDataUri();

        $this->dispatchBrowserEvent('show_connection',['connectionQrCodeDark' => $connectionQrCodeDark,'connectionQrCodeLight' => $connectionQrCodeLight,'link' => $connectionInfo]);
        RateLimiter::hit($rateLimiterKey);
    }
    public function dehydrate(){
        $this->dispatchBrowserEvent('livewire:dehydrate');
    }

    public function render()
    {
        return view('livewire.dashboard.client.index.get-connection');
    }
}
