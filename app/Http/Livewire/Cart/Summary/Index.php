<?php

namespace App\Http\Livewire\Cart\Summary;

use App\Core\Financial\CryptoCurrencies\BinanceCoin;
use App\Core\Financial\CryptoCurrencies\Bitcoin;
use App\Core\Financial\CryptoCurrencies\BitcoinCash;
use App\Core\Financial\CryptoCurrencies\Dogecoin;
use App\Core\Financial\CryptoCurrencies\Ethereum;
use App\Core\Financial\CryptoCurrencies\EthereumClassic;
use App\Core\Financial\CryptoCurrencies\Litecoin;
use App\Core\Financial\CryptoCurrencies\Tether;
use App\Core\Financial\CryptoCurrencies\Tron;
use App\Models\Cart;
use App\Models\Wallet;
use Endroid\QrCode\Color\Color;
use Livewire\Component;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Index extends Component
{
    public function mount(){
        $carts = auth()->user()->cart()->get();
        /** @var Cart $cart */
        foreach ($carts as $cart){
            if ($cart->plan->inventory === 0){
                $cart->delete();
            }
        }
        $carts = auth()->user()->cart()->get();
        if ($carts->count() == 0){
            $this->redirect(route('plans.buy'));
        }
    }


    public function render()
    {
        return view('livewire.cart.summary.index');
    }
}
